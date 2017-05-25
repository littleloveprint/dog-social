<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\BarkParkz\Profile;

/**
 * API for the sign up class
 *
 * @author Lea McDuffie <lea@littleloveprint.io>
 * @version 1.0
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {

	// Grab the mySQL connection
	$pdo = connectToEncryptedMySQL("etc/apache2/capstone-mysql/barkparkz.ini");

	// Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {

		// Decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		// Profile at handle is a required field
		if(empty($requestObject->profileAtHandle) === true) {
			throw(new \InvalidArgumentException ("No profile at handle", 405));
		}

		// If cloudinary id is empty, set it too null
		if(empty($requestObject->profileCloudinaryId) === true) {
			$requestObject->profileCloudinaryId = null;
		}

		// Profile email is a required field
		if(empty($requestObject->profileEmail) === true) {
			throw(new \InvalidArgumentException ("No profile email present.", 405));
		}

		// Verify that profile password is present
		if(empty($requestObject->profilePassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password.", 405));
		}

		// Verify that the confirm password is present
		if(empty($requestObject->profilePasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid confirmed password.", 405));
		}

		// Make sure the password and confirm password match
		if ($requestObject->profilePassword !== $requestObject->profilePasswordConfirm) {
			throw(new \InvalidArgumentException("Passwords do not match."));
		}
		$salt = bin2hex(random_bytes(32));
		$hash = hash_pbkdf2("sha512", $requestObject->profilePassword, $salt, 262144);
		$profileActivationToken = bin2hex(random_bytes(16));

		// Create the profile object and prepare to insert into the database
		$profile = new Profile(null, $profileActivationToken, $requestObject->profileAtHandle, null, $requestObject->profileEmail, $hash, $salt, 43.5945, 83.8889);
		