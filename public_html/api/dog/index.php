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
	$_SESSION["profile"] = Profile::getProfileByProfileId($pdo, 1);
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
		//sanitize input

	$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
	$dogProfileId = filter_input(INPUT_GET, "dogProfileId", FILTER_VALIDATE_INT);
	$dogAge = filter_input(INPUT_GET, "dogAge", FILTER_VALIDATE_INT);
	$dogCloudinaryId = filter_input(INPUT_GET, "dogCloudinaryId", FILTER_VALIDATE_INT);
	$dogBio = filter_input(INPUT_GET, "dogBio", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$dogBreed = filter_input(INPUT_GET, "dogBreed", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$dogAtHandle = filter_input(INPUT_GET, "dogAtHandle", FILTER_VALIDATE_INT);

	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true || $id < 0)) {
		throw(new InvalidArgumentException("ID can't be empty or negative", 405));
	}
// handle GET request - if id is present, that dog is returned, otherwise all dogs are returned
	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();
		//get a specific dog and update reply
		if(empty($id) === false) {
			$dog = Dog::getDogByDogId($pdo, $id);
			if($dog !== null) {
				$reply->data = $dog;
			}
		} else if(empty($dogProfileId) === false) {
			$dog = Dog::getDogByDogProfileId($pdo, $dogProfileId)->toArray();
			if($dog !== null) {
				$reply->data = $dog;
			}
		} else if(empty($dogBreed) === false) {
			$dog = Dog::getDogByDogBreed($pdo, $dogBreed)->toArray();
			if($dog !== null) {
				$reply->data = $dog;
			}
		}

	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		//Retrieves JSON package and stores result in $requestObject
		$requestObject = json_decode($requestContent);
		//Decode JSON package and store result in $requestObject


		if(empty($requestObject->dogProfileId) === true) {
			throw(new \InvalidArgumentException("No Dog Profile ID", 405));
		}
		if(empty($requestObject->dogAge) === true) {
			$requestObject->dogAge = null;
		}
		if(empty($requestObject->dogCloudinaryId) === true) {
			$requestObject->dogCloudinaryId = null;
		}
		if(empty($requestObject->dogBio) === true) {
			$requestObject->dogBio = null;
		}
		//make sure dog breed is accurate (optional field)
		if(empty($requestObject->dogBreed) === true) {
			$requestObject->dogBreed = null;
		}
		if(empty($requestObject->dogAtHandle) === true) {
			$requestObject->dogAtHandle = null;
		}


		//perform the put or post
		if($method === "PUT") {
			//retrieve the dog to update
			$dog = Dog::getDogByDogId($pdo, $id);
			if($dog === null) {
				throw(new RuntimeException("Dog does not exist", 404));

			}
			//enforce the user is signed in and only attempting to edit their own dog
			if(empty($_SESSION["profile"]) === true || $_SESSION["profile"]->getProfileId() !== $dog->getDogProfileId()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this dog", 403));
			}
//update all attributes
			$dog->setDogAge($requestObject->dogAge);
			$dog->setDogAtHandle($requestObject->dogAtHandle);
			$dog->setDogBio($requestObject->dogBio);
			$dog->setDogBreed($requestObject->dogBreed);
			$dog->setDogCloudinaryId($requestObject->dogCloudinaryId);
			$dog->update($pdo);
			//update reply
			$reply->message = "Dog updated successfully";
		} else if($method === "POST") {
			//ensure that the user is signed in
			if(empty($_SESSION["profile"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post things about your dog", 403));
			}
			//create new dog and insert into database
			$dog = new Dog(null, $requestObject->dogProfileId, $requestObject->dogAge, $requestObject->dogCloudinaryId, $requestObject->dogBio, $requestObject->dogBreed, $requestObject->dogAtHandle);
			$dog->insert($pdo);

			//update reply
			$reply->message = "Dog created successfully";
		}
	} else {
			throw (new InvalidArgumentException("Invalid HTTP method request"));
	}

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