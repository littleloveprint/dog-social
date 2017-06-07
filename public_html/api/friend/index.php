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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");

	// Mock a logged in user by mocking the session and assigning a specific user to it. This is only for testing purposes and should not be in the live code.

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
			if($friend !== null) {
				$reply->data = $friend;
			}
			// If none of the search parameters are met, throw an exception.
		} else if(empty($friendFirstProfileId) === false) {
			$friend = Friend::getFriendByFriendFirstProfileId($pdo, $friendFirstProfileId)->toArray();
			if($friend !== null) {
				$reply->data = $friend;
			}
		} else {
			throw new InvalidArgumentException("Incorrect search parameters ", 404);
		}
	} else if($method === "POST" || $method === "PUT") {

		// Decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		if(empty($requestObject->friendFirstProfileId) === true) {
			throw (new \InvalidArgumentException("No Profile found, so no friends :(", 405));
		}
		if(empty($requestObject->friendSecondProfileId) === true) {
			throw (new \InvalidArgumentException("No Friends found", 405));
		}
		if($method === "POST") {

			// Enforce the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("You must be logged in to have and find friends.", 403));
			}
			$friend = new Friend($requestObject->friendFirstProfileId, $requestObject->friendSecondProfileId);
			$friend->insert($pdo);
			$reply->message = "You have a new friend!";
		} else if($method === "PUT") {

			// Enforce that the end user has an XSRF token.
			verifyXsrf();

			// Grab the friend by its composite key
			$friend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($pdo, $requestObject->friendFirstProfileId, $requestObject->friendSecondProfileId);
			if($friend === null) {
				throw (new RuntimeException("Friend does not exist."));
			}

			// Enforce the user is signed in and only trying to edit their own friends.
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $friend->getFriendFirstProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to delete this friend.", 403));
			}

			// Preform the actual delete
			$friend->delete($pdo);

			// Update the message
			$reply->message = "You've deleted a friend.";
		}

		// If any other HTTP request is sent, throw an exception.
	} else {
		throw new \InvalidArgumentException("invalid http request", 400);
	}

	// Catch any exceptions that are thrown, and update the reply status and message.
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// Encode and return reply to front end caller
echo json_encode($reply);