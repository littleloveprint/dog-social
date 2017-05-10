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
	protected $VALID_ATHANDLE = "@phpunit";

	/**
	 * Second valid at handle to use.
	 * @var string $VALID_ATHANDLE2
	 **/
	protected $VALID_ATHANDLE2 = "passingtests";

	/**
	 * Valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAIL = "test@phpunit.de";

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
	 * Run the default setup operation to create salt and hash.
	 **/
	public final function setUp() : void {
		parent::setUp();

		//
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 722988);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}

	/**
	 * Test inserting a valid Profile and verify that the actual mySQL data matches
	 **/
	public function testInsertValidProfile() : void {

		// Count the number of rows and save it for later.
		$numRows = $this->getConnection()->getRowCount("profile");

		// Create a new Profile and insert into mySQL.
		$profile = new Profile(null, $this->VALID_ACTIVATION, $this->VALID_ATHANDLE, $this->VALID_ATHANDLE2, $this->VALID_EMAIL, $this->VALID_HASH, $this->VALID_SALT);

		// var_dump($profile);

		$profile->insert($this->getPDO());
	}
}