<?php
/**
 * Created by PhpStorm.
 * User: GV8484
 * Date: 5/8/2017
 * Time: 9:05 PM
 */
namespace Edu\Cnm\BarkParkz;

use PHPUnit\Framework\TestCase;
use PHPUnit\DbUnit\TestCaseTrait;
use PHPUnit\DbUnit\DataSet\QueryDataSet;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\Operation\{Composite, Factory, Operation};

//grab the encrypted properties file

require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

require_once(dirname(__DIR__, 3) . "/vendor/autoload.php");

/**
 * Abstract class containing universal and project specific mySQL parameters
 * Loads all the database parameters for the project so that table specific tests can share parameters in one place
 * Have all table specific tests include this class
 * Tables must be added in the order they were created
 */
