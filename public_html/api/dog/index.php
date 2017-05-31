<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\BarkParkz\Profile;
use Edu\Cnm\BarkParkz\Dog;

/**
 * API for Dog class
 * @author Gerrit Van Dyke
 *
 **/
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	//simulate a logged in profile by mocking the session and assigning a user to it
	//for testing only, should not be in the live code
	//$_SESSION["profile] = Profile::getProfileByProfileId($pdo, 732);
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] :
	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$dogId = filter_input(INPUT_GET, "dogId",FILTER_VALIDATE_INT);
	$dogProfileId = filter_input(INPUT_GET, "dogProfileId", FILTER_VALIDATE_INT);
	$dogAge = filter_input(INPUT_GET, "dogAge", FILTER_VALIDATE_INT);
	$dogCloudinaryId = filter_input(INPUT_GET, "dogCloudinaryId", FILTER_VALIDATE_INT);
	$dogBio = filter_input(INPUT_GET, "dogBio", FILTER_VALIDATE_INT);
	$dogBreed = filter_input(INPUT_GET, "dogBreed", FILTER_VALIDATE_INT);
	$dogAtHandle = filter_input(INPUT_GET, "dogAtHandle", FILTER_VALIDATE_INT);
if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("ID can't be empty or negative", 405));
	}


}



