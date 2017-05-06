<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * Bark Parkz Friend.
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
		try {
			$this->setFriendFirstProfileId($newFriendFirstProfileId);
			$this->setFriendSecondProfileId($newFriendSecondProfileId);
		}

			// Determine what exception type was thrown
		catch(\RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Accessor method for friend first profile id.
	 *
	 * @return int value of friend first profile id
	 **/
	public function getFriendFirstProfileId(): ?int {
		return ($this->friendFirstProfileId);
	}
	/**
	 * Mutator method for friend first profile id.
	 *
	 * @param int $newFriendFirstProfileId new value of friend first profile id
	 * @throws \RangeException if $newFriendFirstProfileId is not positive
	 * @throws \TypeError if $newFriendFirstProfileId is not an integer
	 **/
	public function setFriendFirstProfileId(?int $newFriendFirstProfileId): void {

		// If friend first profile id is null, immediately return it.
		if($newFriendFirstProfileId === null) {
			$this->friendFirstProfileId = null;
			return;
		}

		// Verify the friend first profile id is positive.
		if($newFriendFirstProfileId <= 0) {
			throw(new \RangeException("friend first profile id is not positive"));
		}

		// Convert and store the profile id.
		$this->friendFirstProfileId = $newFriendFirstProfileId;
	}
	/**
	 * Accessor method for friend second profile id.
	 *
	 * @return int value of friend second profile id
	 **/
	public function getFriendSecondProfileId(): ?int {
		return ($this->friendSecondProfileId);
	}
	/**
	 * Mutator method for friend second profile id.
	 *
	 * @param int $newFriendSecondProfileId new value of friend second profile id
	 * @throws \RangeException if $newFriendSecondProfileId is not positive
	 * @throws \TypeError if $newFriendSecondProfileId is not an integer
	 **/
	public function setFriendSecondProfileId(?int $newFriendSecondProfileId): void {

		// If friend second profile id is null, immediately return it.
		if($newFriendSecondProfileId === null) {
			$this->friendSecondProfileId = null;
			return;
		}

		// Verify the friend second profile id is positive.
		if($newFriendSecondProfileId <= 0) {
			throw(new \RangeException("friend second profile id is not positive"));
		}

		// Convert and store the profile id.
		$this->friendSecondProfileId = $newFriendSecondProfileId;
	}

}