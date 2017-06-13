<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
require_once ("../php/lib/xsrf.php");
setXsrfCookie();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/"; ?>" />

		<title>Bark Parkz</title>
	</head>
	<body>
		<bark-parkz>Bark Parkz IS THE BEST</bark-parkz>
	</body>
</html>