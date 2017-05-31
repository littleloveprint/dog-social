<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");
use Edu\CNM\BarkParkz\{
	Profile,
	Dog
};
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
	//sanitize input
	$profileCloudinaryId = filter_input(INPUT_GET, "$profileCloudinaryId", FILTER_VALIDATE_INT,FILTER_FLAG_NO_ENCODE_QOUTES);
	$dogCloudinaryId = filter_input(INPUT_GET, "$dogCloudinaryId", FILTER_VALIDATE_INT,FILTER_FLAG_NO_ENCODE_QOUTES);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE") && (empty($profileCloudinaryId) === true || $profileCloudinaryId < 0)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}
}