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
	 * @var $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * Valid salt to use to create the profile object to own the test.
	 * @var string $VALID_SALT;
	 **/
	protected $VALID_SALT;

	/**
	 * Valid location x to use.
	 * @var string $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX;

	/**
	 * Valid location y to use.
	 * @var string $VALID_LOCATIONY
	 **/
	protected $VALID_LOCATIONY;

	/**
	 * Run the default setup operation to create salt and hash.
	 **/
	public final function setUp() : void {
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_LOCATIONY = bin2hex(random_bytes(32));
		$this->VALID_LOCATIONY = bin2hex(random_bytes(32));
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 722988);
		$this->VALID_CLOUDINARYID = bin2hex(random_bytes(32));
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * Test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() : void {

		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert into mySQL.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);

		// var_dump($profile);

		$profile->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()-getRowCount("profile"));
		$this->assertSame($pdoProfile-getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertSame($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertSame($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test inserting a Profile that already exists.
	 *
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidProfile() : void {

		// Create a profile with a non null profileId and watch it fail hahaha
		$profile = new Profile(BarkParkzTest::INVALID_KEY, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());
	}

	/**
	 * Test inserting a Profile, editing it, and then updating it.
	 **/
	public function testUpdateValidProfile() {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert into mySQL.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Edit the Profile and update it in mySQL.
		$profile->setProfileAtHandle($this->VALID_ATHANDLE);
		$profile->update($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()-getRowCount("profile"));
		$this->assertSame($pdoProfile-getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertSame($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertSame($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test updating a Profile that does not exist.
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidProfile() {

		// Create a Profile and try to update it without actually inserting it.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->update($this->getPDO());
	}

	/**
	 * Test creating a Profile and then deleting it.
	 **/
	public function testDeleteValidProfile() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->update($this->getPDO());

		// Delete the Profile from mySQL.
		$this->assertSame($numRows + 1, $this->getConnection()->getRowCount("profile"));
		$profile->delete($this->getPDO());

		// Grab the data from mySQL and be sure the Profile does not exist.
		$pdoProfile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows, $this->getConnection()->getRowCount("profile"));
	}

	/**
	 * Test deleting a Profile that does not exist

	 @expectedException \PDOException
	 **/
	public function testDeleteInvalidProfile() : void {

		// Create a Profile and try to delete it without actually inserting it.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->delete($this->getPDO());
	}

	/**
	 * Test inserting a Profile and regrabbing it from mySQL.
	 **/
	public function testGetValidProfileByProfileId() : void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert it into mySQL.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoProfile = Profile = Profile::getProfileByProfileId($this->getPDO(), $profile->getProfileId());
		$this->assertSame($numRows + 1, $this->getConnection()-getRowCount("profile"));
		$this->assertSame($pdoProfile-getProfileActivationToken(), $this->VALID_ACTIVATION);
		$this->assertSame($pdoProfile->getProfileAtHandle(), $this->VALID_ATHANDLE);
		$this->assertSame($pdoProfile->getProfileCloudinaryId(), $this->VALID_CLOUDINARYID);
		$this->assertSame($pdoProfile->getProfileEmail(), $this->VALID_EMAIL);
		$this->assertSame($pdoProfile->getProfileHash(), $this->VALID_HASH);
		$this->assertSame($pdoProfile->getProfileSalt(), $this->VALID_SALT);
		$this->assertSame($pdoProfile->getProfileLocationX(), $this->VALID_LOCATIONX);
		$this->assertSame($pdoProfile->getProfileLocationY(), $this->VALID_LOCATIONY);
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
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$profile->insert($this->getPDO());

		// Grab the data from mySQL.
		$results = Profile::getProfileByProfileAtHandle()
	}
}