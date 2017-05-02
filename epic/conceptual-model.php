<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">

		<title>Conceptual Model</title>
	</head>
	<body>
		<header>
			<h1>Conceptual Model</h1>
		</header>
		<main>
			<h2>Entities &amp; Attributes</h2>
			<h3>Profile</h3>
			<ul>
				<li>profileId</li>
				<li>profileActivationToken</li>
				<li>profileAtHandle</li>
				<li>profileEmail</li>
				<li>profileHash</li>
				<li>profileLocationX</li>
				<li>profileLocationY</li>
				<li>profileSalt</li>
			</ul>
			<h3>Dog</h3>
			<ul>
				<li>dogId</li>
				<li>dogProfileId</li>
				<li>dogAge</li>
				<li>dogBio</li>
				<li>dogBreed</li>
				<li>dogDogTag</li>
			</ul>
			<h3>Park</h3>
			<ul>
				<li>parkId</li>
				<li>parkLocationX</li>
				<li>parkLocationY</li>
				<li>parkName</li>
			</ul>
			<h3></h3>
			<h3>Check-In</h3>
			<ul>
				<li>checkInId</li>
				<li>checkInDogId</li>
				<li>checkInParkId</li>
				<li>checkInDateTime</li>
				<li>checkOutDateTime</li>
			</ul>
			<h3>Favorite</h3>
			<ul>
				<li>favoriteProfileId</li>
				<li>favoriteParkId</li>
			</ul>
			<h3>Friend</h3>
			<ul>
				<li>friendFirstProfileId</li>
				<li>friendSecondProfileId</li>
			</ul>
			<h2>Relationships</h2>
			<ul>
				<li>Many profiles can check into many parks.</li>
				<li>Many profiles can favorite many parks.</li>
				<li>Many profiles can friend many profiles.</li>
				<li>One profile can have many dogs.</li>
			</ul>
			<p><strong>Subject:</strong>Shawn<br><strong>Verb:</strong>Checks into<br><strong>Object:</strong>Park</p>
			<h2><img src="images/dog-social.svg" alt="erd for dog-social"></h2>
		</main>
	</body>
</html>