DROP TABLE IF EXISTS 'profile';
DROP TABLE IF EXISTS 'dog';
DROP TABLE IF EXISTS 'friend';
DROP TABLE IF EXISTS 'park';
DROP TABLE IF EXISTS 'checkIn';
DROP TABLE IF EXISTS 'favorite';

-- The profile entity
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

 -- The dog entity