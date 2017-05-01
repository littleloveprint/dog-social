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
				<li>profileDogs</li>
				<li>profileEmail</li>
				<li>profileHash</li>
				<li>profileSalt</li>
			</ul>
			<h3>Check-In</h3>
			<ul>
				<li>checkInProfileId</li>
				<li>checkInParkId</li>
				<li>checkInDate</li>
			</ul>
			<h3>Dog</h3>
			<ul>
				<li>dogId</li>
				<li>dogProfileId</li>
				<li>dogAge</li>
				<li>dogBio</li>
				<li>dogBreed</li>
				<li>dogDogTag</li>
				<li>dogPersonality</li>
			</ul>
			<h3>Park</h3>
			<ul>
				<li>parkId</li>
				<li>parkLocation</li>
				<li>parkReviews</li>
				<li>parkRules</li>
			</ul>
			h3>Schedule</h3>
			<ul>
				<li>scheduleProfileId</li>
				<li>scheduleParkId</li>
				<li>scheduleDate</li>
			</ul>
			<h2>Relationships</h2>
			<ul>
				<li>Many users can check into many parks.</li>
			</ul>
			<p><strong>Subject:</strong>Shawn<br><strong>Verb:</strong>Verb goes here<br><strong>Object:</strong>Object goes here</p>
		</main>
	</body>
</html>