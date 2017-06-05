<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

// grab the class under scrutiny
use Edu\Cnm\BarkParkz\Favorite;


/** Api for the favorite class
 *
 * @author Michael Jordan mj@mjcodes.com
 **/
// verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
// prepare and empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data=null;

try {
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	// mock a logged in user by mocking the session and assigning a specific user to it.
	// this is only for testing purposes and should not be in the live code.
	//$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 732);
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	var_dump($method);
	//sanitize the search parameters
	$favoriteProfileId = filter_input(INPUT_GET, "favoriteProfileId", FILTER_VALIDATE_INT);
	$favoriteParkId = filter_input(INPUT_GET, "favoriteParkId", FILTER_VALIDATE_INT);
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//gets a specific favorite associated based on its composite key
		if ($favoriteProfileId !== null && $favoriteParkId !== null){
			$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteParkId($pdo, $favoriteProfileId, $favoriteParkId);
			if($favorite!== null){
				$reply->data = $favorite;
			}
			//if none of the search parameters are met throw an exception
		} else if(empty($favoriteProfileId) === false){
			$favorite = Favorite::getFavoritesByFavoriteProfileId($pdo, $favoriteProfileId)->toArray();
			if($favorite !== null) {
				$reply->data = $favorite;
			}
			//get all the favorites associated with the park id
		} else if(empty($favoriteParkId) === false) {
			$favorite = Favorite::getFavoriteByFavoriteParkId($pdo, $favoriteParkId)->toArray();
			if($favorite !== null) {
				$reply->data = $favorite;
			}
		} else {
			throw new InvalidArgumentException("incorrect search parameters", 404);
		}
		} else if($method === "POST" || $method === "PUT"){
			//decode the response from the front end
			$requestContent = file_get_contents("php://input");
			$requestObject = json_decode($requestContent);
			if(empty($requestObject->favoriteProfileId) === true){
				throw (new \InvalidArgumentException("no profile linked to the favorite", 405));
			}
			if(empty($requestObject->favoriteParkId) === true){
				throw (new \InvalidArgumentException("No park linked to the favorite", 405));
			}
			if($method === "POST") {
				//enforce the user is signed in
				if(empty($_SESSION["profile"]) === true){
					throw(new \InvalidArgumentException("you must be logged in to favorite parks", 403));
				}
				$favorite = new Favorite($requestObject->favoriteProfileId, $requestObject->favoriteParkId);
				$favorite->insert($pdo);
				$reply->message = "Favorite park successful";
			} else if ($method === "PUT") {
				//enforce that the end user has a XSRF token
				verifyXsrf();
				//grab the favorite by its composite key
				$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteParkId($pdo, $requestObject->favoriteProfileId, $requestObject->favoriteParkId);
				if($favorite === null) {
					throw (new RuntimeException("Favorite does not exist"));
				}
				//enforce the user is signed in and only trying to edit their own favorite
				if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $favorite->getFavoriteProfileId()) {
					throw(new \InvalidArgumentException("You are not allowed to delete this favorite", 403));
			}
			//perform the actual delete
				$favorite->delete($pdo);
				//update the message
				$reply->message = "Favorite successfully delete";
		}
		//if any other HTTP request is sent throw an exception
	} else {
			throw new \InvalidArgumentException("invalid http request", 400);
		}
		//catch any exceptions that is thrown and update the reply status and message
	} catch(\Exception | \TypeError $exception){
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}
	header("Content-type: application/json");
	if($reply->data === null) {
		unset($reply->data);
	}
	// encode and return reply to front end caller
echo json_encode($reply);

