<?php
namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\{Friend, Profile};

// Grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Friend class.
 *
 * This is a complete PHPUnit test of the Friend class. It is complete because all mySQL and PDO enabled methods are tested for both invalid and valid inputs.
 *
 * @see Friend
 * @author Lea McDuffie <lea@littleloveprint.io>
 **/
class FriendTest extends BarkParkzTest {

	/**
	 * Profile to be the "friender"
	 * @var Profile $profileOne
	 **/
	protected $profileOne;

	/**
	 * Profile to become "friended"
	 * @var Profile $profileTwo
	 **/
	protected $profileTwo;

	/**
	 * Placeholder until account activation is created.
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATIONONE;

	/**
	 * Placeholder until account activation is created.
	 * @var string $VALID_ACTIVATION
	 **/
	protected $VALID_ACTIVATIONTWO;

	/**
	 * Valid at handle to use
	 * @var string $VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLEONE = "@barkparkz";

	/**
	 * Valid at handle to use
	 * @var string $VALID_ATHANDLE
	 **/
	protected $VALID_ATHANDLETWO = "@dogbonez";

	/**
	 * Valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAILONE = "lea@barkparkz.com";

	/**
	 * Valid email to use
	 * @var string $VALID_EMAIL
	 **/
	protected $VALID_EMAILTWO = "emily@barkparkz.com";

	/**
	 * Valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH_ONE;

	/**
	 * Valid salt to use to create the profile object to own the test.
	 * @var string $VALID_SALT
	 **/
	protected $VALID_SALT_ONE;

	/**
	 * Valid hash to use
	 * @var $VALID_HASH
	 */
	protected $VALID_HASH_TWO;

	/**
	 * Valid salt to use to create the profile object to own the test.
	 * @var string $VALID_SALT
	 **/
	protected $VALID_SALT_TWO;

	/**
	 * Valid location x to use.
	 * @var float $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX_ONE = 43.5945;

	/**
	 * Valid location y to use.
	 * @var float $VALID_LOCATIONY
	 **/
	protected $VALID_LOCATIONY_ONE = 83.8889;

	/**
	 * Valid location x to use.
	 * @var float $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX_TWO = 34.9876;

	/**
	 * Valid location y to use.
	 * @var float $VALID_LOCATIONY
	 **/
	protected $VALID_LOCATIONY_TWO = 43.8765;

	/**
	 * Create dependent objects before running each test.
	 **/
	public final function setUp(): void {

		// Run the default setUp() method first.
		parent::setUp();

		// Create a salt and hash for the first mocked profile.
		$password = "abc123";
		$this->VALID_SALT_ONE = bin2hex(random_bytes(32));
		$this->VALID_HASH_ONE = hash_pbkdf2("sha512", $password, $this->VALID_SALT_ONE, 722988);
		$this->VALID_ACTIVATION_ONE = bin2hex(random_bytes(16));

		// Create a salt and hash for the second mocked profile.
		$password = "abc123";
		$this->VALID_SALT_TWO = bin2hex(random_bytes(32));
		$this->VALID_HASH_TWO = hash_pbkdf2("sha512", $password, $this->VALID_SALT_TWO, 722988);
		$this->VALID_ACTIVATION_TWO = bin2hex(random_bytes(16));

		// Create and insert a mocked Profile.
		$this->profileOne = new Profile(
			null,
			null,
			"@barkparkz",
			1234567898765430,
			"lea@barkparkz.com",
			$this->VALID_HASH_ONE,
			$this->VALID_SALT_ONE,
			$this->VALID_LOCATIONX_ONE,
			$this->VALID_LOCATIONY_ONE);
		$this->profileOne->insert($this->getPDO());

		// Create and insert a second mocked Profile.
		$this->profileTwo = new Profile(
			null,
			null,
			"@dogbonez",
			1345678987654321,
			"emily@barkparkz.com",
			$this->VALID_HASH_TWO,
			$this->VALID_SALT_TWO,
			$this->VALID_LOCATIONX_TWO,
			$this->VALID_LOCATIONY_TWO);
		$this->profileTwo->insert($this->getPDO());
	}

	/**
	 * Test inserting a valid Friend and verify that the actual mySQL data matches.
	 **/
	public function testInsertValidFriend(): void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create new Friend, and insert it into mySQL.
		$friend = new Friend($this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $friend->getFriendFirstProfileId(), $friend->getFriendSecondProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $friend->getFriendFirstProfileId());
		$this->assertEquals($pdoFriend->getFriendSecondProfileId(), $friend->getFriendSecondProfileId());
	}

	/**
	 * Test creating Friend that makes no sense.
	 *
	 * @expectedException \TypeError
	 **/
	public function testInsertInvalidFriend(): void {

		// Create a friend without foreign keys, and watch it fail hard.
		$friend = new friend(null, null);
		$friend->insert($this->getPDO());
	}

	/**
	 * Test creating a Friend and deleting it.
	 **/
	public function testDeleteValidFriend(): void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$friend->insert($this->getPDO());

		// Delete the Friend from mySQL.
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$friend->delete($this->getPDO());

		// Grab the data from mySQL, and be sure it does not exist.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$this->assertNull($pdoFriend);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("friend"));
	}

	/**
	 * Test deleting an invalid Profile.
	 *
	 * @expectedException \PDOException
	 **/
	public function testDeleteInvalidProfile() : void {

		// Create a Profile and try to delete it without actually inserting it.
		$profile = new Profile(
			null,
				$this->VALID_ACTIVATIONONE,
				$this->VALID_ATHANDLEONE,
				3456765497869,
				$this->VALID_EMAILONE,
				$this->VALID_HASH_ONE,
				$this->VALID_SALT_ONE,
				$this->VALID_LOCATIONX_ONE,
				$this->VALID_LOCATIONY_ONE);
		$profile->delete($this->getPDO());
	}

	/**
	 * Test inserting a Friend and regrabbing it from mySQL.
	 **/
	public function testGetValidFriendByFriendFirstProfileIdAndFriendSecondProfileId(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL, and be sure the fields match our expectations.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->profileOne->getProfileId());
		$this->assertEquals($pdoFriend->getFriendSecondProfileId(), $this->profileTwo->getProfileId());
	}

	/**
	 * Test grabbing a Friend that does not exist.
	 **/
	public function testGetInvalidFriendByFriendFirstProfileIdAndFriendSecondProfileId() {

		// Grab a friend first profile id and friend second profile id that exceed the maximum allowable.
		$friend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY, BarkParkzTest::INVALID_KEY);
		$this->assertNull($friend);
	}

	/**
	 * Test grabbing a Friend by a profile that does not exist.
	 **/
	public function testGetInvalidFriendByFriendFirstProfileId(): void {

		// Grab a profile id that exceeds the maximum allowable.
		$friend = Friend::getFriendByFriendFirstProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $friend);
	}

	/**
	 * Test grabbing a Friend by profile id
	 **/
	public function testGetValidFriendByProfileId(): void {
		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profileOne->getProfileId(), $this->profileTwo->getProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL, and be sure the fields match our expectations.
		$results = Friend::getFriendByFriendFirstProfileId($this->getPDO(), $this->profileOne->getProfileId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz", $results);

		$pdoFriend =$results[0];
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->profileOne->getProfileId());
		$this->assertEquals($pdoFriend->getFriendSecondProfileId(), $this->profileTwo->getProfileId());
	}
}