<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * this is the check-in page for barkparkz HMB
 **/
class CheckIn implements \JsonSerializable {
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