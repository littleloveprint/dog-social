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

