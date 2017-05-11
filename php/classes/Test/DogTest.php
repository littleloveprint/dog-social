<?php
/**
 * Created by PhpStorm.
 * User: GV8484
 * Date: 5/11/2017
 * Time: 10:43 AM
 */

namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Dog;
use Edu\Cnm\BarkParkz\Profile;


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
 * @var $VALID_HASH;
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
protected $VALID_DOG_CLOUDINARY_ID = 7788885555554445454545454;
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

public final function setUp() : void {
	//run the default setup
	parent::setUp();
	//create a salt and hash for the mock profile
	$password = "mjIsWeird23";
	$this->VALID_SALT = bin2hex(random_bytes(32));
	$this->VALID_HASH = hash_pbkdf2("sha512", $password, $this->VALID_SALT,262144);
}
}



