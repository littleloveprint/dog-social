<?php
namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Park;

//Grab the class under scrutiny
require_once (dirname(__DIR__) . "/autoload.php");


/**
 * Full PHPUnit testx for the Park class
 *
 *This is a complete unit testx for the Park class. It is complete because all mySQL and PDO methods are tested for both invalid and valid inputs.
 *
 * @see Park
 * @author Emily Rose Halleran
 **/
class ParkTest extends BarkParkzTest {
/**
 * Valid Park Id to use
 * @var string $VALID_PARKID
 **/
protected $VALID_PARKID;

/**
 * Valid Park Name to use
 * @var string $VALID_PARKNAME
 **/
protected $VALID_PARKNAME;

/**
 * Valid cloudinary id to use
 * @var string $VALID_CLOUDINARYID
 **/

protected $VALID_CLOUDINARYID;

/**
 * Valid location x to use
 * @var string $VALID_LOCATIONX
 **/
protected $VALID_LOCATIONX;

/**
 * Valid location y to use
 * @var string $VALID_LOCATIONY;
 **/
protected $VALID_LOCATIONY;

/**
 *
 */
