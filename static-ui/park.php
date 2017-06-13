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
		<script async defer
				  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhczI6nGkNcC3Gpe-CJKzRZ-r18s9eyv8&callback=initMap">
		</script>
	</body>
</html>