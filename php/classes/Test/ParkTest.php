<?php

namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Park;

//Grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");


/**
 * Full PHPUnit test for the Park class
 *
 *This is a complete unit testx for the Park class. It is complete because all mySQL and PDO methods are tested for both invalid and valid inputs.
 *
 * @see Park
 * @author Emily Rose Halleran
 **/
class ParkTest extends BarkParkzTest {

	/**
	 * Valid Park Name to use
	 * @var string $VALID_PARKNAME
	 **/
	protected $VALID_PARKNAME = "string";

	/**
	 * Valid location x to use
	 * @var float $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX = 43.5945;

	/**
	 * Valid location y to use
	 * @var float $VALID_LOCATIONY ;
	 **/
	protected $VALID_LOCATIONY = 83.8889;

	/**
	 * Test inserting a valid Park and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPark(): void {

		// Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert into mySQL
		$park = new Park (null, 43.5945, 83.8889, $this->VALID_PARKNAME);

		// var_dump($park);

		$park->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertEquals($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test creating a Park and then deleting it
	 **/
	public function testDeleteValidPark(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert it into mySQL
		$park = new Park(null, 43.5945, 83.8889, $this->VALID_PARKNAME);
		$park->insert($this->getPDO());

		// Delete this Park from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$park->delete($this->getPDO());

		// Grab the data from mySQL and be sure the Park does not exist
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("park"));
	}

	/**
	 * Test deleting a Park that does not exist
	 * @expectedException \PDOException
	 **/

	public function testDeleteInvalidPark(): void {

		// Create a Park and try to delete it without actually inserting it
		$park = new Park(null, 43.5945, 83.8889, $this->VALID_PARKNAME);
		$park->delete($this->getPDO());
	}

	/**
	 * Test inserting a Park and regrabbing it from mySQL
	 **/
	public function testGetValidParkbyParkId(): void {

		// Count the number of the rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert it into mySQL
		$park = new Park(null, 43.5945, 83.8889, $this->VALID_PARKNAME);
		$park->insert($this->getPDO());


		// Grab the data from mySQL and be sure the fields match our expectations
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertCount($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertCount($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a Park by its Id
	 **/
	public function testGetValidParkById(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert it into mySQL
		$park = new Park(null, 43.5945, 83.8889, $this->VALID_PARKNAME);
		$park->insert($this->getPDO());

// Grab the data from mySQL and be sure the fields match our expectations
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertCount($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertCount($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a Park that does not exist
	 **/
	public function testGetInvalidParkByParkId(): void {

		// Grab a park id that exceeds the maximum allowable park id
		$park = Park::getParkByParkId($this->getPDO(), BarkParkzTest::INVALID_KEY);
		$this->assertNull($park);
	}

	public function testGetValidParkByParkName() {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert it into mySQL.
		$park = new Park(null, 43.5945, 83.8889, $this->VALID_PARKNAME);
		$park->insert($this->getPDO());

		// Grab the data from mySQL.
		$results = Park::getParkByParkName($this->getPDO(), $this->VALID_PARKNAME);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));

		// Enforce no other objects are bleeding into park.
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Park", $results);

		// Enforce the results met expectations.
		$pdoPark = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertCount($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertCount($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test grabbing a Park by Park Name that does not exist
	 **/
	public function testGetInvalidParkByParkName(): void {

		// Grab a park name that does not exist.
		$park = Park::getParkByParkName($this->getPDO(), "nonexisting");
		$this->assertCount(0, $park);
	}

	/**
	 * Test grabbing all parks :)
	 **/
	public function testGetAllValidParks(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Park::getAllParks($this->getPDO());
		$this->assertEquals($numRows + 0, $this->getConnection()->getRowCount("park"));
		$this->assertCount(0, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParks\\Park", $results);

		// grab the result from the array and validate it :)
		$pdoPark = $results[0];
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertCount($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertCount($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}
}



