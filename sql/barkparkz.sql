DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS checkIn;
DROP TABLE IF EXISTS park;
DROP TABLE IF EXISTS friend;
DROP TABLE IF EXISTS dog;
DROP TABLE IF EXISTS profile;

-- Create the profile entity
CREATE TABLE profile (
 -- This creates the attribute for the primary key.
 -- Auto_increment tells mySQL to number them {1, 2, 3, etc}
 -- Not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- ^Primary Key^
	profileActivationToken VARCHAR(32),
	profileAtHandle VARCHAR(32) NOT NULL,
	profileCloudinaryId VARCHAR(32),
	profileEmail VARCHAR(64) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileLocationX DECIMAL(12,9),
	profileLocationY DECIMAL(12,9),
	UNIQUE(profileEmail),
	UNIQUE(profileAtHandle),
	PRIMARY KEY(profileId)
);

 -- Create the dog entity
CREATE TABLE dog (
	dogId INT UNSIGNED AUTO_INCREMENT,
	-- ^Primary Key^
	dogProfileId INT UNSIGNED NOT NULL,
	dogAge TINYINT UNSIGNED,
	dogCloudinaryId VARCHAR(32),
	dogBio VARCHAR(255),
	dogBreed VARCHAR(50),
	dogAtHandle VARCHAR(32),
	INDEX(dogProfileId),
	INDEX(dogBreed),
	-- ^this creates an index before creating a foreign key
	FOREIGN KEY(dogProfileId) REFERENCES profile(profileId),
	-- ^this creates the foreign key
	PRIMARY KEY(dogId)
	 -- ^this creates the primary key
);

 -- Create the friend entity
CREATE TABLE friend (
	friendFirstProfileId INT UNSIGNED NOT NULL,
	friendSecondProfileId INT UNSIGNED NOT NULL,
	INDEX(friendFirstProfileId),
	INDEX(friendSecondProfileId),
	-- this creates an index before creating a foreign key
	FOREIGN KEY(friendFirstProfileId) REFERENCES profile(profileId),
	 -- this creates the foreign key
	FOREIGN KEY(friendSecondProfileId) REFERENCES profile(profileId),
	PRIMARY KEY(friendFirstProfileId, friendSecondProfileId)
);

 -- Create the park entity
CREATE TABLE park (
	parkId INT UNSIGNED AUTO_INCREMENT,
	parkLocationX DECIMAL(12,9) NOT NULL,
	parkLocationY DECIMAL(12,9) NOT NULL,
	parkName VARCHAR(32),
	INDEX(parkName),
	PRIMARY KEY(parkId)

);
	 -- Create the checkIn entity
CREATE TABLE checkIn (
	checkInId INT UNSIGNED AUTO_INCREMENT,
	checkInDogId INT UNSIGNED NOT NULL,
	checkInParkId INT UNSIGNED NOT NULL,
	checkInDateTime DATETIME(6) NOT NULL,
	checkOutDateTime DATETIME(6) NOT NULL,
	INDEX(checkInDogId),
	INDEX(checkInParkId),
	-- This creates an index for a foreign key
	FOREIGN KEY(checkInDogId) REFERENCES dog(dogId),
	 -- ^this creates the foreign key
	FOREIGN KEY(checkInParkId) REFERENCES park(parkId),
	PRIMARY KEY(checkInId)

);

	CREATE TABLE favorite (
		favoriteProfileId INT UNSIGNED NOT NULL,
		favoriteParkId INT UNSIGNED NOT NULL,
		INDEX(favoriteProfileId),
		INDEX(favoriteParkId),
		 -- ^this creates an index for a foreign key
		FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
		FOREIGN KEY(favoriteParkId) REFERENCES park(parkId),
		PRIMARY KEY(favoriteProfileId, favoriteParkId)
	);

-- Insert the Park names and longitude and latitude into park
INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.195141, -106.727580, "Bud Warren & Lady Dog Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.130309,-106.495969, "Coronado Dog Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.104089, -106.647067, "Los Altos Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.086035, -106.532630, "Montessa Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.017610, -106.597446, "North Domingo Baca");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.179617, -106.560866, "Ouray Dog Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.114312, -106.720834, "Rio Grande Triangle Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.081152, -106.666474, "Roosevelt Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (39.945025, -75.150165, "Santa Fe Village Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.149121, -106.716760, "Tom Bolack Urban Forest Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (42.419994, -96.416095, "Tower Pond Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.063641, -106.730410, "USS Bullhead Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.052559, -106.576822, "Westgate Dog Park");

INSERT INTO park
(parkLocationX, parkLocationY, parkName)
VALUES (35.049210, -106.741209, "Cartagena/ValleyView");

