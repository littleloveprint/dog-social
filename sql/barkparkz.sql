DROP TABLE IF EXISTS 'favorite';
DROP TABLE IF EXISTS 'checkIn';
DROP TABLE IF EXISTS 'park';
DROP TABLE IF EXISTS 'friend';
DROP TABLE IF EXISTS 'dog';
DROP TABLE IF EXISTS 'profile';

-- Create the profile entity
CREATE TABLE profile (
 -- This creates the attribute for the primary key.
 -- Auto_increment tells mySQL to number them {1, 2, 3, etc}
 -- Not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- ^Primary Key^
	profileActivationToken VARCHAR(32) NOT NULL,
	profileAtHandle VARCHAR(32) NOT NULL,
	profileCloudinaryId VARCHAR(32),
	profileEmail VARCHAR(64) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileLocationX DECIMAL(12,9) NOT NULL,
	profileLocationY DECIMAL(12,9) NOT NULL,
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
	-- This creates an index for a foreign key
	FOREIGN KEY(checkInDogId) REFERENCES dog(dogId),
	 -- ^this creates the foreign key
	INDEX(checkInParkId),
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