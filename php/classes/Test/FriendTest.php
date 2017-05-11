<?php
namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Friend;

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
	 * Profile that is a Friend of another profile; this is for foreign key relations.
	 * @var int $VALID_FRIENDFIRSTPROFILEID
	 **/
	protected $VALID_FRIENDFIRSTPROFILEID;

	/**
	 * Second Friend; this is for foreign key relations.
	 * @var int $VALID_FRIENDSECONDPROFILEID
	 **/
	protected $VALID_FRIENDSECONDPROFILEID;

	/**
	 * Valid hash to use
	 * @var string $VALID_HASH
	 **/
	protected $VALID_HASH;

	/**
	 * Valid salt to use to create the profile object to own the test
	 * @var string $VALID_SALT
	 **/
	protected $VALID_SALT;

	/**
	 * Create dependent objects before running each test.
	 **/
	public final function setUp(): void {

		// Run the default setUp() method first.
		parent::setUp();

		// Create a salt and hash for the mocked profile.
		$password = "abc123";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 722988);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		// Create and insert the first mocked profile.
		$this->friendFirstProfileId = new Profile(null, null, "@barkparkz", null, "lea@barkparkz.com", $this->VALID_HASH, $this->VALID_SALT, "somewhere", "someplace");
		$this->friendFirstProfileId->insert($this->getPDO());

		// Create and insert the second mocked profile.
		$this->friendSecondProfileId = new Profile(null, null, "@barkparkz", null, "lea@barkparkz.com", $this->VALID_HASH, $this->VALID_SALT, "somewhere", "someplace");
		$this->friendSecondProfileId->insert($this->getPDO());
	}

	/**
	 * Test inserting a valid Friend and verify that the actual mySQL data matches.
	 **/
	public
	function testInsertValidFriend(): void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->friendFirstProfileId->getFriendFirstProfileId(), $this->friendSecondProfileId->getFriendSecondProfileId);
		$friend->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $this->getfriendFirstProfileId(), $this->getfriendSecondProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->friend->getProfileId());
		$this->assertEquals($pdoFriend->getFriendSecondProfileId(), $this->friend->getProfileId());
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
		$friend = new Friend($this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$friend->insert($this->getPDO());

		// Delete the Friend from mySQL.
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$friend->delete($this->getPDO());

		// Grab the data from mySQL, and be sure it does not exist.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$this->assertNull($pdoFriend);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("friend"));
	}

	/**
	 * Test inserting a Friend and regrabbing it from mySQL.
	 **/
	public function testGetValidFriendByFriendFirstProfileIdAndFriendSecondProfileId(): void {

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL, and be sure the fields match our expectations.
		$pdoFriend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), $this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->friend->getProfileId());
		$this->assertEquals($pdoFriend->getFriendSecondProfileId(), $this->friend->getProfileId());
	}

	/**
	 * Test grabbing a Friend that does not exist.
	 **/
	public function testGetInvalidFriendByFriendFirstProfileIdAndFriendSecondProfileId() {

		// Grab a friend first profile id and friend second profile id that exceed the maximum allowable.
		$friend = Friend::getFriendByFriendFirstProfileIdAndFriendSecondProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY, BarkParkTest::INVALID_KEY);
		$this->assertNull($friend);
	}

	/**
	 * Test grabbing a Friend by friend second profile id.
	 **/
	public function testGetValidFriendByFriendSecondProfileId(): void {


		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL, and be sure the fields match our expectations.
		$results = Friend::getFriendByFriendSecondProfileId($this->getPDO(), $this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Friend", $results);

		// Grab the result from the array, and validate it.
		$pdoFriend = $results[0];
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->profile->getFriendSecondProfileId());
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
	 * Test grabbing a Friend by a profile id.
	 **/
	public function testGetValidFriendByProfileId(): void {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("friend");

		// Create a new Friend, and insert it into mySQL.
		$friend = new Friend($this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$friend->insert($this->getPDO());

		// Grab the data from mySQL, and be sure the fields match our expectations.
		$results = Friend::getFriendByFriendProfileId($this->getPDO(), $this->profile->getFriendFirstProfileId(), $this->friend->getFriendSecondProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("friend"));
		$this->assertCount(1, $results);

		// Enforce no other objects are bleeding into the test.
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Friend", $results);

		// Grab the result from the array, and validate it.
		$pdoFriend = $results[0];
		$this->assertEquals($pdoFriend->getFriendFirstProfileId(), $this->profile->getFriendSecondProfileId());
	}

	/**
	 * Test grabbing a Friend by a profile id that does not exist
	 **/
	public function testGetInvalidFriendByProfileId(): void {

		// Grab a profile id that exceeds the maximum allowable.
		$friend = Friend::getFriendByProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $friend);
	}
}