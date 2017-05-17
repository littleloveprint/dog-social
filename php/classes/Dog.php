<?php

namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");

/**
 * Created by PhpStorm.
 * @author Gerrit Van Dyke gerritv8484@gmail.com
 * Date: 5/5/2017
 * Time: 9:56 AM
 *
 * This is the dog class which contains dogId, dogProfileId, dogAge, dogBio, dogBreed, dogCloudinaryId and dogHandle.
 * dogProfileId is a foreign key which connects back to the profileId in the profile class
 */
Class dog implements \JsonSerializable {
	/**
	 * id for dog, this is the primary key
	 * @int $dogId
	 */
	private $dogId;

	/**id for the owner of the dog, this is a foreign key linking back to profileId
	 * @int $dogProfileId
	 */
	private $dogProfileId;

	/**
	 * optional dog age that owner can enter at their own discretion
	 * @tinyint $dogAge
	 */
	private $dogAge;

	/**
	 *optional image for the dog
	 * @varchar $dogCloudinaryId
	 */
	private $dogCloudinaryId;

	/**
	 *optional biography for the dog
	 * @varchar $dogBio
	 */
	private $dogBio;

	/**
	 * optional dog breed for the owner to fill out
	 * @varchar $dogBreed
	 */
	private $dogBreed;

	/**
	 * handle for the dog i.e. a nickname or real name
	 * @varchar $dogAtHandle
	 */
	private $dogAtHandle;

	/**
	 * Constructor for the dog class
	 *
	 * @param int $newDogId id for the dog
	 * @param int $newDogProfileId id for the profile owning the dog (foreign key)
	 * @param int $newDogAge
	 * @param string $newDogCloudinaryId containing an optional photo of the dog
	 * @param string $newDogBio containing an optuonal biography of the dog
	 * @param string $newDogBreed containing an optional description of breed
	 * @param string $newDogAtHandle containing the at handle for the dog
	 * @throws \InvalidArgumentException if data types are not
	 * @throws \RangeException if data values are out of bounds (eg. strings too      long or negative integers.
	 * @throws \Exception if some other exception occurs
	 * @documentation php.net
	 */

	public function __construct(?int $newDogId, int $newDogProfileId, int $newDogAge, string $newDogCloudinaryId, string $newDogBio, string $newDogBreed, string $newDogAtHandle) {
		try {
			$this->setDogId($newDogId);
			$this->setDogProfileId($newDogProfileId);
			$this->setDogAge($newDogAge);
			$this->setDogCloudinaryId($newDogCloudinaryId);
			$this->setDogBio($newDogBio);
			$this->setDogBreed($newDogBreed);
			$this->setDogAtHandle($newDogAtHandle);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for dogId
	 *
	 * @return int value of dogId
	 */
	public function getDogId(): ?int {
		return ($this->dogId);
	}

	/**
	 * Mutator method for dogId
	 *
	 * @param int $newDogId new int for dog Id
	 * @throws \RangeException if $newDogId is not a positive int
	 * @throws \TypeError if $newDogId is not an integer
	 */

	public function setDogId(?int $newDogId): void {
		//If dogId is null, return it.
		if($newDogId === null) {
			$this->dogId = null;
			return;
		}

//verify the dogId is positive
		if($newDogId <= 0) {
			throw(new \RangeException("dog Id is not positive"));
		}
//convert and store dogId
		$this->dogId = $newDogId;
	}

	/**
	 * Accessor method for profile Id of the dog owner
	 * This is a foreign key
	 * @return int value of profileId
	 */
	public function getDogProfileId(): int {
		return ($this->dogProfileId);
	}

	/**
	 * mutator method for profile Id of the dog owner
	 * @param int $newDogProfileId value of the new id of the dog owner
	 * @throws \RangeException if $newDogProfileId is not an int
	 **/
	public function setDogProfileId(int $newDogProfileId): void {
		//verifies profile Id is positive
		if($newDogProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}
		//convert and store profile id
		$this->dogProfileId = $newDogProfileId;
	}

	/**
	 * accessor method for dog age
	 * @return int of dogAge
	 */
	public function getDogAge(): int {
		return ($this->dogAge);
	}

	/**
	 * mutator method for dogAge
	 * @param int $newDogAge value of the new id of the dog owner
	 */

	public function setDogAge(int $newDogAge): void {
		//verifies the dog age is positive
		if($newDogAge <= 0) {
			throw(new \RangeException("dog age is not positive"));
		}
		//convert and store dogAge
		$this->dogAge = $newDogAge;
	}

	/**
	 * accessor method for dog cloudinaryId
	 * @return string value of dog cloudinaryId
	 */
	public function getDogCloudinaryId() {
		return ($this->dogCloudinaryId);
	}

	/**
	 * Mutator method for dog cloudinary Id
	 * @param string $newDogCloudinaryId new value of dog cloudinary Id
	 * @throws \InvalidArgumentException if $newDogCloudinaryId is insecure
	 * @throws \RangeException if $newDogCloudinaryId is < 32 characters
	 * @throws \TypeError if $newDogCloudinaryId isn't a string
	 *
	 */
	public function setDogCloudinaryId(string $newDogCloudinaryId = null) {
//if dog cloudinary id is null, return it
		if($newDogCloudinaryId === null) {
			$this->dogCloudinaryId = null;
		}
//verify the dog cloudinary id is secure
		$newDogCloudinaryId = trim($newDogCloudinaryId);
		$newDogCloudinaryId = filter_var($newDogCloudinaryId . FILTER_SANITIZE_STRING . FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newDogCloudinaryId) === true) {
			throw(new \InvalidArgumentException("dog cloudinary id is empty or insecure"));
		}
		//Verify the dog cloudinary id will fit in the database
		if(strlen($newDogCloudinaryId) > 32) {
			throw(new \RangeException("dog cloudinary id is too large"));
		}
//convert and store the dog cloudinary id
		$this->dogCloudinaryId = $newDogCloudinaryId;
	}

	/**
	 * accessor method for dog bio
	 * @return string value of dogBio
	 */

	public function getDogBio(): string {
		return $this->dogBio;
	}

	/**
	 * mutator method for dog bio
	 * @param string $newDogBio string value of new dog bio
	 * @throws \InvalidArgumentException if $newDogBio is not a string or insecure
	 * @throws \RangeException if $newDogBio is > 255 characters
	 * @throws \TypeError if $newDogBio is not a string
	 *
	 */

	public function setDogBio(string $newDogBio): void {
		//verify th dog bio is secure and a string
		$newDogBio = trim($newDogBio);
		$newDogBio = filter_var($newDogBio, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newDogBio) === true) {
			throw(new \InvalidArgumentException("dog bio is empty or insecure"));
		}
		//verify the dog bio will fit in the database
		if(strlen($newDogBio) > 255) {
			throw(new \RangeException("dog bio is too long"));
		}
		//store dog bio
		$this->dogBio = $newDogBio;
	}

	/**
	 * accessor method for dog breed
	 * @return string value of dogBreed
	 */

	public function getDogBreed(): string {
		return $this->dogBreed;
	}

	/**
	 * mutator method for dog breed
	 * @param string $newDogBreed string value of new dog breed
	 * @throws \InvalidArgumentException if $newDogBreed is not a string or insecure
	 * @throws \RangeException if $newDogBreed is > 50 characters
	 * @throws \TypeError if $newDogBreed is not a string
	 *
	 */

	public function setDogBreed(string $newDogBreed): void {
		//verify the dog breed is secure and a string
		$newDogBreed = trim($newDogBreed);
		$newDogBreed = filter_var($newDogBreed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newDogBreed) === true) {
			throw(new \InvalidArgumentException("dog breed is empty or insecure"));
		}
		//verify the dog breed string will fit in the database
		if(strlen($newDogBreed) > 50) {
			throw(new \RangeException("dog breed description is too long"));
		}
		//store dog breed
		$this->dogBreed = $newDogBreed;
	}

	/**
	 * accessor method for dog at handle
	 * @return string value of dogAtHandle
	 */

	public function getDogAtHandle(): string {
		return $this->dogAtHandle;
	}

	/**
	 * mutator method for dog at handle
	 * @param string $newDogAtHandle string value of new dog at handle
	 * @throws \InvalidArgumentException if $newDogAtHandle is not a string or insecure
	 * @throws \RangeException if $newDogAtHandle is > 32 characters
	 * @throws \TypeError if $newDogAtHandle is not a string
	 *
	 */

	public function setDogAtHandle(string $newDogAtHandle): void {
		//verify the dog breed is secure and a string
		$newDogAtHandle = trim($newDogAtHandle);
		$newDogAtHandle = filter_var($newDogAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newDogAtHandle) === true) {
			throw(new \InvalidArgumentException("dog at handle is empty or insecure"));
		}
		//verify the dog at handle will fit in the database
		if(strlen($newDogAtHandle) > 32) {
			throw(new \RangeException("dog at handle is too long"));
		}
		//store dog at handle
		$this->dogAtHandle = $newDogAtHandle;
	}

	/**
	 * Inserts this dog into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function insert(\PDO $pdo): void {
		//ensure that the dogId is null; don't insert a dog already in the database
		if($this->dogId !== null) {
			throw(new \PDOException("dog Id already exists"));
		}

		//create query template
		$query = "INSERT INTO dog(dogProfileId, dogAge, dogCloudinaryId, dogBio, dogBreed, dogAtHandle) VALUES(:dogProfileId, :dogAge, :dogCloudinaryId, :dogBio, :dogBreed, :dogAtHandle)";
		$statement = $pdo->prepare($query);

		//Bind the member variables to the place holders in the template
		$parameters = ["dogProfileId" => $this->dogProfileId, "dogAge" => $this->dogAge, "dogCloudinaryId" => $this->dogCloudinaryId, "dogBio" => $this->dogBio, "dogBreed" => $this->dogBreed, "dogAtHandle" => $this->dogAtHandle];
		$statement->execute($parameters);
		//update the null dogId with what mySQL just gave us
		$this->dogId = intval($pdo->lastInsertId());
	}

	/**
	 * deletes this dog from MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) : void {

		//ensure the dogId is not null; don't delete a dog id that hasn't been inserted into the database
		if($this->dogId === null) {
			throw(new \PDOException("unable to delete a dog that does not exist"));
		}

		//create query template
		$query = "DELETE FROM dog WHERE dogId = :dogId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the placeholders in the template
		$parameters = ["dogId" => $this->dogId];
		$statement->execute($parameters);
	}

	/**
	 * Updates this dog in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public function update(\PDO $pdo) : void {
		//ensure the dogId is not null
		if($this->dogId === null) {
				throw(new \PDOException("unable to update a dog that does not exist"));
		}
		//create query template
		$query = "UPDATE dog SET dogProfileId = :dogProfileId, dogAge = :dogAge, dogCloudinaryId = :dogCloudinaryId, dogBio = :dogBio, dogBreed = :dogBreed, dogAtHandle = dogAtHandle WHERE dogId = :dogId";
		$statement = $pdo->prepare($query);
	//bind the member variables to the placeholders in the template
		$parameters = ["dogId" => $this->dogId, "dogProfileId" => $this->dogProfileId, "dogAge" => $this->dogAge, "dogCloudinaryId" => $this->dogCloudinaryId, "dogBio" => $this->dogBio, "dogBreed" => $this->dogBreed, "dogAtHandle" => $this->dogAtHandle];
		$statement->execute($parameters);

	}
	/**
	 * get dog by dogId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $dogId profile id to search by
	 * @return \SplFixedArray SplFixedArray of dogs found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getDogByDogId(\PDO $pdo, int $dogId) : \SplFixedArray {
		// sanitize the profile Id before searching
		if($dogId <= 0) {
			throw(new \RangeException("dog Id must be positive"));
		}
		//create query template
		$query ="SELECT dogId, dogProfileId, dogAge, dogCloudinaryId, dogBio, dogBreed, dogAtHandle FROM dog WHERE dogId = :dogId";
		$statement = $pdo->prepare($query);
		//bind the dogId to the place holder in template
		$parameters = ["dogId" => $dogId];
		$statement->execute($parameters);
		//build an array of dogs
		$dogs = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$dog = new dog($row{"dogId"}, $row["dogProfileId"], $row["dogAge"], $row["dogCloudinaryId"], $row["dogBio"], $row["dogBreed"], $row["dogAtHandle"]);
				$dogs[$dogs->key()] = $dog;
				$dogs->next();
			} catch(\Exception $exception) {
				// if the row can't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($dogs);


	}

	/**
	 * get dog by profile id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param int $dogProfileId profile id to search by
	 * @return \SplFixedArray SplFixedArray of dogs found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getDogByDogProfileId(\PDO $pdo, int $dogProfileId) : \SplFixedArray {
		// sanitize the profile Id before searching
		if($dogProfileId <= 0) {
			throw(new \RangeException("dog profile Id must be positive"));
		}
		//create query template
		$query ="SELECT dogId, dogProfileId, dogAge, dogCloudinaryId, dogBio, dogBreed, dogAtHandle FROM dog WHERE dogProfileId = :dogProfileId";
		$statement = $pdo->prepare($query);
		//bind the dog profile id to the place holder in template
		$parameters = ["dogProfileId" => $dogProfileId];
		$statement->execute($parameters);
		//build an array of dogs
		$dogs = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
				try {
					$dog = new dog($row{"dogId"}, $row["dogProfileId"], $row["dogAge"], $row["dogCloudinaryId"], $row["dogBio"], $row["dogBreed"], $row["dogAtHandle"]);
					$dogs[$dogs->key()] = $dog;
					$dogs->next();
				} catch(\Exception $exception) {
					// if the row can't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
		}
		return($dogs);


	}

	/**
	 * get dog by dog breed
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $dogBreed dog breed to search for
	 * @return \SPLFixedArray of all dogs found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not correct data type
	 */
	public static function getDogByDogBreed(\PDO $pdo, string $dogBreed) : \SplFixedArray {
		// sanitize the dog breed string before searching
		$dogBreed = trim($dogBreed);
		$dogBreed = filter_var($dogBreed, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($dogBreed) === true) {
			throw(new \PDOException("not valid dog breed entry"));
		}
		//create query template
		$query = "SELECT dogId, dogProfileId, dogAge, dogCloudinaryId, dogBio, dogBreed, dogAtHandle FROM dog WHERE dogBreed = :dogBreed";
		$statement = $pdo->prepare($query);
		//bind the dog breed to the place holder in template
		$parameters = ["dogBreed" => $dogBreed];
		$statement->execute($parameters);
		//build an array of dogs
		$dogs = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$dog = new dog($row{"dogId"}, $row["dogProfileId"], $row["dogAge"], $row["dogCloudinaryId"], $row["dogBio"], $row["dogBreed"], $row["dogAtHandle"]);
				$dogs[$dogs->key()] = $dog;
				$dogs->next();
			} catch(\Exception $exception) {
				// if the row can't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($dogs);
	}




	public function jsonSerialize() {
		return (get_object_vars($this));
	}
}
