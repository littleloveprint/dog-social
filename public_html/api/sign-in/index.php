<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/barkparkz.ini");

use Edu\Cnm\BarkParkz\Profile;

/**
 * api for sign-in
 * @author Gerrit Van Dyke
 */

//prepare empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//start session
	if(session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}

	//grab mySQL statement
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");

	//determine the http method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? _SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	//if method is post handle the sign in logic
	if($method === "POST") {

		//ensure XSRF token is valid
		verifyXsrf();

		//process the request content and decode the json object into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//ensure the password and email fields are not empty
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException("Invalid email address", 401));
		} else {
			$profileEmail = filter_var($requestObject->profileEmail, FILTER_SANITIZE_EMAIL);

		}
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException("Password is required", 401));
		} else {
			$profilePassword = $requestObject->profilePassword;
		}
		//grab the profile from the database by the email provided
		$profile = Profile::getProfileByProfileEmail($pdo, $profileEmail);
		if(empty($profile) === true) {
			throw(new \InvalidArgumentException("Invalid Email", 401));
		}
		//if the profile activation is not null throw an error
		if($profile->getProfileActivationToken() !== null) {
			throw(new \InvalidArgumentException("you must activate your profile before signing in", 403));
		}
		//hash the password given to ensure it matches
		$hash = hash_pbkdf2("sha512", $profilePassword, $profile->getProfileSalt(), 262144);
		//verify hash is correct
		if($hash !== $profile->getProfileHash()) {
			throw(new \InvalidArgumentException("Password or email is incorrect"));

		}
		//grab profile from database and put into a session
		$profile = Profile::getProfileByProfileId($pdo, $profile->getProfileId());
		$_SESSION["profile"] = $profile;
		$reply->message = "Sign in was successful.";
	} else {
		throw(new \InvalidArgumentException("Invalid HTTP method request."));

	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);
