<?php
namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Profile;
use Edu\Cnm\BarkParkz\Dog;



//Grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

/**
 * Full PHPUnit test for the Dog class
 *
 * All mySQL and PDO enabled methods are tested for both invalid and valid inputs
 * @see Dog, Profile
 * @author Gerrit Van Dyke <gerritv8484@gmail.com>
 **/

class DogTest extends BarkParkzTest {

	/**
	 * profile that created the dog
	 * @ var Profile $profile
	 */
	protected $profile;

	/**
	 * Placeholder until account activation is created
	 */
	protected $VALID_ACTIVATION;

	/**valid hash to use
	 * @var $VALID_HASH ;
	 **/
	protected $VALID_HASH;

	/**
	 * valid salt to use to create the profile for this test
	 * @var string $VALID_SALT
	 */
	protected $VALID_SALT;


	/**
	 * valid dogAge to use to create the dog class
	 */

	protected $VALID_DOG_AGE = 1;
	/**
	 * valid dogCloudinaryId in the dog class
	 */
	protected $VALID_DOG_CLOUDINARY_ID;
	/**
	 * valid dogBio used in the dog class
	 */
	protected $VALID_DOG_BIO = "Scruffy is such a cool little rascal.";

	/**
	 * valid dogBreed used in the dog class
	 */
	protected $VALID_DOG_BREED = "Bulldog Shitzu mix";
	/**
	 * valid dogAtHanadle used in the dog class
	 */
	protected $VALID_DOG_AT_HANDLE = "@ScruffyLovesHimSomeTail";

	/**
	 * create dependent objects before running each test
	 */

	public final function setUp(): void {
		//run the default setup
		parent::setUp();
		//create a salt and hash for the mock profile
		$password = "mjIsWeird23";
		$this->VALID_SALT = bin2hex(random_bytes(32));
		$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT, 262144);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		$profile = new Profile(null, null, "@barkparkz", null, "lea@barkparkz.com", null, 123456789123.123456789, 321987654321.987654321, null);
	}


	/**
	 * Test inserting a valid Dog and verfiy that the mySQL data matches
	 **/
	public function testInsertValidDog() : void {

		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("dog");

		//create a new Dog and insert into mySQL
		$dog = new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);

		//var_dump($dog);

		$dog->insert($this->getPDO());

		//grab the data from mySQL and ensure the fields match expectations
		$pdoDog = Dog::getDogByDogId($this->getPDO(), $dog->getDogId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
		$this->assertEquals($pdoDog->getDogProfileId(), $this->profile->getProfileId);
		$this->assertEquals($pdoDog->getDogAge(), $this->VALID_DOG_AGE);
		$this->assertEquals($pdoDog->getDogCloudinaryId(), $this->VALID_DOG_CLOUDINARY_ID);
		$this->assertEquals($pdoDog->getDogBio(), $this->VALID_DOG_BIO);
		$this->assertEquals($pdoDog->getDogBreed(), $this->VALID_DOG_BREED);
		$this->assertEquals($pdoDog->getDogAtHandle(), $this->VALID_DOG_AT_HANDLE);

	}
	/**
	 * Test Inserting a Dog that already exists
	 * @expectedException \PDOException
	 */
	public function testInsertInvalidDog() : void {
		//create dog with a non null dogId and watch it fail
		$dog = new Dog(BarkparkzTest::INVALID_KEY, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
		$dog->insert($this->getPDO());

	}
	/**
	 * Test inserting a Dog, editing it, and updating it
	 */

	public function testUpdateValidDog() {
		//count # of rows and save for later
		$numRows = $this->getConnection()->getRowCount("dog");

		// Create a new Dog and insert into mySQL
		$dog = new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
		$dog->insert($this->getPDO());

		//Edit the Dog and update in mySQL
		$dog->setDogAtHandle($this->VALID_DOG_AT_HANDLE);
		$dog->update($this->getPDO());

		// Grab data from mySQL and ensure the fields match expectations

		$pdoDog = Dog::getDogByDogId($this->getPDO(), $dog->getDogId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
		$this->assertEquals($pdoDog->getDogProfileId(), $this->profile->getProfileId);
		$this->assertEquals($pdoDog->getDogAge(), $this->VALID_DOG_AGE);
		$this->assertEquals($pdoDog->getDogCloudinaryId(), $this->VALID_DOG_CLOUDINARY_ID);
		$this->assertEquals($pdoDog->getDogBio(), $this->VALID_DOG_BIO);
		$this->assertEquals($pdoDog->getDogBreed(), $this->VALID_DOG_BREED);
		$this->assertEquals($pdoDog->getDogAtHandle(), $this->VALID_DOG_AT_HANDLE);

	}

	/**Test updating a Dog that does not exist
	 *
	 * @expectedException \PDOException
	 */

	public function testUpdateInvalidDog() {

		//Create a Dog and try updating it without inserting it first
		$dog = new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
		$dog->update($this->getPDO());
	}
		/**
		 * Test creating a Dog and then deleting it.
		 */
		public function testDeleteValidDog() : void {
//count # of rows and save for later
		$numRows = $this->getConnection()->getRowCount("dog");

		//create a new Dog and insert into mySQL
			$dog = new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
			$dog->insert($this->getPDO());

			//Delete the Dog from mySQL
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
			$dog->delete($this->getPDO());

			//grab data from mySQL and ensure the Dog doesn't exist
			$pdoDog = Dog::getDogByDogId($this->getPDO(), $dog->getDogId());
			$this->assertEquals($numRows, $this->getConnection()->getRowCount("dog"));
		}

		/**
		 * Try deleting a Dog that doesn't exist
		 * @expectedException \PDOException
		 */

		public function testDeleteInvalidDog() : void {

			//create a Dog and try deleting it without inserting it
			$dog = new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
			$dog->insert($this->getPDO());
		}

		/**
		 * Test inserting a Dog and regrabbing it from mySQL
		 */

		public function testGetValidDogByDogId() : void {

			// count # of rows and save for later
			$numRows = $this->getConnection()->getRowCount("dog");

			//create a new Dog and insert into mySQL
			$dog= new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
			$dog->insert($this->getPDO());

			// Grab data from mySQL and ensure the fields match expectations

			$pdoDog = Dog::getDogByDogId($this->getPDO(), $dog->getDogId());
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
			$this->assertEquals($pdoDog->getDogProfileId(), $this->profile->getProfileId);
			$this->assertEquals($pdoDog->getDogAge(), $this->VALID_DOG_AGE);
			$this->assertEquals($pdoDog->getDogCloudinaryId(), $this->VALID_DOG_CLOUDINARY_ID);
			$this->assertEquals($pdoDog->getDogBio(), $this->VALID_DOG_BIO);
			$this->assertEquals($pdoDog->getDogBreed(), $this->VALID_DOG_BREED);
			$this->assertEquals($pdoDog->getDogAtHandle(), $this->VALID_DOG_AT_HANDLE);
		}

		/**
		 * Test grabbing a Dog that doesn't exist
		 */

		public function testGetInvalidDogbyDogId() : void {

			//Grab a dog Id that exceeds the max allowable characters
			$dog = Dog::getDogByDogId($this->getPDO(), BarkParkzTest::INVALID_KEY);
			$this->assertNull($dog);
		}

		/**
		 * test grabbing a dog by breed
		 */

		public function testGetValidDogByBreed() {

			// count # of rows and save for later
			$numRows = $this->getConnection()->getRowCount("dog");

			//create a new Dog and insert into mySQL
			$dog= new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
			$dog->insert($this->getPDO());

			// Grab data from mySQL and ensure the fields match expectations

			$results = Dog::getDogByDogBreed($this->getPDO(), $this->VALID_DOG_BREED);
			$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("dog"));

			//Enforce that no other objects are bleeding into Dog
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Dog", $results);

			//Ensure the results meet expectations
			$pdoDog = $results[0];
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
			$this->assertEquals($pdoDog->getDogProfileId(), $this->profile->getProfileId);
			$this->assertEquals($pdoDog->getDogAge(), $this->VALID_DOG_AGE);
			$this->assertEquals($pdoDog->getDogCloudinaryId(), $this->VALID_DOG_CLOUDINARY_ID);
			$this->assertEquals($pdoDog->getDogBio(), $this->VALID_DOG_BIO);
			$this->assertEquals($pdoDog->getDogBreed(), $this->VALID_DOG_BREED);
			$this->assertEquals($pdoDog->getDogAtHandle(), $this->VALID_DOG_AT_HANDLE);
		}

		/**
		 * Test grabbing a Dog by breed that does not exist
		 */
		public function testGetInvalidDogByBreed() : void {

			//grab a breed that does not exist
			$dog = Dog::getDogByDogBreed($this->getPDO(), "ugly rat dog");
			$this->assertCount(0, $dog);
		}

		public function testGetValidDogByProfileId() : void {
			// count # of rows and save for later
			$numRows = $this->getConnection()->getRowCount("dog");

			//create a new Dog and insert into mySQL
			$dog= new Dog(null, $this->profile->getProfileId(), $this->VALID_DOG_AGE, $this->VALID_DOG_CLOUDINARY_ID, $this->VALID_DOG_BIO, $this->VALID_DOG_BREED, $this->VALID_DOG_AT_HANDLE);
			$dog->insert($this->getPDO());

			// Grab data from mySQL and ensure the fields match expectations

			$results = Dog::getDogByProfileId($this->getPDO(), $this->profile->getProfileId());
			$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("dog"));

			//Enforce that no other objects are bleeding into Dog
			$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Dog", $results);

			//Ensure the results meet expectations
			$pdoDog = $results[0];
			$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("dog"));
			$this->assertEquals($pdoDog->getDogProfileId(), $this->profile->getProfileId);
			$this->assertEquals($pdoDog->getDogAge(), $this->VALID_DOG_AGE);
			$this->assertEquals($pdoDog->getDogCloudinaryId(), $this->VALID_DOG_CLOUDINARY_ID);
			$this->assertEquals($pdoDog->getDogBio(), $this->VALID_DOG_BIO);
			$this->assertEquals($pdoDog->getDogBreed(), $this->VALID_DOG_BREED);
			$this->assertEquals($pdoDog->getDogAtHandle(), $this->VALID_DOG_AT_HANDLE);
		}
		/**
		 * test grabbing a Dog by a profile Id that doesn't exist
		 *
		 */

		public function testGetInvalidDogByProfileId() : void {
			// grab a park id that exceeds the max # of characters
			$dog = Dog::getDogByProfileId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		}
}





