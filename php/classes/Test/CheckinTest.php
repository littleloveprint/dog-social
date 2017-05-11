<?php
namespace Edu\Cnm\BarkParkz\Test;
// grab the classes under scrutiny
use Edu\Cnm\BarkParkz\CheckIn;
use Edu\Cnm\BarkParkz\Dog;
use Edu\Cnm\BarkParkz\Park;

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
		// create and insert a dog to own the test checkin
		$this->dog = new Dog()
	}
}