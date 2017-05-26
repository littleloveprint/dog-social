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
	$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/barkparkz.ini");

	// Determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
// to do: Add verify xsrf method
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

		// Insert the profile into the database
		$profile->insert($pdo);

		// Compose the email message to send with the activation token
		$messageSubject = "Account Activation";

		// Building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account -- Make sure the URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		// Create the path
		$urlglue = $basePath . "/api/activation/?activation=" . $profileActivationToken;

		// Create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

		// Compose message to send with email
		$message = <<< EOF
<h2>Welcome to Bark Parkz!.</h2>
<p>Please confirm your account, so you can view and check into parks, make friends, and update your information.</p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;
		// Create swift email
		$swiftMessage = Swift_Message::newInstance();

		// Attach the sender to the message -- This takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["littleloveprint@gmail.com" => "BarkParkzAdmin"]);

		/**
		 * Attach recipients to the message.
		 * Notice this is an array that can include or omit the recipient's name.
		 * Use the recipient's real name where possible -- This reduces the probability of the email is marked as spam.
		 **/

		// Define who the recipient is
		$recipients = [$requestObject->profileEmail];

		// Set the recipient to the swift message
		$swiftMessage->setTo($recipients);

		// Attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);

		/**
		 * Attach the message to the email.
		 * Set two versions of the message: a html formatted version and a filter_var()ed version of the message, plain text.
		 * Notice the tactic used is to display the entire $confirmLink to plain text -- This lets users who are not viewing the html content to still access the link.
		 **/

		// Attach the html version fo the message
		$swiftMessage->setBody($message, "text/html");

		// Attach the plain text version of the message
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		/**
		 * Send the Email via SMTP; the SMTP server here is configured to relay everything upstream via CNM.
		 * This default may or may not be available on all web hosts; consult their documentation/support for details.
		 * SwiftMailer supports many different transport methods; SMTP was chosen because it's the most compatible and has the best error handling.
		 * @see http://swiftmailer.org/docs/sending.html Sending Messages - Documentation - SwitftMailer
		 **/

		// Setup smtp
		$smtp = Swift_SmtpTransport::newInstance("localhost", 25);
		$mailer = Swift_Mailer::newInstance($smtp);

		// Send the message
		$numSent = $mailer->send($swiftMessage, $failedRecipients);

		/**
		 * The send method returns the number of recipients that accepted the Email.
		 * If the number attempted is not the number accepted, this is an Exception.
		 **/
		if($numSent !== count($recipients)) {

			// The $failedRecipients parameter passed in the send() method now contains contains an array of the Emails that failed
			throw(new RuntimeException("unable to send email"));
		}

		// Update reply
		$reply->message = "Thank you for creating a Bark Parkz profile!";
	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}
} catch(\Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
} catch(\TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
header("Content-type: application/json");
echo json_encode($reply);