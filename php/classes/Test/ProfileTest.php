<?php
namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Profile;

// Grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Profile class.
 *
 * This is a complete PHPUnit test of the Profile class. It is complete because all mySQL and PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Profile
 * @author Lea McDuffie <lea@littleloveprint.io>
 **/
class ProfileTest extends BarkParkzTest {
	/**
	 * Placeholder until account activation is created.
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATION;

	/**
	 * Valid at handle to use
	 * @var string $VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLE = "@barkparkz";

	/**
	 * Valid cloudinary id to use
	 * @var string $VALID_CLOUDINARYID
	 **/

	protected $VALID_CLOUDINARYID;

	/**
	 * Valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "lea@barkparkz.com";

	/**
	 * Valid hash to use.
	 * @var string $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * Valid salt to use to create the profile object to own the test.
	 * @var string $VALID_SALT;
	 **/
	protected $VALID_SALT;

	/**
	 * Valid location x to use.
	 * @var float $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX = 43.5945;

	/**
	 * Valid location y to use.
	 * @var float $VALID_LOCATIONY
	 **/
	protected $VALID_LOCATIONY = 83.8889;

	/**
	 * Run the default setup operation to create salt and hash.
	 **/
	public final function setUp() : void {
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 722988);
		$this->VALID_CLOUDINARYID = bin2hex(random_bytes(16));
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * Test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() : void {

		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert into mySQL.
		echo "valid activation dump";
		var_dump($this->VALID_ACTIVATION);
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);


		$profile->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test inserting a Profile that already exists.
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile() : void {

		//var_dump($this->VALID_LOCATIONY);

		// Create a profile with a non null profileId and watch it fail hahaha
		$profile = new Profile(
			BarkParkzTest::INVALID_KEY,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());
	}

	/**
	 * Test inserting a Profile, editing it, and then updating it.
	 **/
	public function testUpdateValidProfile() {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert into mySQL.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Edit the Profile and update it in mySQL.
		$profile->setProfileAtHandle($this->VALID_ATHANDLE);
		$profile->update($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());

		//var_dump($pdoProfile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test updating a Profile that does not exist.
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidProfile() {

		// Create a Profile and try to update it without actually inserting it.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->update($this->getPDO());
	}

	/**
	 * Test creating a Profile and then deleting it.
	 **/
	public function testDeleteValidProfile() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Delete the Profile from mySQL.
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// Grab the data from mySQL and be sure the Profile does not exist.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * Test deleting a Profile that does not exist

	 @expectedException \PDOException
	 **/

	public function testDeleteInvalidProfile() : void {

		// Create a Profile and try to delete it without actually inserting it.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->delete($this->getPDO());
	}

	/**
	 * Test inserting a Profile and regrabbing it from mySQL.
	 **/
	public function testGetValidProfileByProfileId() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a profile by its activation.
	 **/
	public function testGetValidProfileByActivationToken() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);

		$profile->insert($this->getPDO());


		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileActivationToken($this->getPDO(), $profile->getProfileActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}
	/**
	 * Test grabbing a Profile that does not exist.
	 **/
	public function testGetInvalidProfileByProfileId() : void {

		// Grab a profile id that exceeds the maximum allowable profile id.
		$profile = Profile::getProfileByProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertNull($profile);
	}

	public function testGetValidProfileByAtHandle() {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATION,
				$this->VALID_ATHANDLE,
				$this->VALID_CLOUDINARYID,
				$this->VALID_EMAIL,
				$this->VALID_HASH,
				$this->VALID_SALT,
				$this->VALID_LOCATIONX,
				$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Grab the data from mySQL.
		$results = Profile::getProfileByProfileAtHandle($this->getPDO(), $this->VALID_ATHANDLE);
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("profile"));

		// Enforce no other objects are bleeding into profile.
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Profile", $results);

		// Enforce the results meet expectations.
		$pdoProfile = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a Profile by at handle that does not exist
	 **/
	public function testGetInvalidProfileByAtHandle() : void {

		// Grab an at handle that does not exist.
		$profile = Profile::getProfileByProfileAtHandle($this->getPDO(), "@nonexisting");
		$this->assertCount(0, $profile);
	}

	/**
	 * Test grabbing a profile by email
	 **/
	public function testGetValidProfileByEmail() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new profile, and insert it into mySQL
		$profile = new Profile(
			null,
			$this->VALID_ACTIVATION,
			$this->VALID_ATHANDLE,
			$this->VALID_CLOUDINARYID,
			$this->VALID_EMAIL,
			$this->VALID_HASH,
			$this->VALID_SALT,
			$this->VALID_LOCATIONX,
			$this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileEmail($this->getPDO(), $profile->getProfileEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$this->assertEquals($pdoProfile->getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertEquals($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertEquals($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertEquals($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertEquals($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a profile by an email that does not exist.
	 **/
	public function testGetInvalidProfileActivation() : void {

		// Grab an email that does not exist.
		$profile = Profile::getProfileByProfileEmail($this->getPDO(), "lea@barkparkz.com");
		$this->assertNull($profile);
	}
}