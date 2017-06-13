
<!-- HEAD -->
<?php require_once("library/head-utils.php");?>

<body class="sfooter">
	<div class="sfooter-content">

		<!-- HEADER AND NAVBAR -->
		<?php require_once("library/header.php");?>

		<main class="class">
			<form class="form-horizontal">
				<fieldset>
					<!-- Map -->
<!DOCTYPE html>
<html>
	<head>
		<style>
			#map {
				height: 400px;
				width: 100%;
			}
		</style>
	</head>
	<body>
		<h3>Search Parks</h3>
		<h4>Click on a featured park to get directions!</h4>
		<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=dog%20parks%20near%20Albuquerque%2C%20NM%2C%20United%20States&key=AIzaSyBLthzUq1SMAb5GKh6x60l2Oe3ltFyfHRs" allowfullscreen></iframe>

		<div id="map"></div>
		<script>
			function initMap() {
				var uluru = {lat: 35, lng: -106};
				var map = new google.maps.Map(document.getElementById('map'), {
					zoom: 4,
					center: uluru
				});
				var marker = new google.maps.Marker({
					position: uluru,
					map: map
				});
			}
		</script>
	</body>
</html>