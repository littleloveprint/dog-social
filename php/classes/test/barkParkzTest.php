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
 * @author Gerrit Van Dyke <gerritv8484@gmail.com>
 *
 */

abstract class barkParkzTest extends TestCase {
	use TestCaseTrait;

	/**
	 * invalid id to use for an INT UNSIGNED field (maximum allowed INT UNSIGNED in mySQL) + 1
	 * @var int INVALID_KEY
	 */

	const INVALID_KEY = 2468642468;

	/**
	 * PHPUnit database connection interface
	 * @var Connection $connection
	 */

	protected $connection = null;

	/**
	 * assembles the table from the schema for PHPUnit
	 * @return QueryDataSet assembled schema for PHPUnit
	 */

	public final function getDataSet() {
		$dataset = new QueryDataSet($this->getConnection());

		//add all the tables for BarkParkz list in same order they were created

		$dataset->addTable("profile");
		$dataset->addTable("dog");
		$dataset->addTable("friend");
		$dataset->addTable("park");
		$dataset->addTable("checkIn");
		$dataset->addTable("favortie");
		return ($dataset);

	}
}

/**
 * templates the setup method that runs before each test; this method expunges the database before each run
 * @return composite array containing delete and insert commands
 */

public final function getSetUpOperation() {
	return new Composite([
				Factory::DELETE_ALL(),
				Factory::INSERT()
		]);

}



