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
	 * @throws \RangeException if data values are out of bounds (eg. strings too 		long or negative integers.
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
		}
		//determine what exception type was thrown
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

//verify the dogProfileId is positive
if($newDogId <= 0) {
	throw(new \RangeException("dog Id is not positive"));
}
//convert and store dogId
$this->dogId = $newDogId;
}

public function jsonSerialize() {
		return (get_object_vars($this));
}}

