<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * this is the check-in page for barkparkz HMB
 **/
class CheckIn implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for check-in
	 *
	 * @var int $checkInId
	 **/
	private $checkInId;
	/**
	 * DogId for check-in
	 *
	 * @var string $checkInDogId
	 **/
	private $checkInDogId;
	/**
	 * park id for check in
	 *
	 * @var string $checkInParkId
	 **/
	private $checkInParkId;
	/**
	 * checkIn DateTime
	 *
	 * @var \DateTime $checkInDateTime
	 **/
	private $checkInDateTime;
	/**
	 * checkOut DateTime
	 *
	 * @var \DateTime $checkOutDateTime
	 **/
	private $checkOutDateTime;
	/**
	 * constructor for check-in
	 *
	 * @param int $newCheckInId
	 * @param int $newCheckInDogId
	 * @param int $newCheckInParkId
	 * @param \DateTime|null $newCheckInDateTime date of check in
	 * @param \DateTime|null $newCheckOutDateTime date of check out
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 **/
	public function __construct(int $newCheckInId, int $newCheckInDogId, int $newCheckInParkId, $newCheckInDateTime = null, $newCheckOutDateTime = null) {
		// use mutator method to do work
		try {
			$this->setCheckInId($newCheckInId);
			$this->setCheckInDogId($newCheckInDogId);
			$this->setCheckInParkId($newCheckInParkId);
			$this->setCheckInDateTime($newCheckInDateTime);
			$this->setCheckOutDateTime($newCheckOutDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception was throw
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for checkInId
	 * @return int value of checkInId
	 **/
	public function getCheckInId() : int {
		return ($this->checkInId);
	}
	/**
	 * mutator method for checkInId
	 *
	 * @param int $newCheckInId new value of check in id
	 * @throws \RangeException if $newCheckInId is not positive
	 * @throws \TypeError if $newCheckInId is not an int
	 **/
	public function setCheckInId(int $newCheckInId) : void {
		// verify the check in id is positive
		if($newCheckInId <= 0) {
			throw(new \RangeException("check in id is not positive"));
		}
		$this->checkInId = $newCheckInId;
	}
	/**
	 * accessor for checkInDogId
	 *
	 * @return int value of checkInDogId
	 **/
	public function getCheckInDogId() : int {
		return ($this->checkInDogId);
	}
	/**
	 * mutator method for checkInDogId
	 *
	 * @param int $newCheckInDogId new value of dog check in id
	 * @throws \RangeException if $newCheckInDogId is not positive
	 * @throws \TypeError if $newCheckInDogId is not an int
	 **/
	public function setCheckInDogId(int $newCheckInDogId) : void {
		//verify the check in dog id is positive
		if($newCheckInDogId <= 0) {
			throw(new \RangeException("check in dog id is not positive"));
		}
		$this->checkInDogId = $newCheckInDogId;
	}
	/**
	 * accessor method for checkInParkId
	 *
	 * @return int value of checkInParkId
	 **/
	public function getCheckInParkId() : int {
		return ($this->checkInParkId);
	}
	/**
	 * mutator method for the checkInParkId
	 *
	 *@param int $newCheckInParkId new value of check in park id
	 *@throws \RangeException if $newCheckInParkId is not positive
	 *@throws \TypeError if $newCheckInParkId is not an int
	 **/
	public function setCheckInParkId(int $newCheckInParkId) : void {
		// verify is park id is positive
		if($newCheckInParkId <= 0) {
			throw(new \RangeException("park id is not positive"));
		}
		$this->checkInParkId = $newCheckInParkId;
	}
	/**
	 * accessor method for checkInDateTime
	 *
	 * @return \DateTime value of checkInDateTime
	 **/
	public function getCheckInDateTime() : \DateTime {
		return ($this->checkInDateTime);
	}
	/**
	 * mutator method for checkInDateTime
	 *
	 * @param \DateTime|string|null $newCheckInDateTime check in date as DateTime object or string(or null to load current time)
	 * @throws \InvalidArgumentException if $newCheckInDateTime is not a valid object or string
	 * @throws \RangeException if $newCheckInDateTime is a date that does not exist
	 **/
	public function setCheckInDateTime($newCheckInDateTime): void {
		// base case if date is null use current time and date
		if($newCheckInDateTime === null) {
			$this->checkInDateTime = new \DateTime();
			return;
		}
		// store the like date using ValidateDate trait
		try {
			$newCheckInDateTime = self::validateDateTime($newCheckInDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->checkInDateTime = $newCheckInDateTime;
	}
	/**
	 * accessor method for checkOutDateTime
	 *
	 * @return \DateTime value of checkOutDateTime
	 **/
	public function getCheckOutDateTime() : \DateTime {
		return ($this->checkOutDateTime);
	}
	/**
	 * mutator method for checkOutDateTime
	 *
	 * @param \DateTime|string|null $newCheckOutDateTime check in date as DateTime object or string(or null to load current time)
	 * @throws \InvalidArgumentException if $newCheckOutDateTime is not a valid object or string
	 * @throws \RangeException if $newCheckOutDateTime is a date that does not exist
	 **/
	public function setCheckOutDateTime($newCheckOutDateTime): void {
		// base case if date is null use current time and date
		if($newCheckOutDateTime === null) {
			$this->checkOutDateTime = new \DateTime();
			return;
		}
		// store the like date using ValidateDate trait
		try {
			$newCheckOutDateTime = self::validateDateTime($newCheckOutDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->checkOutDateTime = $newCheckOutDateTime;
	}
	/**
	 * inserts check in into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// ensure object exist before insert
		// not sure if i should if $this->checkInId
		if($this->checkInId === null || $this->checkInParkId === null || $this->checkInDogId) {
			throw (new \PDOException("not a valid check in"));
		}
		$query = "INSERT INTO checkIn (checkInDogId, checkInParkId, checkInDateTime, checkOutDateTime) VALUES(:checkInDogId, checkInParkId, checkInDateTime, checkOutDateTime)";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders in the template
		// because i have check in and out im sure how to write this
		$formattedDateIn = $this->checkInDateTime->format("Y-m-d H:i:s");
		$formattedDateOut = $this->checkInDateTime->format("Y-m-d H:i:s");
		$parameters = ["checkInId" => $this->checkInId, "checkInDogId" => $this->checkInDogId, "checkInParkId" => $this->checkInParkId, "checkInDateTime" => $formattedDateIn, "checkOutDateTime" => $formattedDateOut];
		$statement->execute($parameters);
	}
	/**
	 * deletes check in from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mysql errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// ensure the object exist before deleting
		if($this->checkInId === null || $this->checkInParkId === null || $this->checkInDogId){
			throw(new \PDOException("not a valid check in"));
		}
		// create query template
		$query = "DELETE FROM checkIn WHERE checkInId = :checkInId AND checkInParkId = :checkInParkId AND checkInDogId = :checkInDogId";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holds in the template
		$parameters = ["checkInId" => $this->checkInId, "checkInParkId" => $this->checkInParkId, "checkInDogId" => $this->checkInDogId];
		$statement->execute($parameters);
	}
	/**
	 * updates checkin in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// enforce the checkInId is not null
		if($this->checkInId === null) {
			throw(new \PDOException("unable to update a check in that does not exist"));
		}
		// create query template
		$query = "UPDATE checkIn SET checkInDogId = :checkInDogId, checkInParkId = :checkInParkId, checkInDateTime = :checkInDateTime, checkOutDateTime = :checkOutDateTime WHERE checkInId = :checkInId";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders in the template
		$formattedDateIn = $this->checkInDateTime->format("Y-m-d H:i:s");
		$formattedDateOut = $this->checkOutDateTime->format("Y-m-d H:i:s");
		$parameters = ["checkInId" => $this->checkInId, "checkInDogId" => $this->checkInDogId, "checkInParkId" => $this->checkInParkId, "checkInDateTime" => $formattedDateIn, "checkOutDateTime" => $formattedDateOut];
		$statement->execute($parameters);
	}
	/**
	 * get checkIn by checkInId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $checkInId check in id to search
	 * @return checkIn|null checkInId or null if nah
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when vars are not the correct data type
	 **/
	public static function getCheckInByCheckInId(\PDO $pdo, int $checkInId) :?CheckIn {
		// sanitize the checkInId before searching
		if($checkInId <=0) {
			throw(new \PDOException("check in id is not positive"));
		}
		// create query table
		$query = "SELECT checkInId, checkInDogId, checkInParkId FROM checkIn WHERE checkInId = :checkInId";
		$statement = $pdo->prepare($query);
		// bind the check in id to the place holder in the template
		$parameters = ["checkInId" => $checkInId];
		$statement->execute($parameters);
		// grab the check in id from mySQL
		try {
			$checkIn = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$checkIn = new CheckIn($row["checkInId"], $row["checkInDogId"], $row["checkInParkId"], $row["checkInDateTime"], $row["checkOutDateTime"]);
			}
		} catch(\Exception $exception) {
			// if the row couldn't be converted rethrow
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($checkIn);
	}
	/**
	 * gets the checkIn by dog id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $checkInDogId dog id to search for
	 * @return \SplFixedArray SplFixedArray of dogs founds or null if not found
	 * @throws \PDOException when mySQL errors occur
	 * @throws \TypeError when vars are not the correct data type
	 **/
	public static function getCheckInByCheckInDogId(\PDO $pdo, int $checkInDogId): \SplFixedArray {
		// sanitize the checkInDogId before searching
		if($checkInDogId <= 0) {
			throw(new \PDOException("dog check in id is not positive"));
		}
		// create query template
		$query = "SELECT checkInId, checkInParkId FROM checkIn WHERE checkInDogId = :checkInDogId";
		$statement = $pdo->prepare($query);
		// bind the check in dog id to the place holder in the template
		$parameters = ["checkInDogId" => $checkInDogId];
		$statement->execute($parameters);
		// build array of dogs
		$dogIds = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$dogId = new CheckIn($row["checkInId"], $row["checkInDogId"], $row["checkInParkId"], $row["checkInDateTime"], $row["checkOutDateTime"]);
				$dogIds[$dogIds->key()] = $dogId;
				$dogIds->next();
			} catch(\Exception $exception) {
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		} return ($dogIds);
		}
	/**
	 * get check in by park id
	 *
	 * @param \PDO $pdo connection object
	 * @param int $checkInParkId park id to search for
	 * @return \SPLFixedArray splfixed array of park ids found or null if not
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when vars are not the correct data type
	 **/
	public static function getCheckInByCheckInParkId(\PDO $pdo, int $checkInParkId) : \SplFixedArray {
		// sanitize the park id
		if($checkInParkId <= 0) {
			throw(new \PDOException("park id is not positive"));
		}
		// create query template
		$query = "SELECT checkInParkId, checkInDogId, checkInId FROM checkIn WHERE checkInParkId = :checkInParkId";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders in the template
		$parameters = ["checkInParkId" => $checkInParkId];
		$statement->execute($parameters);
		// build an array of parks
		$parks = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$park = new Park($row["checkInParkId"], $row["checkInId"], $row["checkInDogId"], $row["checkInDateTime"], $row["checkOutDateTime"]);
				$parks[$parks->key()] = $park;
				$parks->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($parks);
	}
	/**
	 * get check in by check in date
	 *
	 * @param \PDO $pdo connection object
	 * @param \DateTime $sunriseCheckInDateTime beginning date to search for
	 * @param \DateTime $sunsetCheckInDateTime ending date to search for
	 * @return \SplFixedArray of check ins found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 * @throws \InvalidArgumentException if either sun dates are in the wrong format
	 **/
	public static function getCheckInByCheckInDateRange(\PDO $pdo, \DateTime $sunriseCheckInDateTime, \DateTime $sunsetCheckInDateTime ) : \SplFixedArray {
		// enforce both dates present
		if((empty ($sunriseCheckInDateTime) === true) || (empty($sunsetCheckInDateTime) === true)) {
			throw (new \InvalidArgumentException("dates are empty or insecure"));
		}
		// ensure both dates are in the correct format and are secure
		try {
			$sunriseCheckInDateTime = self::validateDateTime($sunriseCheckInDateTime);
			$sunsetCheckInDateTime = self::validateDateTime($sunsetCheckInDateTime);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0 , $exception));
		}
		// create query template
		$query = "SELECT checkInId, checkInDogId, checkInParkId, checkInDateTime FROM checkIn WHERE checkInDateTime >= :sunriseCheckInDateTime AND checkInDateTime <= :sunsetCheckInDateTime";
		$statement = $pdo->prepare($query);
		// format the dates so that mySQL can use them
		$formattedSunriseDate = $sunriseCheckInDateTime->format("Y-m-d H:i:s");
		$formattedSunsetDate = $sunsetCheckInDateTime->format("Y-m-d H:i:s");
		$parameters = ["sunriseCheckInDateTime" => $formattedSunriseDate, "sunsetCheckInDateTime" => $formattedSunsetDate];
		$statement->execute($parameters);
		// build an array of check ins
		$checkIns = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$checkIn = new CheckIn($row["checkInId"], $row ["checkInDogId"], $row ["checkInParkId"], $row["checkInDateTime"], $row["checkOutDateTime"]);
				$checkIns[$checkIns->key()] = $checkIn;
				$checkIns->next();
			} catch(\Exception $exception) {
				throw (new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($checkIns);
	}
	/**
	 * formats state vars for JSON serialization
	 * first time doing dates HMB
	 *
	 * @return array resulting state vars to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["checkInDateTime"] = round(floatval($this->checkInDateTime->format("U.u")) * 1000);
		$fields["checkOutDateTime"] = round(floatval($this->checkOutDateTime->format("U.u")) * 1000);
		return ($fields);
	}
}