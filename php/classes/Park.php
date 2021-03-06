<?php

namespace Edu\CNM\BarkParkz;
require_once("autoload.php");

/**
 * Bark Parkz Park
 * @author Emily Rose Halleran
 * @version 1
 * Date: 5/5/2017
 * Time: 10:46 AM
 **/
class Park implements \JsonSerializable {
	/**
	 * id for this Park; this is the primary key
	 * @var int $parkId
	 **/
	private $parkId;
	/**
	 * Location of the park X
	 * @var float $parkLocationX
	 **/
	private $parkLocationX;
	/**
	 * Location of the park Y
	 * @var float $parkLocationY
	 **/
	private $parkLocationY;
	/**
	 * Name of Park
	 * @var string $parkName
	 **/
	private $parkName;

	/**
	 * constructor for this Park
	 *
	 * @param int|null $newParkId id of this Park or null if a new Park
	 * @param float $newParkLocationX containing a user's declared location
	 * @param float $newParkLocationY containing a user's declared location
	 * @param string $newParkName string containing park name
	 * @internal param string $newParkName string containing actual park name
	 **/
	public function __construct(?int $newParkId, float $newParkLocationX, float $newParkLocationY, string $newParkName) {
		try {
			$this->setParkId($newParkId);
			$this->setParkLocationX($newParkLocationX);
			$this->setParkLocationY($newParkLocationY);
			$this->setParkName($newParkName);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/** accessor method for park id
	 *
	 * @return int|null value of park id
	 **/
	public function getParkId(): int {
		return ($this->parkId);
	}

	/**
	 * mutator method for park id
	 *
	 * @param int|null $newParkId new value of park id
	 * @throws \RangeException if $newParkId is not positive
	 * @throws \TypeError if $newParkId is not an integer
	 **/
	public function setParkId(?int $newParkId): void {
		//if park id is null immediately return it
		if($newParkId === null) {
			$this->parkId = null;
			return;
		}
		//verify the park id is positive
		if($newParkId <= 0) {
			throw(new \RangeException("park id is not positive"));
		}

		//convert and store the park id
		$this->parkId = $newParkId;
	}

	/**
	 * accessor method for park location X
	 *
	 * @return float of park location X
	 **/
	public function getParkLocationX(): float {
		return ($this->parkLocationX);
	}

	/**
	 * mutator method for park location X
	 *
	 * @param float $newParkLocationX new value of park location X
	 * @throws \RangeException if $newParkLocationX is not positive
	 * @throws \TypeError if $newParkLocationX is not a float
	 **/
	public function setParkLocationX(float $newParkLocationX): void {

		// verify the park location x is secure
		if($newParkLocationX < -90 || $newParkLocationX > 90) {
			throw(new \RangeException("park location x is out of range"));
		}

		// convert and store the park location x
		$this->parkLocationX = $newParkLocationX;
	}

	/**
	 * accessor method for park location Y
	 *
	 * @return float value of park location Y
	 **/
	public function getParkLocationY(): float {
		return ($this->parkLocationY);
	}

	/**
	 * mutator method for park location y
	 * @param float $newParkLocationY new value of park location y
	 * @throws \RangeException if $newParkLocationY is not positive
	 * @throws \TypeError if $newParkLocationY is not a float
	 **/
	public function setParkLocationY(float $newParkLocationY): void {

		// verify the park location y is positive
		if($newParkLocationY < -180 || $newParkLocationY > 180) {
			throw(new \RangeException("park location y is out of range"));
		}

		// convert and store the park location Y
		// @var parkLocationY $this
		$this->parkLocationY = $newParkLocationY;
	}


	/**
	 * accessor method for parkName
	 *
	 * @return string value of park name
	 **/
	public function getParkName(): string {
		return ($this->parkName);
	}

	/**
	 * mutator method for park name
	 *
	 * @param string $newParkName new value of park name
	 * @throws \InvalidArgumentException if $newParkname is not a string or insecure
	 * @throws \RangeException if $newParkName is > 32 characters
	 * @throws \TypeError if $newParkName
	 **/

	public function setParkName(string $newParkName): void {
		// verify the park name is secure
		$newParkName = trim($newParkName);
		$newParkName = filter_var($newParkName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newParkName) === true) {
			throw(new \InvalidArgumentException("park name is empty or insecure"));
		}
		// verify the park name will fit in the database
		if(strlen($newParkName) > 32) {
			throw(new \RangeException("park name is too large"));
		}

		// store the park name
		$this->parkName = $newParkName;
	}

	/**
	 * inserts this Park into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 **/

	public function insert(\PDO $pdo): void {
		// enforce the parkId is null (i.e., don't insert a park that already exists)
		if($this->parkId !== null) {
			throw(new \PDOException("not a new park"));
		}

		// create a query template
		$query = "INSERT INTO park(parkLocationX, parkLocationY, parkName) VALUES(:parkLocationX, :parkLocationY, :parkName)";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holders in the template
		$parameters = ["parkLocationX" => $this->parkLocationX, "parkLocationY" => $this->parkLocationY, "parkName" => $this->parkName];

		$statement->execute($parameters);

		// update the null parkId with what mySQL just gave us
		$this->parkId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this Park from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 *
	 **/
	public function delete(\PDO $pdo): void {
		// enforce the parkId is not null (i.e., don't delete a park that hasn't been inserted)
		if($this->parkId === null) {
			throw(new \PDOException("unable to delete a park that does not exist"));
		}

		//create query template
		$query = "DELETE FROM park WHERE parkId = :parkId";
		$statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["parkId" => $this->parkId];
		$statement->execute($parameters);
	}

	/**
	 * gets the Park by parkId
	 * @param \PDO $pdo PDO connection object
	 * @param int $parkId park id to search for
	 * @return Park|null
	 **/
	public static function getParkByParkId(\PDO $pdo, int $parkId): ?Park {
		// sanitize the parkId before searching
		if($parkId <= 0) {
			throw(new \PDOException("park id is not positive"));
		}

		// create query template
		$query = "SELECT parkId, parkLocationX, parkLocationY, parkName FROM park WHERE parkId = :parkId";
		$statement = $pdo->prepare($query);

		//bind the park id to the place holder in the template
		$parameters = ["parkId" => $parkId];
		$statement->execute($parameters);

		//grab the park from mySQL
		try {
			$park = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$park = new Park($row["parkId"], $row["parkLocationX"], $row["parkLocationY"], $row["parkName"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($park);
	}

	/**
	 * gets the Park by name
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $parkName park name to search for
	 * @return \SplFixedArray SplFizedArray of Parks found
	 * @throw \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getParkByParkName(\PDO $pdo, string $parkName): \SplFixedArray {
		// sanitize the description before searching
		$parkName = trim($parkName);
		$parkName = filter_var($parkName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($parkName) === true) {
			throw(new \PDOException("park name is invalid"));
		}

		//create query template
		$query = "SELECT parkId, parkLocationX, parkLocationY, parkName FROM park WHERE parkName LIKE :parkName";
		$statement = $pdo->prepare($query);

		// bind the park name to the place holder in the template
		$parkName = "%$parkName%";
		$parameters = ["parkName" => $parkName];
		$statement->execute($parameters);

		//build an array of parks
		$parks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$park = new Park($row["parkId"], $row["parkLocationX"], $row["parkLocationY"], $row["parkName"]);
				$parks[$parks->key()] = $park;
				$parks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($parks);
	}

	/**
	 * gets all Parks
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Parks found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllParks(\PDO $pdo): \SplFixedArray {
		// create a query template
		$query = "SELECT parkId, parkLocationX, parkLocationY, parkName FROM park";
		$statement = $pdo->prepare($query);
		$statement->execute();

		//build an array of parks
		$parks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$park = new Park($row["parkId"], $row["parkLocationX"], $row["parkLocationY"], $row["parkName"]);

				$parks[$parks->key()]=$park;
				$parks->next();

			} catch(\Exception $exception) {
				// if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($parks);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public
	function jsonSerialize() {
		return (get_object_vars($this));
	}
}