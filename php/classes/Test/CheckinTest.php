<?php
namespace Edu\Cnm\BarkParkz\Test;
// grab the classes under scrutiny
use Edu\Cnm\BarkParkz\{CheckIn, Dog, Park, Profile};

require_once(dirname (__DIR__) . "autoload.php");
/**
 * full unit test for the check in class
 **/
class CheckInTest extends BarkParkzTest {
	/**
	 * dog that checks into a park
	 * @var Dog $dog
	 **/
	protected $dog = null;
	/**
	 * park that was checked into
	 * @var Park $park
	 **/
	protected $park = null;
	/**
	 * profile that owns the dog
	 * @var Profile $profile
	 **/
	protected $profile = null;
	/**
	 * valid hash to use
	 * @var $VALID_PROFILE_HASH;
	 **/
	protected $VALID_PROFILE_HASH;
	/**
	 * timestamp of the check in this starts as null and is assigned later
	 * @var \DateTime $VALID_CHECKINDATE
	 **/
	protected $VALID_CHECKINDATETIME;
	/**
	 * valid timestamp to use as sunriseCheckInDateTime
	 **/
	protected $VALID_SUNRISECHECKINDATETIME = null;
	/**
	 * valid timestamp to use as sunsetCheckInDateTime
	 **/
	protected $VALID_SUNSETCHECKINDATETIME = null;
	/**
	 * valid salt to use to create the profile to own the test
	 * @var string $VALID_PROFILE_SALT;
	 **/
	protected $VALID_PROFILE_SALT;
	/**
	 * Placeholder until account activation is created
	 */
	protected $VALID_ACTIVATION;
	/**
	 * create dependents objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();

		// @TODO: Add profile, and park to the setup method, just like you created the dog object

		// create a salt and hash for the mocked profile
		$password = "abc123";

		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a profile/dog to own the test checkin not sure wth
		$this->profile = new Profile(null, null,"@handle","324324288888899432","test@test.com",$this->VALID_PROFILE_HASH,"23.4324324","32.43243242",$this->VALID_PROFILE_SALT);
		$this->profile->insert($this->getPDO());
		$this->dog = new Dog(null, $this->profile->getProfileId(),11,"kjkhgjghjhgkjhg","jlhlhlhl","ljhkjhljhljh","woof" );
		$this->dog->insert($this->getPDO());
		// create park
		$this->park = new Park(null,"23.4324324","32.43243242","NE back park");
		$this->park->insert($this->getPDO());
		// calculate the date
		$this->VALID_CHECKINDATETIME = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_SUNRISECHECKINDATETIME = new \DateTime();
		$this->VALID_SUNRISECHECKINDATETIME->sub(new \DateInterval("P10D"));
		// format the sunset date to use for testing
		$this->VALID_SUNSETCHECKINDATETIME = new \DateTime();
		$this->VALID_SUNSETCHECKINDATETIME->add(new \DateInterval("P10D"));
	}
	// test inserting a valid tweet and verify that the actual mySQL data matches
	public function testInsertValidCheckIn() : void {
		// count the rows and save
		$numRows = $this->getConnection()->getRowCount("checkin");
		// create a new checkin and insert into mySQL
		$checkin = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkin->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match
		$pdoCheckin = CheckIn::getCheckInByCheckInId($this->getPDO(), $checkin->getCheckInId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkin"));
		$this->assertEquals($pdoCheckin->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckin->getCheckInParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckin->getCheckInDateTime()->getTimestamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}

	// TODO: Add Test valid update,
	/**
	 * test creating checkin  that makes no sense
	 * @expectedException \TypeError
	 **/
	public function testInsertInvalidCheckIn() : void {
		// create a checkin with out foreign keys and watch it fail
		$checkin = new CheckIn(null, null, null);
		$checkin->insert($this->getPDO());
	}
	/**
	 * test creating a checkin then deleting it
	 **/
	public function testDeleteValidCheckIn() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkin");
		// create a new checkin and insert to into mySQL
		$checkin = new Checkin($this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkin->insert($this->getPDO());
		// delete the checkin from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkin"));
		$checkin->delete($this->getPDO());
		// grab the data from mySQL and enforce the checkin does not exist
		$pdoCheckin = CheckIn::getCheckInByDogIdAndParkId($this->getPDO(), $this->checkin->getCheckInDogId(), $this->park->getCheckInParkID);
		$this->assertNull($pdoCheckin);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("checkin"));
	}
	/**
	 * test inserting a checkin and regrabbing it from mySQL
	 **/
	public function testGetValidCheckinByDogIdAndParkId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkin");
		// create a new checkin and insert to into mySQL
		$checkin = new CheckIn($this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkin->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoCheckin = CheckIn::getCheckInByCheckinDogidAndCheckinParkID($this->getPDO(), $this->dog->getDogId(), $this->park->getParkId());
		$checkin->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkin"));
		$checkin->assertEquals($pdoCheckin->getCheckinDogId(), $this->dog->getDogId());
		$checkin->assertEquals($pdoCheckin->getCheckinParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckin->getCheckInDateTime()->getTimeStamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test grabbing a checkin that does not exist
	 **/
	public function testGetInvalidCheckinByDogIdAndParkId() {
		// grab a park id and dog id that exceeds the max allowable
		$checkin = CheckIn::getCheckInByDogIdAndParkId($this->getPDO(), BarkParkzTest::INVALID_KEY, BarkParkzTest::INVALID_KEY);
		$this->assertNull($checkin);
	}
	/**
	 * test grabbing a checkin by dog id
	 **/
	public function testGetValidCheckInByDogId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkin");
		// create a new checkin and insert it into mySQL
		$checkin = new CheckIn($this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkin->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = CheckIn::getCheckInByCheckInId($this->getPDO(), $this->dog->getDogId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkin"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\CheckIn", $results);
		// grab the result from the array and validate it
		$pdoCheckin = $results[0];
		$this->assertEquals($pdoCheckin->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckin->getCheckInParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckin->getCheckInDateTime()->getTimeStamp(),$this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test grabbing a checkin by a dog id that does not exist
	 **/
	public function testGetInvalidCheckInByDogId() : void {
		// grab a dog id that exceeds the max allowable
		$checkin = CheckIn::getCheckInByDogId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $checkin);
	}
	/**
	 * test grabbing checkin by park id
	 **/
	public function testGetValidCheckInByParkId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkin");
		//create a new checkin and insert into mySQL
		$checkin = new CheckIn($this->dog->getDogId(), $this->park->getParkId(),$this->VALID_CHECKINDATETIME);
		$checkin->insert($this->getPDO());
		// grab the result from mySQL and enforce the fields match our expectations
		$results = CheckIn::getCheckInByCheckParkId($this->getPDO(), $this->park->getParkId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkin"));
	$this->assertEquals(1, $results);
	// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Checkin", $results);
		// grab the result from the array and validate it
		$pdoCheckIn = $results[0];
		$this->assertEquals($pdoCheckIn->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test grabbing a checkin by a park id that does not exist
	 **/
	public function testGetInvalidCheckInByParkId() : void {
		// grab a check in that exceeds blablabla
		$checkin = CheckIn::getCheckInByCheckParkId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $checkin);
	}
}