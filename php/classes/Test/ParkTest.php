<?php

namespace Edu\Cnm\BarkParkz\Test;

use Edu\Cnm\BarkParkz\Park;

//Grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");


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
	 * Valid location x to use
	 * @var string $VALID_LOCATIONX
	 **/
	protected $VALID_LOCATIONX;

	/**
	 * Valid location y to use
	 * @var string $VALID_LOCATIONY ;
	 **/
	protected $VALID_LOCATIONY;

	/**
	 * Test inserting a valid Park and verify that the actual mySQL data matches
	 **/
	public function testInsertValidPark(): void {

		// Count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert into mySQL
		$park = new Park (null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);

		// var_dump($park);

		$park->insert($this->getPDO());

		// Grab the data from mySQL and be sure the fields match our expectations.
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount(), $park->));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertEquals($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
}

	/**
	 * Test inserting a Park that already exists
	 *
	 * @expectException \PDOException
	 **/
	public function testInsertInvalidPark(): void {

// Create a park with a non null parkId and watch it fail hahaha
		$park = new Park(BarkParkzTest::INVALID_KEY, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->insert($this->getPDO());
	}

	/**
	 * Test inserting a Park, editing it, and then updating it
	 **/
	public function testInsertInvalidPark() {

		// Count the number of rows, and save it for later.
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert into mySQL
		$park = new Park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->insert($this->PDO());

		// Edit the Park nd update it in mySQL
		$park->setParkName($this->VALID_PARKNAME);
		$park->update($this->getPDO());

		// Grab the data from mySQL and enforce the fields match our expectations.
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertsEquals($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test creating a Park and then deleting it
	 **/
	public function testDeleteValidPark(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowcount("park");

		// Create a new Park and insert into mySQL
		$park = new Park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->insert($this->getPDO());

		// Edit the Park and update it in mySQL
		$park->setParkID($this->VALID_PARKID);
		$park->update($this->getPDO());

// Grab the data from mySQL and enforce and the fields match our expectations
		$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
		$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
		$this->assertEquals($pdoPark->getParkLocationX(), $this->VALID_LOCATIONX);
		$this->assertEquals($pdoPark->getParkLocationY(), $this->VALID_LOCATIONY);
	}

	/**
	 * Test updating a Park that does not exist
	 *
	 * @expectedException \PDOException
	 **/
	public function testUpdateInvalidPark() {

		// Create a Park and try to update it without actually inserting it
		$park = new Park(newParkId: null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
$park->update($this->getPDO());
}

	/**
	 * Test creating a Park and then deleting it
	 **/
	public function testDeleteValidPark(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Profile and insert it into mySQL
		$park = new Park(null $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->update($this->getPDO());

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
		$park - new park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->delete($this->getPDO());
	}

	/**
	 * Test deleting a Park that does not exist
	 *
	 * @expectedException \PDOException
	 **/

	public function testDeleteInvalidPark(): void {

		// Create a Park and try to delete it without actually inserting it
		$park = new Park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->delete($this->getPDO());
	}

	/**
	 * Test inserting a Park and regrabbing it from mySQL
	 **/
	public function testGetValidParkbyParkId(): void {

		// Count the number of the rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Park and insert it into mySQL
		$park = new Park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
		$park->insert($this->getPDO());
	}

	// Grab the data from mySQL and be sure the fields match our expectations
$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
$this->assertEquals(pdoPark->getParkID(), $this->VALID_PARKID);
$this->assertEquals(pdoPark->getParkName(), $this->VALID_PARKNAME);
$this->assertEquals(pdoPark->getParkLocationX(), $this->VALID_PARKLOCATIONX);
$this->assertEquals(pdoPArk->getParkLocationY(), $this->VALID_PARKLOCATIONY);
}

/**
 * Test grabbing a Park by its Id
 **/
public
function testGetValidParkById(): void {

	// Count the number of rows, and save it for later
	$numRows = $this->getConnection()->getRowCount("park");

	// Create a new Park and insert it into mySQL
	$park = new Park(null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_PARKLOCATIONX, $this->VALID_PARKLOCATIONY);
	$park->insert($this->getPDO());

// Grab the data from mySQL and be sure the fields match our expectations
	$pdoPark = Park::getParkByParkId($this->getPDO(), $park->getParkId());
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
	$this->assertEquals(pdoPark->getParkName(), $this->VALID_PARKNAME);
	$this->assertEquals(pdoPark->getParkLocationX(), $this->VALID_PARKLOCATIONX);
	$this->assertEquals(pdoPark->getParkLocationY(), $this->VALID_PARKLOCATIONY);
}

/**
 * Test grabbing a Park that does not exist
 **/
public
function testGetInvalidParkByParkId(): void {

	// Grab a park id that exceeds the maximum allowable park id
	$park = Park::getParkByParkId($this->getPDO(), BarkParkzTest::INVALID_KEY);
	$this->assertNull($park);
}

public
function testGetValidParkByParkName() {

	// Count the number of rows, and save it for later.
	$numRows = $this->getConnection()->getRowCount("park");

	// Create a new Park and insert it into mySQL.
	$park = new Park(null, $this->VALID_PARKNAME, $this->VALID_PARKID, $this->VALID_PARKLOCATIONX, $this->VALID_PARKLOCATIONY);
	$park->insert($this->getPDO());

	// Grab the data from mySQL.
	$results = Park::getParkByParkName($this->getPDO(), $this->VALID_PARKNAME);
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));

	// Enforce no other objects are bleeding into park.
	$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\BarkParkz\\Profile", $results);

	// Enforce the results met expectations.
	$pdoPark = $results[0];
	$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("park"));
	$this->assertEquals($pdoPark->getParkId(), $this->VALID_PARKID);
	$this->assertEquals($pdoPark->getParkName(), $this->VALID_PARKNAME);
	$this->assertEquals($pdoPark->getParkLocationX(), $this->VALID_PARKLOCATIONX);
	$this->assertEquals($pdoPark->getParkLocationY(), $this->VALID_PARKLOCATIONY);
}

/**
 * Test grabbing a Park by Park Name that does not exist
 **/
public
function testGetValidParkByParkName(): void {

	// Grab a park name that does not exist.
	$park = Park::getParkByParkName($this->getPDO(), "nonexisting");
	$this->assertCount(0, $park);
}


