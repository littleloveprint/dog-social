<?php
namespace Edu\Cnm\BarkParkz\Test;
// this throws error ask for feedback
// use Edu\Cnm\BarkParkz\classes{Favorite,Profile,Park};

// grab the class under scrutiny
use Edu\Cnm\BarkParkz\Favorite;
use Edu\Cnm\BarkParkz\Park;
use Edu\Cnm\BarkParkz\Profile;

require_once(dirname (__DIR__) . "/autoload.php");
/**
 * full unit test for the favorite class
 **/
class FavoriteTest extends BarkParkzTest {
/**
 * profile that created a favorite for a park.
 * @var Profile $profile
 **/
protected $profile;
/**
 * park that was favored
 * @var Park $park
 **/
protected $park;
	/**
	 * valid hash to use
	 * @var $VALID_PROFILE_HASH;
	 **/
	protected $VALID_PROFILE_HASH;
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
 * create dependent objects before running each test
 **/
public final function setUp() : void {
	// run the default setup
	parent::setUp();
	// create a salt and has for the mocked profile
	$password = "higeorge123";
	$this->VALID_PROFILE_SALT = bin2hex(random_bytes(32));
	$this->VALID_PROFILE_HASH = hash_pbkdf2("sha512", $password, $this->VALID_PROFILE_SALT, 262144);
	$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	//create and insert the mocked profile
	$this->profile = new Profile(null, $this->VALID_ACTIVATION,"@BobDobalina","324324288888899432","test@test.com",$this->VALID_PROFILE_HASH,"23.4324324","32.43243242",$this->VALID_PROFILE_SALT);
	$this->profile->insert($this->getPDO());
	//create the park and insert it
	$this->park = new Park(null, 106.33333, 40.66666, "Tramway Park");
}
/**
 * test inserting a valid favorite and verify that the actual mySQL data matches
 **/
public function testInsertValidFavorite() : void {
	// count the number of rows and save it for later
	$numRows = $this->getConnection()->getRowCount("favorite");

	// create a new favorite and insert into mySQL
	$favorite = new Favorite($this->profile->getProfileId(), $this->park->getParkId());
	$favorite->insert($this->getPDO());

	// grab the data from mySQL and enforce the fields to match our expectations
	$pdoFavorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteParkId($this->getPDO(), $this->profile->getProfileId(), $this->park->getParkId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
	$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
}
/**
 * test creating a favorite that makes no sense
 * @expectedException \TypeError
 **/
public function testInsertInvalidFavorite() : void {
	// create favorite and watch it fail why? why the f*** not
	$favorite = new favorite(null,null,null);
	$favorite->insert($this->getPDO());
}
/**
 * test creating a favorite and then deleting it
 **/
public function testDeleteValidFavorite() : void {
	// count the number row and save it for later
	$numRows = $this->getConnection()->getRowCount("favorite");
	// create a new favorite and insert into the mySQL
	$favorite = new Favorite($this->profile->getProfileId(), $this->park->getParkId());
	$favorite->insert($this->getPDO());
	// deletes the favorite from mySQL
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
	$favorite->delete($this->getPDO());
	// grab the data from mySQl and the favorite does not exist
	$pdoFavorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteParkId($this->getPDO(), $this->profile->getProfileId(), $this->park->getParkId());
	$this->assertNull($pdoFavorite);
	$this->assertNull($numRows, $this->getConnection()->getRowCount("favorite"));
	}

	/**
	 * test inserting a favorite and regrabbing it from mySQL
	 **/
	public function testGetInvalidFavoriteByParkIdAndProfileId() {
		// grab a park and profile id that exceeds the maximum allowable park id and profile id
		$favorite = Favorite::getFavoriteByFavoriteProfileIdAndFavoriteParkId($this->getPDO(), BarkParkzTest::INVALID_KEY, BarkParkZTest::INVALID_KEY);
		$this->assertNull($favorite);
	}
	public function testGetValidFavoriteByParkId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");
		// create a new favorite and insert to into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->park->getParkId());
		$favorite->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields to match our expectations
		$results = Favorite::getFavoriteByFavoriteParkId($this->getPDO(), $this->park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);
		// not sure if this is accurate namespace?
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Favorite", $results);
		// grab the result from the array and validate
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteParkId(), $this->park->getParkId());
	}
	/**
	 * test grabbing a Favorite by a park id that does not exist
	 **/
	public function testGetInvalidFavoriteByParkId() : void {
		// grab a park id that exceeds the maximum allowable park id
		$favorite = Favorite::getFavoriteByFavoriteParkId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $favorite);
	}
	/**
	 * test grabbing a favorite by profile id
	 **/
	public function testGetValidFavoriteByProfileId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("favorite");

		// create a new favorite and insert it into mySQL
		$favorite = new Favorite($this->profile->getProfileId(), $this->park->getParkId());
		$favorite->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields to match our expectations
		$results = Favorite::getFavoritesByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Favorite", $results);

		// grab the result from the array and validate it
		$pdoFavorite = $results[0];
		$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoFavorite->getFavoriteParkId(), $this->park->getParkId());
	}
	/**
	 * test grabbing a favorite by a profile id that does not exist
	 **/
	public function testGetInvalidFavoriteByProfileId() : void {
		// grab a park id that exceeds the max allowed profile id
		$favorite = Favorite::getFavoritesByFavoriteProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertCount(0, $favorite);
	}
}
