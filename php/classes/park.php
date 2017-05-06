<?php
namespace Edu\CNM\BarkParkz
require_once ("autoload.php");
/**
 * Bark Parkz Park
 * @author Emily Rose
 * @version 1
 * Date: 5/5/2017
 * Time: 10:46 AM
 **/
class Park implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this Park; this is the primary key
	 * @var int $parkId
	 **/
	private $parkId;
	/**
	 * Location of the park X
	 * @var int $parkLocationX
	 **/
	private $parkLocationX;
	/**
	 * Location of the park Y
	 * @var int $parkLocationY
	 **/
	private $parkLocationY;
	/**
	 * Name of Park
	 * @var string $parkName
	 */
	private $parkName;
	/**
	 * constructor for this Park
	 *
	 * @param int|null $newParkId id of this Park or null if a new Park
	 * @param int $new
	 *
	 *
	 **/
	public function _construct(?int $newParkId, ?int $newParkLocationX, ?int $newParkLocationY, string $parkName = null) {
	try {
						$this->setParkId($newParkId);
						$this->setParkLocationX($newParkLocationX);
						$this->setParkLocationY($newParkLocationY);
						$this->setParkName($newParkName);
}
						//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
						$exceptionType = get_class($exception);
						throw(new $exceptionType($exception->getMessage(), 0, $exception));
	}
	}
/** accessor method for park id
 *
 @return int|null value of park id
 **/
public function getParkId() : int {
		return($this->parkId);
}

/**
 * mutator method for park id
 *
 * @param int|null $newParkId new value of park id
 * @throws \RangeException if $newParkId is not positive
 * @throws \TypeError if $newParkId is not an integer
 **/
public function setParkId(?int $newParkId) : void {
		//if park id is null immediately return it
		if($newParkId === null) {
			$this->parkId = null;
			return;
		}
	//verify the park id is positive
	if($newParkId <=0) {
			throw(new \RangeException("park id is not positive"));
	}

	//convert and store the park id
	$this->parkId = $newParkId;
}

/**
 * accessor method for park location X
 *
 * @return int value of park location X
 **/
public function getParkLocationX() : int{
			return($this->parkLocationX);
}

/**
 * mutator method for park location X
 *
 * @param int $newParkLocationX new value of park location X
 * @throws \RangeException if $newParkLocationX is not positive
 * @throws \TypeError if $newParkLocationX is not an integer
 **/
public function setParkLocationX(int $newParkLocationX) : void {

			// verify the profile id is positive
			if($newParkLocationX <= 0) {
					throw(new \RangeException("park location x is not positive"));
			}

			// convert and store the park location x
			$this->parkLocationX = $newParkLocationX;
}

/**
 * accessor method for park location Y
 *
 * @return int value of park location Y
 **/
public function getParkLocationY() : int{
			return($this->parkLocationY);
}

/**
 * mutator method for park location y
 * @param int $newParkLocationY new value of park location y
 * @throws \RangeException if $newParkLocationY is not positive
 * @throws \TypeError if $newprofileId is not an integer
 **/
public funtion setParkLocationY(int $newParkLocationY) : voide {

			// verify the park location y is positive
			if($newParkLocationY <= 0) {
					throw(new \RangeException("park location y is not positive"));
			}

			// convert and store the park location Y
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
public function setParkName(string $newParkName) : void {
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
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function insert(\PDO $pdo) : void {
	// enforce the parkId is null (i.e., don't insert a park that already exists)
	if($this->parkId !== null) {
		throw(new \PDOException("not a new park"));
	}

	// create a query template
	$query = "INSERT INTO park(parkId, parkLocationX, parkLocationY, parkName) VALUES(:parkId, :parkLocationX, :parkLocationY, :parkName)";
	$statement = $pdo->prepare($query);

	// bind the member variables to the place holders in the template
	$parameters = ["parkId" => $this->parkId, "parkLocationX" => $this->parkLocationX, "parkLocationY" => $this->parkLocationY, "parkName" => $this->parkName, $statement->execute($parameters)];

	// update the null parkId with what mySQL just gave us
	$this->parkId = intval($pdo->lastInsertId());
}

/**
 * deletes this Park from mySQL
 *
 * @param \PDO $pdo PDO connection object
 * @throws \PDOException when mySQL related errors occur
 * @throws \TypeError if $pdo is not a PDO connection object
 **/
public function delete(\PDO $pdo) : void {
		// enforce the parkId is not null (i.e., don't delete a park that hasn't been inserted)
		if($this->parkId === null) {
				throw(new \PDOException("unable to delete a park that does not exist"))
		}

		//create query template
		$query = "DELETE FROM park WHERE parkId = :parkId";
		statement = $pdo->prepare($query);

		// bind the member variables to the place holder in the template
		$parameters = ["parkId => $this->parkId"];
		$statement->execute($parameters);
}
