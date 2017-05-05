<?php
namespace Edu\Cnm\BarkParkz;
require_once("autoload.php");
/**
 * Bark Parkz Profile.
 *
 * @author Lea McDuffie <littleloveprint@gmail.com>
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
		//If profile id is null immediately return it.
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
	 * Accessor method for profile username.
	 *
	 * @return string value of profile username
	 **/
	public function getProfileUserName(): string {
		return ($this->profileUserName);
	}
	/**
	 * Mutator method for profile username.
	 *
	 * @param string $newProfileUserName new value of profile username
	 * @throws \RangeException if $newProfileUserName > 32 characters
	 * @throws \TypeError if $newProfileUserName is an integer
	 **/
	public function setProfileUserName(string $newProfileUserName): void {
		// Verify the profile username is secure.
		$newProfileUserName = trim($newProfileUserName);
		$newProfileUserName = filter_var($newProfileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileUserName) === true) {
			throw(new \InvalidArgumentException("profile username is empty or insecure"));
		}
		// Verify the profile username will fit in the database.
		if(strlen($newProfileUserName) < 32) {
			throw(new \RangeException("profile username too large"));
		}
		// Store the profile username.
		$this->profileUserName = $newProfileUserName;
	}
	/**
	 * Accessor method for profile location.
	 *
	 * @return string value of profile location
	 **/
	public function getProfileLocation(): string {
		return ($this->profileLocation);
	}
	/**
	 * Mutator method for profile location.
	 *
	 * @param string $newProfileLocation new value of profile location.
	 * @throws \InvalidArgumentException if $newProfileLocation is not a string or insecure
	 * @throws \RangeException if $newProfileLocation is > 32 characters
	 * @throws \TypeError if $newProfileLocation is not a string
	 **/
	public function setProfileLocation(string $newProfileLocation): void {
		// Verify the profile location is secure.
		$newProfileLocation = trim($newProfileLocation);
		$newProfileLocation = filter_var($newProfileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLocation) === true) {
			throw(new \InvalidArgumentException("profile location is empty or insecure"));
		}
		// Verify the profile location will fit in the database.
		if(strlen($newProfileLocation) > 64) {
			throw(new \RangeException("profile location too large"));
		}
		// Store the profile location.
		$this->profileLocation = $newProfileLocation;
	}
	/**
	 * Accessor method for profile join date
	 *
	 * @return \DateTime value of profile join date
	 **/
	public function getProfileJoinDate(): \DateTime {
		return ($this->profileJoinDate);
	}
	/**
	 * Mutator method for profile join date.
	 *
	 * @param \DateTime|string|null $newProfileJoinDate profile join date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newProfileJoinDate is not a valid object or string
	 * @throws \RangeException if $newProfileJoinDate is a date that does not exist
	 **/
	public function setProfileJoinDate($newProfileJoinDate = null): void {
		// Base case: if the date is null, use the current date and time
		if($newProfileJoinDate === null) {
			$this->profileJoinDate = new \DateTime();
			return;
		}
		// Store the profile join date using the ValidateDate trait.
		try {
			$newProfileJoinDate = self::validateDateTime($newProfileJoinDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->profileJoinDate = $newProfileJoinDate;
	}
	/**
	 * Accessor method for profileHash
	 *
	 * @return string value of hash
	 */
	public function getProfileHash(): string {
		return $this->profileHash;
	}
	/**
	 * Mutator method for profile hash
	 *
	 * @param string $newProfileHash
	 * @throws \InvalidArgumentException if the hash is not secure
	 * @throws \RangeException if the hash is not 128 characters
	 * @throws \TypeError if profile hash is not a string
	 */
	public function setProfileHash(string $newProfileHash): void {
		// Enforce that the hash is properly formatted
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash empty or insecure"));
		}
		// Enforce that the hash is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		// Enforce that the hash is exactly 128 characters
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}
		// Store the hash
		$this->profileHash = $newProfileHash;
	}
	/**
	 *accessor method for profile salt
	 *
	 * @return string representation of the salt hexadecimal
	 */
	public function getProfileSalt(): string {
		return $this->profileSalt;
	}
	/**
	 * Mutator method for profile salt
	 *
	 * @param string $newProfileSalt
	 * @throws \InvalidArgumentException if the salt is not secure
	 * @throws \RangeException if the salt is not 64 characters
	 * @throws \TypeError if profile salt is not a string
	 */
	public function setProfileSalt(string $newProfileSalt): void {
		// Enforce that the salt is properly formatted
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);
		// Enforce that the salt is a string representation of a hexadecimal
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}
		// Enforce that the salt is exactly 64 characters
		if(strlen($newProfileSalt) !== 64) {
			throw(new \RangeException("profile salt must be 64 characters"));
		}
		// Store the salt
		$this->profileSalt = $newProfileSalt;
	}
	/**
	 * Inserts this profile into mySQL.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError is $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// Enforce the profileId is null (i.e., don't insert a profile that already exists).
		if($this->profileId !== null) {
			throw(new \PDOException("profile id already exists"));
		}
		// Create query template
		$query = "INSERT INTO profile(profileUserName, profileLocation, profileJoinDate, profileHash, profileSalt) VALUES(:profileUserName, :profileLocation, :profileJoinDate, :profileHash, :profileSalt)";
		$statement = $pdo->prepare($query);
		// Bind the member variables to the place holders in the template.
		$formattedDate = $this->profileJoinDate->format("Y-m-d H:i:s.u");
		$parameters = ["profileUserName" => $this->profileUserName, "profileLocation" => $this->profileLocation, "profileJoinDate" => $formattedDate, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt];
		$statement->execute($parameters);
		// Update the null profileId with what mySQL just gave us.
		$this->profileId = intval($pdo->lastInsertId());
	}
	/**
	 * Deletes this profile from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		// Enforce the profileId is not null (i.e. don't delete a profile that hasn't been inserted).
		if($this->profileId === null) {
			throw(new \PDOException("unable to delete a profile that doesn't exist"));
		}
		// Create query template.
		$query = "DELETE FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// Bind the member variables to the place holder in the template.
		$parameters = ["profileId" => $this->profileId];
		$statement->execute($parameters);
	}
	/**
	 * Updates this profile in mySQL.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		// Enforce the profileId is not null (i.e. don't update a profile that hasn't been inserted).
		if($this->profileId === null) {
			throw(new \PDOException("unable to update a profile that does not exist"));
		}
		// Create query template.
		$query = "UPDATE profile SET profileUserName = :profileUserName, profileLocation = :profileLocation, profileJoinDate = :profileJoinDate, profileHash = :profileHash, profileSalt = :profileSalt WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);
		// Bind the member variables to the place holders in the template.
		$formattedDate = $this->profileJoinDate->format("Y-m-d H:i:s.u");
		$parameters = ["profileId" => $this->profileId, "profileUserName" => $this->profileUserName, "profileLocation" => $this->profileLocation, "profileJoinDate" => $this->profileJoinDate, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt
		];
		$statement->execute($parameters);
	}
	/**
	 * Gets the profile by username.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileUserName profile username to search for
	 * @return \SplFixedArray SplFixedArray of profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileUserName(\PDO $pdo, string $profileUserName) {
		// Sanitize the username before searching
		$profileUserName = trim($profileUserName);
		$profileUserName = filter_var($profileUserName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileUserName) === true) {
			throw(new \PDOException("profile username invalid"));
		}
		// Create query template.
		$query = "SELECT profileId, profileUserName, profileLocation, profileJoinDate, profileHash, profileSalt FROM profile WHERE profileUserName = :profileUserName";
		$statement = $pdo->prepare($query);
		// Bind the profile username to the place holder in the template.
		$profileUserName = "%profileUserName%";
		$parameters = ["profileUserName" => $profileUserName];
		$statement->execute($parameters);
		// Build an array of profiles.
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileUserName"], $row["profileLocation"], $row["profileJoinDate"], $row["profileHash"], $row["profileSalt"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// If the row couldn't be converted, rethrow it.
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * Gets the profile by location.
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileLocation profile location to search for
	 * @return \SplFixedArray SplFixedArray of profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileLocation(\PDO $pdo, string $profileLocation) {
		// Sanatize the location before searching
		$profileLocation = trim($profileLocation);
		$profileLocation = filter_var($profileLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileLocation) === true) {
			throw(new \PDOException("profile location invalid"));
		}
		// Create query template.
		$query = "SELECT profileId, profileUserName, profileLocation, profileJoinDate, profileHash, profileSalt FROM profile WHERE profileLocation LIKE :profileLocation";
		$statement = $pdo->prepare($query);
		// Bind the profile location to the place holder in the template.
		$profileLocation = "%profileLocation%";
		$parameters = ["profileLocation" => $profileLocation];
		$statement->execute($parameters);
		// Build an array of profiles.
		$profiles = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileUserName"], $row["profileLocation"], $row["profileJoinDate"], $row["profileHash"], $row["profileSalt"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {
				// If the row couldn't be converted, rethrow it.
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($profiles);
	}
	/**
	 * Formats the state variables for JSON serialization.
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		//Format the date so that the front end can consume it.
		$fields["profileJoinDate"] = round(floatval($this->profileJoinDate->format("U.u")) * 1000);
		return($fields);
	}
}
