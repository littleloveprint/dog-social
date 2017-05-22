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
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ?_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

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


	}
}