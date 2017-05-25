<?php
require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/classes/autoload.php");
require_once(dirname(__DIR__, 3) . "/php/lib/xsrf.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use Edu\Cnm\BarkParkz\ {
	Profile,
	Friend
};

/**
 * API for the Friend class
 *
 * @author Lea McDuffie <lea@littleloveprint.io>
 * @version 1.0
 **/

// Verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

// Prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	$pdo = connectToEncryptedMySQL("etc/apache2/capstone-mysql/barkparkz.ini");

	// Mock a logged in user by mocking the session and assigning a specific user to it. This is only for testing purposes and should not be in the live code.
	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 722);

	// Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];

	// Sanitize the search parameters
	$friendFirstProfileId = filter_input(INPUT_GET, "friendFirstProfileId", FILTER_VALIDATE_INT);
	$friendSecondProfileId = filter_input(INPUT_GET, "friendSecondProfileId", FILTER_VALIDATE_INT);
	if($method === "GET") {

		// Set XSRF cookie
		setXsrfCookie();

		// Gets  a specific friend based on its composite key
		if ($friendFirstProfileId !== null && $friendSecondProfileId !== null) {
			$friend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($pdo, $friendFirstProfileId, $friendSecondProfileId);
			if($friend!== null) {
				$reply->data = $friend;
			}
