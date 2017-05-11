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

/**valid hash to use
 * @var $VALID_HASH;
 **/
protected $VALID_HASH;

/**
 * valid salt to use to create the profile for this test
 * @var string $VALID HASH
 */
protected $VALID_SALT;
}



