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
 * @throws \TypeError if $newParkLocationX
 */