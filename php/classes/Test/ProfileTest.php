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
	 * Second valid at handle to use
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_ATHANDLE2 = "@dogsocial";

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
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_ATHANDLE2, $this->VALID_CLOUDINARYID, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);

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
}