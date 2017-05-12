<?php
namespace Edu\Cnm\BarkParkz\Test;
// grab the classes under scrutiny
use Edu\Cnm\BarkParkz\CheckIn;
use Edu\Cnm\BarkParkz\Dog;
use Edu\Cnm\BarkParkz\Park;
use Edu\Cnm\BarkParkz\Profile;

require_once(dirname (__DIR__) . "autoload.php");
/**
 * full unit test for the check in class
 **/
class CheckinTest extends BarkParkzTest {
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
	 * create dependents objects before running each test
	 **/
	public final function setUp() : void {
		// run the default setUp() method first
		parent::setUp();
		// create a salt and hash for the mocked profile
		$password = "abc123";
		$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
		$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
		// create and insert a profile/dog to own the test checkin not sure wth
		$this->dog = new Dog(null, null,"scruffy", "scruffy@gmail.com", $this->VALID_PROFILE_HASH, "+12125551212", $this->VALID_PROFILE_SALT);
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
	public function testInsertValidCheckin() : void {
		// count the rows and save
		$numRows = $this->getConnection()->getRowCount("checkin");
		// create a new checkin and insert into mySQL
		$checkin = new Checkin(null, $this->dog->getDogId(), $this->park->getParkId(), $thi)
	}
}