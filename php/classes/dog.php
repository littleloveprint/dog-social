<?php

namespace Edu\Cnm\BarkParkz;

/**
 * Created by PhpStorm.
 * User: GV8484
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
	 * @param tinyint $newDogAge
	 * @param string $newDogCloudinaryId containing an optional photo of the dog
	 * @param string $newDogBio containing an optuonal biography of the dog
	 * @param string $newDogBreed containing an optional description of breed
	 * @param string $newDogAtHandle containing the at handle for the dog
	 * @throws \InvalidArgumentException if data types are not
	 * @throws \RangeException if data values are out of bounds (eg. strings too      long or negative integers.
	 * @throws \Exception if some other exception occurs
	 * @documentation php.net
	 */

	public function __construct(?int $newDogId, int $newDogProfileId, tinyint $newDogAge, string $newDogCloudinaryId, string $newDogBio, string $newDogBreed, string $newDogAtHandle) {
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
	 * @param int $newProfileId value of the new id of the dog owner
	 * @throws \RangeException if $newProfileId is not an int
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
	public function getDogAge(): tinyint {
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
	 * @throws \RangeException if $newDogCloudinaryId is > 32 characters
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


	public function jsonSerialize() {
		return (get_object_vars($this));
	}
}
