<?php
namespace Edu\Cnm\BarkParkz\Test;
// grab the classes under scrutiny
use Edu\Cnm\BarkParkz\{CheckIn, Dog, Park, Profile};

require_once(dirname(__DIR__) . "/autoload.php");
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
	 * dogCloudinaryId picture of the doggies
	 *
	 **/
	protected $VALID_CLOUDINARYID;
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
	 * @var \DateTime $VALID_CHECKINDATETIME
	 **/
	protected $VALID_CHECKINDATETIME;
	/**
	 * timestamp of the check in this starts as null and is assigned later
	 * @var \DateTime $VALID_CHECKOUTDATETIME
	 **/
	protected $VALID_CHECKOUTDATETIME;
	/**
	 * created an additional timestamp for testing update
	 * @var \DateTime $VALID_CHECKINDATETIME2
	 */
	protected $VALID_CHECKINDATETIME2;
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
	 * Valid location x to use.
	 * @var float $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX = 23.4324324;

	/**
	 * Valid location y to use.
	 * @var float $VALID_LOCATIONY
	 **/
	protected $VALID_LOCATIONY = 30.4324324;
	/**
	 * create dependents objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
		$password = "abc123";
		$this->VALID_CLOUDINARYID = bin2hex(random_bytes(14));
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a profile/dog to own the test checkin not sure wth
		$this->profile = new Profile(null, $this->VALID_ACTIVATION,"@BobDobalina","3243634436242","mj@mjcodes.com",$this->VALID_PROFILE_HASH,$this->VALID_PROFILE_SALT, 23.4324324,30.4324324);
		$this->profile->insert($this->getPDO());
		$this->dog = new Dog(null, $this->profile->getProfileId(),11,"123456789012345678901234","born and raised in the south side of philly","Shitzu mixed with a bull dog","Malachi" );
		$this->dog->insert($this->getPDO());
		// create park
		$this->park = new Park(null, 23.4324324, 40.4324324, "NE bark park");

		$this->park->insert($this->getPDO());



		// calculate the date
		$this->VALID_CHECKINDATETIME = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_SUNRISECHECKINDATETIME = new \DateTime();
		// format the sunset date to use for testing
		$this->VALID_SUNSETCHECKINDATETIME = new \DateTime();
		$this->VALID_SUNSETCHECKINDATETIME->add(new \DateInterval("P10D"));
	}
	// test inserting a valid checkin and verify that the actual mySQL data matches
	public function testInsertValidCheckIn() : void {
		// count the rows and save
		$numRows = $this->getConnection()->getRowCount("checkIn");
		// create a new checkin and insert into mySQL
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match
		$pdoCheckIn = CheckIn::getCheckInByCheckInId($this->getPDO(), $checkIn->getCheckInId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertEquals($pdoCheckIn->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckInParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test creating checkin  that makes no sense
	 * @expectedException \PDOException
	 **/
	public function testInsertInvalidCheckIn() : void {
		// create a checkin with out foreign keys and watch it fail
		$checkIn = new CheckIn(BarkParkzTest::INVALID_KEY, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
	}
	/**
	 * test valid delete checkin
	 **/
	public function testDeleteValidCheckIn() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkIn");
		// create a new checkin and insert to into mySQL
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
		// delete the checkin from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$checkIn->delete($this->getPDO());
		// grab the data from mySQL and enforce the checkin does not exist
		$pdoCheckIn = CheckIn::getCheckInByCheckInId($this->getPDO(), $checkIn->getCheckInId());
		$this->assertNull($pdoCheckIn);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("checkIn"));
	}
	/**
	 * test delete invalid checkin
	 * @expectedException \PDOException
	 **/
	public function testDeleteInValidCheckIn() : void {
		// create a checkin and try to delete it without actually inserting it
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->delete($this->getPDO());
	}
	/**
	 * test valid update checkin
	 **/
	public function testUpdateValidCheckIn() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkIn");
		// create a new checkin and insert it into mysql
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
		// edit the check in and update it into mysql
		$checkIn->setCheckInDateTime($this->VALID_CHECKINDATETIME2);
		$checkIn->update($this->getPDO());
		// grab the date from mysql and enforce the fields match
		$pdoCheckIn = CheckIn::getCheckInByCheckInId($this->getPDO(), $checkIn->getCheckInId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertEquals($pdoCheckIn->getCheckInDogId(),$this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckInParkId(),$this->park->getParkId());
		// format the date
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test invalid update checkin
	 * @expectedException \PDOException
	 **/
	public function testUpdateInValidCheckin() : void {
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->update($this->getPDO());
	}

	/**
	 * test get invalid checkin by checkin id
	 **/
	public function testGetInvalidCheckInByCheckInId() : void {
		$checkIn = CheckIn::getCheckInByCheckInId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertNull($checkIn);
	}
	/**
	 * test grabbing a checkin by dog id
	 **/
	public function testGetValidCheckInByDogId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkIn");
		// create a new checkin and insert it into mySQL
		$checkIn = new CheckIn(null, $this->dog->getDogId(), $this->park->getParkId(), $this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = CheckIn::getCheckInByCheckInDogId($this->getPDO(), $this->dog->getDogId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\CheckIn", $results);
		// grab the result from the array and validate it
		$pdoCheckIn = $results[0];
		$this->assertEquals($pdoCheckIn->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckInParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimeStamp(),$this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test grabbing a checkin by a dog id that does not exist
	 **/
	public function testGetInvalidCheckInByDogId() : void {
		// grab a dog id that exceeds the max allowable
		$checkIn = CheckIn::getCheckInByCheckInDogId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $checkIn);
	}
	/**
	 * test grabbing checkin by park id
	 **/
	public function testGetValidCheckInByParkId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkIn");

		//create a new checkin and insert into mySQL
		$checkIn = new CheckIn(null,$this->dog->getDogId(), $this->park->getParkId(),$this->VALID_CHECKINDATETIME, $this->VALID_CHECKOUTDATETIME);
		$checkIn->insert($this->getPDO());

		// grab the result from mySQL and enforce the fields match our expectations
		$results = CheckIn::getCheckInByCheckInParkId($this->getPDO(), $checkIn->getCheckInParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\CheckIn", $results);

		// grab the result from the array and validate it
		$pdoCheckIn = $results[0];
		$this->assertEquals($pdoCheckIn->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckInParkId(), $this->park->getParkId());

		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(), $this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test grabbing a checkin by a park id that does not exist
	 **/
	public function testGetInvalidCheckInByParkId() : void {
		// grab a check in that exceeds blablabla
		$checkIn = CheckIn::getCheckInByCheckInParkId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $checkIn);
	}
	/**
	 * test get valid checkin by checkindaterange
	 **/
	public function testGetValidCheckInByCheckInDateRange() : void {
		// the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("checkIn");
		//create a new checkin and insert it into mysql
		$checkIn = new CheckIn(null,$this->dog->getDogId(), $this->park->getParkId(),$this->VALID_CHECKINDATETIME);
		$checkIn->insert($this->getPDO());
		// grab the data from mysql and enforce the fields match
		$results = CheckIn::getCheckInByCheckInDateRange($this->getPDO(),$this->VALID_SUNRISECHECKINDATETIME, $this->VALID_SUNSETCHECKINDATETIME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("checkIn"));
		$this->assertCount(1,$results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\CheckIn", $results);
		//grab the result from the array and validate it
		$pdoCheckIn = $results[0];
		$this->assertEquals($pdoCheckIn->getCheckInDogId(), $this->dog->getDogId());
		$this->assertEquals($pdoCheckIn->getCheckInParkId(), $this->park->getParkId());
		// format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoCheckIn->getCheckInDateTime()->getTimestamp(),$this->VALID_CHECKINDATETIME->getTimestamp());
	}
	/**
	 * test get invalid checkin by checkindaterange
	 **/
	public function testGetInvalidCheckInByCheckInDateRange() : void {
		$checkIn = CheckIn::getCheckInByCheckInDateRange($this->getPDO(),$this->VALID_SUNRISECHECKINDATETIME, $this->VALID_SUNSETCHECKINDATETIME);
		$this->assertCount(0,$checkIn);

	}
}