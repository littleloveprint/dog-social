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
	public function testInsertValidProfile(): void {

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
	 * Test inserting a Profile that already exists
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
	public function testUpdateInvalid() {

		// Create a Park and try to update it without actually inserting it
		$park = new Park(newProfileId: null, $this->VALID_PARKID, $this->VALID_PARKNAME, $this->VALID_LOCATIONX, $this->VALID_LOCATIONY);
$park->update($this->getPDO());
}

	/**
	 * Test creating a Park and then deleting it
	 **/
	public function testDeleteValidPark(): void {

		// Count the number of rows, and save it for later
		$numRows = $this->getConnection()->getRowCount("park");

		// Create a new Profile and insert it into mySQL
	}
}
