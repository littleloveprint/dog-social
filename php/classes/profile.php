<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * Bark Parkz Profile.
 *
 * @author Lea McDuffie <lea@littleloveprint.io>
 * @version 1
 **/
class Profile implements \JsonSerializable {
	use ValidateDate;
	/**
	 * id for this Profile; this is the primary key.
	 * @var int $profileId
	 **/
	private $profileId;
	/**
	 * token to verify the profile is valid.
	 * @var string $profileActivationToken
	 **/
	private $profileActivationToken;
	/**
	 * at handle for this Profile; this is a unique index.
	 * @var string $profileAtHandle
	 **/
	private $profileAtHandle;
	/**
	 * image for profile
	 * @var string $profileCloudinaryId
	 **/
	private $profileCloudinaryId;
	/**
	 * email for this Profile; this is a unique index.
	 * @var string $profileEmail
	 **/
	private $profileEmail;
	/**
	 * jumbles users' passwords.
	 * @var string $profileHash
	 **/
	private $profileHash;
	/**
	 * location x of this Profile.
	 * @var string $profileLocationX
	 **/
	private $profileLocationX;
	/**
	 * location y of this Profile.
	 * @var string $profileLocationY
	 **/
	private $profileLocationY;
	/**
	 * adds extra security to users' passwords.
	 * @var string $profileSalt
	 **/
	private $profileSalt;
	/**
	 * Constructor for this Profile.
	 *
	 * @param int $newProfileId id of the Profile
	 * @param string $newProfileActivationToken activation token
	 * @param string $newProfileAtHandle string containing newAtHandle
	 * @param string $newProfileCloudinaryId user profile image
	 * @param string $newProfileEmail user email address
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfileLocationX string containing user's declared location
	 * @param string $newProfileLocationY string containing user's declared location
	 * @param string $newProfileSalt string containing profile salt.
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileCloudinaryId, string $newProfileEmail, string $newProfileHash, string $newProfileLocationX, string $newProfileLocationY, string $newProfileSalt) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileCloudinaryId($newProfileCloudinaryId);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileLocationX($newProfileLocationX);
			$this->setProfileLocationY($newProfileLocationY);
			$this->setProfileSalt($newProfileSalt);
		}
			// determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * Accessor method for profile id.
	 *
	 * @return int value of profile id
	 **/
	public function getProfileId(): ?int {
		return ($this->profileId);
	}
	/**
	 * Mutator method for profile id.
	 *
	 * @param int $newProfileId new value of profile id
	 * @throws \RangeException if $newProfileId is not positive
	 * @throws \TypeError if $newProfileId is not an integer
	 **/
	public function setProfileId(?int $newProfileId): void {

		// If profile id is null, immediately return it.
		if($newProfileId === null) {
			$this->profileId = null;
			return;
		}

		// Verify the profile id is positive.
		if($newProfileId <= 0) {
			throw(new \RangeException("profile id is not positive"));
		}

		// Convert and store the profile id.
		$this->profileId = $newProfileId;
	}

	/**
	 * Accessor method for account activation token.
	 *
	 * @return string value of the activation token
	 **/
	public function getProfileActivationToken(): ?string {
		return $this->profileActivationToken;
	}

	/**
	 * Mutator method for profile activation token.
	 *
	 * @param string $newProfileActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 **/
	public function setProfileActivationToken(?string $newProfileActivationToken) : void {
		if($newProfileActivationToken === null) {
		$this->profileActivationToken = null;
		return;
	}
	$newProfileActivationToken = strtolower(trim($newProfileActivationToken));
	if(ctype_xdigit($newProfileActivationToken) === false) {
	throw(new\RangeException("user activation is not valid"));
	}
	$this->getProfileActivationToken = $newProfileActivationToken;
	}
}