<?php
require_once dirname(__DIR__,3)."/php/classes/autoload.php";
require_once dirname(__DIR__,3)."/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\CNM\BarkParkz\Profile;
/**
 * API to check profile activation status
 * @author Michael Jordan mj@mjcodes.com
 **/
//Check the session. If it is not active, start the session
if(session_status() !== PHP_SESSION_ACTIVE){
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try{
	//grab the MySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	//check the HTTP method being used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize the input never trust the end user
	$activation = filter_input(INPUT_GET, "activation", FILTER_SANITIZE_STRING);
	//make sure the activation token is the correct size
	if(strlen($activation) !== 32){
		throw(new InvalidArgumentException("activation has an incorrect length",405));
	}
	//verify that the activation token is a string value of a hexadecimal
	if(ctype_xdigit($activation) === false){
		throw(new \InvalidArgumentException("activation is empty or has invalid contents, 405"));
	}
	//handle the get http request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		$profile = Profile::getProfileByProfileActivationToken($pdo, $activation);
		if(empty($profile)) {
			throw(new \InvalidArgumentException("No profile for Activation"));
		}
		$profile->setProfileActivationToken(null);
		$profile->update($pdo);
		$reply->message = "Profile Activated";
	}else{
		throw (new\Exception("Invalid HTTP method"));
	}
	// update reply with exception information
} catch (Exception $exception){
			$reply->status = $exception->getCode();
			$reply->message = $exception->getMessage();
		} catch(TypeError $typeError){
			$reply->status = $typeError->getCode();
			$reply->message = $typeError->getMessage();
		}
		//prepare and send the reply
		header("Content-type: application/json");
		if($reply->data === null) {
			unset($reply->data);
		}
		echo json_encode($reply);