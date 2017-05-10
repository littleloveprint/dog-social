<?php
namespace Edu\Cnm\BarkParkz\test;
// this throws error ask for feedback
// use Edu\Cnm\BarkParkz\classes{Favorite,Profile,Park};

//grab the class under scrutiny
use Edu\Cnm\BarkParkz\Favorite;
use Edu\CNM\BarkParkz\Park;
use Edu\Cnm\BarkParkz\Profile;

require_once(dirname (__DIR__) . "autoload.php");
/**
 * full unit test for the favorite class
 **/
class FavoriteTest extends TestCase {
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
 * @var $VALID_HASH;
 **/
protected $VALID_HASH;
/**
 * valid salt to use to create the profile object to own the test
 * @var string $VALID_SALT
 **/
protected $VALID_SALT;
/**
 * create dependent objects before running each test
 **/
public final function setUp() : void {
	// run the default setup
	parent::setUp();
	// create a salt and has for the mocked profile
	$password = "higeorge123";
	$this->VALID_SALT = bin2hex(random_bytes(32));
	$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
	$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	//create and insert the mocked profile
	$this->profile = new Park(null, null,"@php_unit", "test@phpunit.de",$this->VALID_HASH, "+12125551212", $this->VALID_SALT);
	$this->profile->insert($this->getPDO());
	//create the park and insert it
	$this->park = new Park(null, $this->park->getParkId(), "PHP unit favroite test passing");
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
	$pdoFavorite = Favorite::getFavoriteByFavoriteProfileId($this->getPDO(), $this->profile->getProfileId(), $this->park->getParkId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("favorite"));
	$this->assertEquals($pdoFavorite->getFavoriteProfileId(), $this->profile->getProfileId());
	$this->assertEquals($pdoFavorite->getFavoriteParkId(), $this->park->getParkId());
}
/**
 * test creating a favorite that makes no sense
 * @expectedException \TypeError
 **/
public function testInsertInvalidFavorite() : void {
	// create favorite and watch it fail why? why the f*** not
	$favorite = new favorite(null,null,null);
	$favorite->insert($favorite->getPDO());
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

	}
}
