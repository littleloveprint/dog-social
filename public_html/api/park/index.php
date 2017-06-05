<?php

require_once dirname(__DIR__, 3) . "/vendor/auroload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\BarkParkz\{
	Park
};

/**
 * Api for Park class
 *
 * @author Emily Halleran
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	$parkId = filter_input(INPUT_GET,"parkId",FILTER_VALIDATE_INT);
	$parkName = filter_input(INPUT_GET,"parkName",FILTER_VALIDATE_INT);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//gets all parks
		if($parkId !== null && $parkName !== null) {
			$park = Park::getParkByParkIdAndParkName($pdo, $parkId, $parkName);

			if($park !== null) {
				$reply->data = $park;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($parkId) === false) {
			$park = Park::getParkByParkId($pdo, $parkId)->toArray();
			if($park !== null) {
				$reply->data = $park;
			}
			//get all the parks associated with the parkName
		} else if(empty($parkName) === false) {
			$park = Park::getParkByParkName($pdo, $parkName)->toArray();

			if($park !== null) {
				$reply->data = $park;
			}
			//if any other HTTP request is sent, throw an exception
		} else {
			throw new InvalidArgumentException("incorrect search parameters", 404);
		}
	}

	// Catch any exceptions that were thrown
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);