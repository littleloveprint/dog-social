<?php

namespace Edu\Cnm\BarkParkz;

/**
 * Created by PhpStorm.
 * User: GV8484
 * Date: 5/5/2017
 * Time: 9:56 AM
 *
 * This is the dog class which contains dogId, dogProfileId, dogAge, dogBio, dogBreed and dogHandle.
 * dogProfileId is a foreign key which connects back to the profileId in the profile class
 */
class dog implements \JsonSerializable {
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




	public function jsonSerialize() {
		return (get_object_vars($this));

	}
}
