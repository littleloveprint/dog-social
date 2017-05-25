<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\CNM\BarkParkz\{
	CheckIn,
	Profile
};
/**
 * API for the CheckIn class
 *
 * @author Michael Jordan mj@mjcodes.com
 **/
//verify the session start if not active
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);
	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$checkInId = filter_input(INPUT_GET, "checkInId", FILTER_VALIDATE_INT);
	$checkInDogId = filter_input(INPUT_GET, "checkInDogId", FILTER_VALIDATE_INT);
	$checkInParkId = filter_input(INPUT_GET, "checkInParkId", FILTER_VALIDATE_INT);
	$sunriseCheckInDateTime = filter_input(INPUT_GET, "$sunriseCheckInDateTime", FILTER_VALIDATE_INT);
	$sunsetCheckInDateTime = filter_input(INPUT_GET, "$sunsetCheckInDateTime", FILTER_VALIDATE_INT);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)){
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	//handle GET request - if id is present that checkIn is returned, otherwise all tweets are returned
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific checkIn or all checkIns and update reply
		if(empty($id) === false){
			$checkIn = CheckIn::getCheckInByCheckInId($pdo, $id);
			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
		} else if(empty($checkInDogId) === false) {
			$checkIn = CheckIn::getCheckInByCheckInDogId($pdo, $checkInDogId)->toArray();
			if($checkIn !== null) {
				$reply->data = $checkIn;
			}
		} else if(empty($checkInParkId) === false){
			$checkIn = CheckIn::getCheckInByCheckInParkId($pdo, $checkInParkId)->toArray();
			if($checkIn !== null){
				$reply->data = $checkIn;
			}
		} else if(empty($checkInDateTime) === false){
			$checkIn = CheckIn::getCheckInByCheckInDateRange($pdo, $sunriseCheckInDateTime, $sunsetCheckInDateTime)->toArray();
			if($checkIn !== null){
				$reply->data = $checkIn;
			}
		}
	}
}