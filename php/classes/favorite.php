<?php
namespace Edu\CNM\BarkParkz
require_once ("autoload.php");
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