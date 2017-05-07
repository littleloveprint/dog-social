<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * this is the class for favorite
 * where profiles will be able to favorite parks and profiles
 **/

class Favorite implements \JsonSerializable {
	/**
	 * id park being favored
	 * @var int $favoriteParkId
	 **/
	private $favoriteParkId;
	/**
	 * id of profile favoring a park
	 * @var int $lifeProfileId;
	 **/
	private $favoriteProfileId;
	/**
	 * construct for favorite
	 *
	 * @param int $newFavoriteProfileId
	 * @param int $newFavoriteParkId
	 * @throws \Exception if some other exception occurs
	 * @throws \TypeError if data types violate
	 * this is where we will hide our keywords and locations for the bug out app
	 **/
	public function __construct(int $newFavoriteProfileId, int $newFavoriteParkId) {
		// mutator methods do work
		try {
			$this->setFavoriteProfileId($newFavoriteProfileId);
			$this->setFavoriteParkId($newFavoriteParkId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			// determine what exception
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for profile
	 *
	 * @return int value of profile
	 **/
	public function getFavoriteProfileId() : int {
		return ($this->favoriteProfileId);
	}
	/**
	 * mutator method for profile
	 *
	 * @param int $newProfileId new value of id
	 * @throws \RangeException if $newProfileId is not +
	 * @throw \TypeError if $newProfileId is not an int
	 **/
	public function setFavoriteProfileId(int $newProfileId) : void {
		// verifies profile id is +
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		// convert and store profile id
		$this->favoriteProfileId = $newProfileId;
	}
	/**
	 * accessor method for park
	 *
	 * @return int value of park id
	 **/
	public function getFavoriteParkId() : int {
		return ($this->favoriteParkId);
	}
	/**
	 * mutator method park id
	 *
	 * @param int $newFavoriteParkId new value of park
	 * @throws \RangeException if $newParkId is not positive
	 * @throws \TypeError if $newParkId is not an int
	 **/
	public function setFavoriteParkId(int $newFavoriteParkId) : void {
		// verify park id
		if($newFavoriteParkId <= 0) {
			throw(new \RangeException("park id is not positive"));
		}
		// convert and store the profile id
		$this->favoriteParkId = $newFavoriteParkId;
	}
	/**
	 * inserts Favorite into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		// ensure the object exist before inserting
		if($this->favoriteProfileId === null || $this->favoriteParkId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// creates query table
		$query = "INSERT INTO favorite(favoriteProfileId, favoriteParkId) VALUES(:favoriteProfileId, :favoriteParkId)";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteParkId" => $this->favoriteParkId];
		$statement->execute($parameters);
	}
	/**
	 * delete fav from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// ensure the object exist before deleting
		if($this->favoriteProfileId === null || $this->favoriteParkId === null) {
			throw(new \PDOException("not a valid favorite"));
		}
		// create query template
		$query = "DELETE FROM favorite WHERE favoriteProfileId = :favoriteProfileId AND favoriteParkId = :favoriteParkId";
		$statement = $pdo->prepare($query);
		// bind member vars to the place holders
		$parameters = ["favoriteProfileId" => $this->favoriteProfileId, "favoriteParkId" => $this->favoriteParkId];
		$statement->execute($parameters);
	}
	/**
	 * gets the favorite by park id and profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId profile id to search for
	 * @param int $favoriteParkId tweet id to search for
	 * @return Favorite|null Like found or null if not found
	 **/
	public static function getFavoriteByFavoriteParkIdAndFavoriteProfileId(\PDO $pdo, int $favoriteProfileId, int $favoriteParkId) : ?Favorite {
		// sanitize the favorite id and profile id before search
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		if($favoriteParkId <= 0) {
			throw(new \PDOException("park id is not positive"));
		}
		// create query table
		$query = "SELECT favoriteProfileId, favoriteParkId FROM favorite WHERE favoriteProfileId = :favoriteProfileId AND favoriteParkId = :favoriteParkId";
		$statement = $pdo->prepare($query);
		// bind the park id and profile id to the place holder
		$parameters = ["favoriteProfileId" => $favoriteProfileId, "favoriteParkId" => $favoriteParkId];
		$statement->execute($parameters);
		// grab the favorite from mySQL
		try {
			$favorite = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteParkId"]);
			}
		} catch(\Exception $exception) {
			// if the row can't convert rethrow it
			throw(new \PDOException($exception->getMessage(), 0 ,$exception));
		}
		return ($favorite);
	}
	/**
	 * gets the favorite by profileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteProfileId profile id to search for
	 * @return \SplFixedArray SplFixedArray of Favorites found or null
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when vars are not the correct data type
	 **/
	public static function getFavoriteByFavoriteProfileId(\PDO $pdo, int $favoriteProfileId) : \SPLFixedArray {
		// sanitize the profile id
		if($favoriteProfileId <= 0) {
			throw(new \PDOException("profile id is not positive"));
		}
		// create query
		$query = "SELECT favoriteProfileId, favoriteParkId FROM favorite WHERE favoriteProfileId = :favoriteProfileId";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders
		$parameters = ["favoriteProfileID" => $favoriteProfileId];
		$statement->execute($parameters);
		// build array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileId"], $row["favoriteParkId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if the row couldnt be converted rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}
	/**
	 * get the favorite by park id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $favoriteParkId park id to search for
	 * @return \SplFixedArray array of favorites found or null if nah
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when vars are not correct type
	 **/
	public static function getFavoriteByFavoriteParkId(\PDO $pdo, int $favoriteParkId) : \SplFixedArray {
		// sanitize park id
		$favoriteParkId = filter_var($favoriteParkId, FILTER_VALIDATE_INT);
		if($favoriteParkId <= 0) {
			throw(new \PDOException("park id is not positive"));
		}
		$query = "SELECT favoriteProfileId, favoriteParkId FROM favorite WHERE favoriteParkId = :favoriteParkId";
		$statement = $pdo->prepare($query);
		// bind the member vars to the place holders in the template
		$parameters = ["favoriteParkId" => $favoriteParkId];
		$statement->execute($parameters);
		// build array of favorites
		$favorites = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$favorite = new Favorite($row["favoriteProfileID"], $row["favoriteParkId"]);
				$favorites[$favorites->key()] = $favorite;
				$favorites->next();
			} catch(\Exception $exception) {
				// if new row cant be converted rethrow
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($favorites);
	}
	/**
	 * formats state vars for JSON serialization
	 *
	 * @return array results in state vars to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return ($fields);
	}
}