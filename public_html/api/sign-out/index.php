<?php
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once ("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * api used to sign out
 * @author Gerrit Van Dyke
 **/

//verify the xsrf challenge
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare the default error message
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
if($method === "GET") {
	$_SESSION = [];
}
else {
	throw(new \InvalidArgumentException("Invalid HTTP method request"));

}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}
echo json_encode($reply);