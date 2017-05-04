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
	profileEmail VARCHAR(64) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileLocationX DECIMAL(3,9) NOT NULL,
	profileLocationY DECIMAL(3,9) NOT NULL,
	UNIQUE(profileEmail),
	UNIQUE(profileAtHandle),
	PRIMARY KEY(profileId)
);

 -- Create the dog entity
CREATE TABLE dog (
	dogId INT UNSIGNED AUTO_INCREMENT,
	-- ^Primary Key^
	dogProfileId INT UNSIGNED NOT NULL,
	dogAge CHAR(2) NOT NULL,
	dogBio VARCHAR(300),
	dogBreed VARCHAR(50),
	dogAtHandle VARCHAR(32),
	INDEX(dogProfileId),
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
	-- this creates an index before creating a foreign key
	FOREIGN KEY(friendFirstProfileId) REFERENCES profile(profileId),
	 -- this creates the foreign key
	INDEX(friendSecondProfileId),
	FOREIGN KEY(friendSecondProfileId) REFERENCES profile(profileId)
);

 -- Create the park entity
CREATE TABLE park (
	parkId INT UNSIGNED AUTO_INCREMENT,
	parkLocationX DECIMAL(3,9) NOT NULL,
	parkLocationY DECIMAL(3,9) NOT NULL,
	parkName VARCHAR(32),
	PRIMARY KEY(parkId)

)