<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * Bark Parkz Friend.
 *
 * This is what will most likely occur when a profile makes a Friend.
 *
 * @author Lea McDuffie <lea@littleloveprint.io>
 * @version 1
 **/
class Friend implements \JsonSerializable {
	/**
	 * id for the first Friend of this profile.
	 * @var int $friendFirstProfileId
	 **/
	private $friendFirstProfileId;
	/**
	 * id for the second Friend of this profile.
	 * @var int $friendSecondProfileId
	 **/
	private $friendSecondProfileId;

	/**
	 * Constructor for Friend.
	 *
	 * @param int $newFriendFirstProfileId id of the first friend
	 * @param int $newFriendSecondProfileId id of the second friend
	 * @throws \RangeException if $newFriendFirstProfileId is not positive
	 * @throws \RangeException if $newFriendSecondProfileId is not positive
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate type hints
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(int $newFriendFirstProfileId, int $newFriendSecondProfileId) {

		// Use the mutator methods to do the work for us.
		try {
			$this->setFriendFirstProfileId($newFriendFirstProfileId);
			$this->setFriendSecondProfileId($newFriendSecondProfileId);
		} catch(\RangeException | \Exception | \TypeError $exception) {


		// Determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * Accessor method for friend first profile id.
	 *
	 * @return int value of friend first profile id
	 **/
	public function getFriendFirstProfileId(): int {
		return ($this->friendFirstProfileId);
	}

	/**
	 * Mutator method for friend first profile id.
	 *
	 * @param int $newFriendFirstProfileId new value of friend first profile id
	 * @throws \RangeException if $newFriendFirstProfileId is not positive
	 * @throws \TypeError if $newFriendFirstProfileId is not an integer
	 **/
	public function setFriendFirstProfileId(int $newFriendFirstProfileId): void {

		// Verify the friend first profile id is positive.
		if($newFriendFirstProfileId <= 0) {
			throw(new \RangeException("friend first profile id is not positive"));
		}

		// Convert and store the friend first profile id.
		$this->friendFirstProfileId = $newFriendFirstProfileId;
	}

	/**
	 * Accessor method for friend second profile id.
	 *
	 * @return int value of friend second profile id
	 **/
	public function getFriendSecondProfileId(): int {
		return ($this->friendSecondProfileId);
	}

	/**
	 * Mutator method for friend second profile id.
	 *
	 * @param int $newFriendSecondProfileId new value of friend second profile id
	 * @throws \RangeException if $newFriendSecondProfileId is not positive
	 * @throws \TypeError if $newFriendSecondProfileId is not an integer
	 **/
	public function setFriendSecondProfileId(int $newFriendSecondProfileId): void {

		// Verify the friend second profile id is positive.
		if($newFriendSecondProfileId <= 0) {
			throw(new \RangeException("friend second profile id is not positive"));
		}

		// Convert and store the friend second profile id.
		$this->friendSecondProfileId = $newFriendSecondProfileId;
	}

	/** Insert friend into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError is $pdo is not a PDO connection object
	 **/

	public function insert(\PDO $pdo): void {

		// Ensure the object exists before inserting
		if($this->friendFirstProfileId === null || $this->friendSecondProfileId === null) {
			throw(new \PDOException("not a valid friend"));
		}

		// Create query template
		$query = "INSERT INTO friend(friendFirstProfileId, friendSecondProfileId) VALUES(:friendFirstProfileId, :friendSecondProfileId)";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template
		$parameters = ["friendFirstProfileId" => $this->friendFirstProfileId, "friendSecondProfileId" => $this->friendSecondProfileId];
		$statement->execute($parameters);
		var_dump($statement->rowCount());
	}

	/** Deletes this Friend from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError is $pdo is not in a PDO connection object
	 **/

	public function delete(\PDO $pdo): void {

		// As always, ensure the object exists before deleting
		if($this->friendFirstProfileId === null || $this->friendSecondProfileId === null) {
			throw(new \PDOException("not a valid friend"));
		}

		// Create query template
		$query = "DELETE FROM friend WHERE friendFirstProfileId = :friendFirstProfileId AND friendSecondProfileId = :friendSecondProfileId";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template
		$parameters = ["friendFirstProfileId" => $this->friendFirstProfileId, "friendSecondProfileId" => $this->friendSecondProfileId];
		$statement->execute($parameters);
	}

	/**
	 * Gets the Friend by friend first profile id and friend second profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $friendFirstProfileId first profile id to search for
	 * @param int $friendSecondProfileId second profile id to search for
	 * @return Friend|null Friend found or null if no friends found
	 **/

	public static function getFriendByFriendFirstProfileIdAndFriendSecondProfileId(\PDO $pdo, int $friendFirstProfileId, int $friendSecondProfileId): ?Friend {

		// Sanitize the friend first profile id and friend second profile id before searching
		if($friendFirstProfileId <= 0) {
			throw(new \PDOException("first profile id is not positive"));
		}
		if($friendSecondProfileId <= 0) {
			throw(new \PDOException("second profile id is not positive"));
		}

		// Create query template
		$query = "SELECT friendFirstProfileId, friendSecondProfileId FROM friend WHERE friendFirstProfileId = :friendFirstProfileId AND friendSecondProfileId = :friendSecondProfileId";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template
		$parameters = ["friendFirstProfileId" => $friendFirstProfileId, "friendSecondProfileId" => $friendSecondProfileId];
		$statement->execute($parameters);

		// Grab the friend from mySQL
		try {
			$friend = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$friend = new Friend($row["friendFirstProfileId"], $row["friendSecondProfileId"]);
			}
		} catch(\Exception $exception) {

			// If the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($friend);
	}

	/**
	 * Get Friend by friend first profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $friendFirstProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of Friends found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getFriendByFriendFirstProfileId(\PDO $pdo, int $friendFirstProfileId) : \SPLFixedArray {

		// Sanitize the profile id
		if($friendFirstProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// Create query template
		$query = "SELECT friendFirstProfileId FROM friend WHERE friendFirstProfileId = :friendFirstProfileId";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template
		$parameters = ["friendFirstProfileId" => $friendFirstProfileId];
		$statement->execute($parameters);

		// Build an array of friends
		$friends = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$like = new Friend($row["friendFirstProfileId"], $row["friendSecondProfileId"]);
				$friends[$friends->key()] = $friends;
				$friends->next();
			} catch(\Exception $exception) {

				// If the row couldn't be converted, rethrow it.
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($friends);
	}


	/**
	 * Gets all Friends by friend first profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Friends found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when varriables are not the correct data type
	 **/
	public static function getAllFriends(\PDO $pdo): \SplFixedArray {

		// Create query template
		$query = "SELECT friendFirstProfileId, friendSecondProfileId FROM friend";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// Build an array of Friends
		$friends = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$friend = new Friend($row["friendFirstProfileId"], $row["friendSecondProfileId"]);
				$friends[$friends->key()] = $friend;
				$friends->next();
			} catch(\Exception $exception) {

				// If the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($friends);
	}

	/**
	 * Formats the state variables for JSON serialization.
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		return (get_object_vars($this));
	}
}