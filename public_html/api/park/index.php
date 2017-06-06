<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
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
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$parkName = filter_input(INPUT_GET, "parkName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//if none of the search parameters are met throw an exception
		if(empty($id) === false) {
			$park = Park::getParkByParkId($pdo, $id);
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
			$park = Park::getAllParks($pdo);
			if($park !== null) {
				$reply->data = $park;
			}
		}
	} else {
		throw (new InvalidArgumentException("Invalid http request"));
	}
}// Catch any exceptions that were thrown
catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);