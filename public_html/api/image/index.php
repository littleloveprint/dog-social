<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * Api for the cloudinary images that will magically work with out a class YATA
 *
 * @autho Michael Jordan mj@mjcodes.com
 **/

//verify the session, start if inactive
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");
	//cloudinary api stuff
	$config = readConfig("/etc/apache2/capstone-mysql/barkparkz.ini");
	$cloudinary = json_decode($config["cloudinary"]);
	\Cloudinary::config(["cloud_name" => $cloudinary->cloudName, "api_key" => $cloudinary->apiKey, "api_secret" => $cloudinary->apiSecret]);
	//determine which http method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		verifyXsrf();
		//verify user logged in
		if(empty($_SESSION["profile"]) === true){
			throw(new \InvalidArgumentException("You are not allowed to post images unless you are logged in", 401));
		}
		//assigning variables to the user image name, MIME type, and image extension
		$tempUserFileName = $_FILES["file"]["tmp_name"];
		//upload image to cloudinary and get public id
		$cloudinaryResult = \Cloudinary\Uploader::upload($tempUserFileName, ["width"=>500, "crop"=>"scale"]);
		//after sending the image to Cloudinary, grab the public id and create a new image
		$reply->data = $cloudinaryResult["public_id"];
		$reply->message = "Image upload ok";
	} else{
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
// encode and return reply to front end caller
echo json_encode($reply);