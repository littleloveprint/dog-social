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
	 * image data for profile
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
	 * adds extra security to users' passwords.
	 * @var string $profileSalt
	 **/
	private $profileSalt;
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
	 * Constructor for this Profile.
	 *
	 * @param int $newProfileId id of the Profile
	 * @param string $newProfileActivationToken activation token
	 * @param string $newProfileAtHandle string containing new profile at handle
	 * @param string $newProfileCloudinaryId string containing user profile image data
	 * @param string $newProfileEmail user email address
	 * @param string $newProfileHash string containing password hash
	 * @param string $newProfileSalt string containing profile salt
	 * @param string $newProfileLocationX string containing user's declared location
	 * @param string $newProfileLocationY string containing user's declared location
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct(?int $newProfileId, string $newProfileActivationToken, string $newProfileAtHandle, string $newProfileCloudinaryId, string $newProfileEmail, string $newProfileHash, string $newProfileSalt, string $newProfileLocationX, string $newProfileLocationY) {
		try {
			$this->setProfileId($newProfileId);
			$this->setProfileActivationToken($newProfileActivationToken);
			$this->setProfileAtHandle($newProfileAtHandle);
			$this->setProfileCloudinaryId($newProfileCloudinaryId);
			$this->setProfileEmail($newProfileEmail);
			$this->setProfileHash($newProfileHash);
			$this->setProfileSalt($newProfileSalt);
			$this->setProfileLocationX($newProfileLocationX);
			$this->setProfileLocationY($newProfileLocationY);
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

	/**
	 * Accessor method for at handle.
	 *
	 * @return string value of at handle
	 **/
	public function getProfileAtHandle(): string {
		return ($this->profileAtHandle);
	}

	/**
	 * Mutator method for profile at handle.
	 *
	 * @param string $newProfileAtHandle new value of at handle
	 * @throws \InvalidArgumentException if $newAtHandle is not a string or insecure
	 * @throws \RangeException if $newAtHandle is > 32 characters
	 * @throws \TypeError if the $newAtHandle is not a string
	 **/
	public function setProfileAtHandle(string $newProfileAtHandle) : void {

		// Verify the at handle is secure
		$newProfileAtHandle = trim($newProfileAtHandle);
		$newProfileAtHandle = filter_var($newProfileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileAtHandle) === true) {
			throw(new \InvalidArgumentException("profile at handle is empty or insecure"));
		}

		// Verify the at handle will fit in the database
		if(strlen($newProfileAtHandle) > 32) {
			throw(new \RangeException("profile at handle is too large"));
		}

		// Store the at handle.
		$this->profileAtHandle = $newProfileAtHandle;
	}

	/**
	 * Accessor method for profile cloudinary id.
	 *
	 * @return string value of profile cloudinary id
	 **/
	public function getProfileCloudinaryId() {
		return ($this->profileCloudinaryId);
	}
	/**
	 * Mutator method for profile cloudinary id.
	 *
	 * @param string $newProfileCloudinaryId new value of profile cloudinary id
	 * @throws \InvalidArgumentException if $newProfileCloudinaryId is insecure
	 * @throws \RangeException if $newCloudinaryId is > 32 characters
	 * @throws \TypeError if $newCloudinaryId is not a string
	 **/
	public function setProfileCloudinaryId(string $newProfileCloudinaryId = null) {

		// If profile cloudinary id is null, immediately return it.
		if($newProfileCloudinaryId === null) {
			$this->profileCloudinaryId = null;
		}

		// Verify the profile cloudinary id is secure.
		$newProfileCloudinaryId = trim($newProfileCloudinaryId);
		$newProfileCloudinaryId = filter_var($newProfileCloudinaryId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileCloudinaryId) === true) {
			throw(new \InvalidArgumentException("profile cloudinary id is empty or insecure"));
		}

		// Verify the profile cloudinary id will fit in the database.
		if(strlen($newProfileCloudinaryId) > 32) {
			throw(new \RangeException("profile cloudinary id is too large"));
		}

		// Convert and store the profile cloudinary id.
		$this->profileCloudinaryId = $newProfileCloudinaryId;
	}

	/**
	 * Accessor method for email.
	 *
	 * @return string value of email
	 **/
	/**
	 * @return string
	 */
	public function getProfileEmail(): string {
		return $this->profileEmail;
	}

	/**
	 * Mutator method for email
	 *
	 * @param string $newProfileEmail new value of email
	 * @throws \InvalidArgumentException if $newEmail is not a valid email or insecure
	 * @throws \RangeException if $newEmail is > 128 characters
	 * @throws \TypeError if $newEmail is not a string
	 **/
	public function setProfileEmail(string $newProfileEmail) : void {

		// Verify the email is secure
		$newProfileEmail = trim($newProfileEmail);
		$newProfileEmail = filter_var($newProfileEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newProfileEmail) === true) {
			throw(new \InvalidArgumentException("profile email is empty or insecure"));
		}

		// Verify the email will fit in the database.
		if(strlen($newProfileEmail) > 128) {
			throw(new \RangeException("profile email is too large"));
		}

		// Store the email.
		$this->profileEmail = $newProfileEmail;
	}
	/**
	 * Accessor method for profile hash
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

		// Enforce that the hash is properly formatted.
		$newProfileHash = trim($newProfileHash);
		$newProfileHash = strtolower($newProfileHash);
		if(empty($newProfileHash) === true) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		// Enforce that the hash is a string representation of a hexadecimal.
		if(!ctype_xdigit($newProfileHash)) {
			throw(new \InvalidArgumentException("profile password hash is empty or insecure"));
		}

		// Enforce that the hash is exactly 128 characters.
		if(strlen($newProfileHash) !== 128) {
			throw(new \RangeException("profile hash must be 128 characters"));
		}

		// Store the hash.
		$this->profileHash = $newProfileHash;
	}

	/**
	 * Accessor method for profile salt.
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

		// Enforce that the salt is properly formatted.
		$newProfileSalt = trim($newProfileSalt);
		$newProfileSalt = strtolower($newProfileSalt);

		// Enforce that the salt is a string representation of a hexadecimal.
		if(!ctype_xdigit($newProfileSalt)) {
			throw(new \InvalidArgumentException("profile password salt is empty or insecure"));
		}

		// Enforce that the salt is exactly 128 characters.
		if(strlen($newProfileSalt) !== 128) {
			throw(new \RangeException("profile salt must be 128 characters"));
		}

		// Store the salt.
		$this->profileSalt = $newProfileSalt;
	}

	/**
	 * Accessor method for profile location x.
	 *
	 * @return string value of profile location x
	 **/
	public function getProfileLocationX() {
		return($this->profileLocationX);
	}

	/**
	 * Mutator method for profile location x.
	 *
	 * @param string @newProfileLocationX new value of profile location x
	 * @throws \InvalidArgumentException if $newProfileLocationX is insecure
	 * @throws \RangeException if $newProfileLocationX is > 32 characters
	 * @throws \TypeError if $newProfileLocationX is not a string
	 **/
	public function setProfileLocationX(string $newProfileLocationX) {

		// Verify that profile location x is secure.
		$newProfileLocationX = trim($newProfileLocationX);
		$newProfileLocationX = filter_var($newProfileLocationX, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLocationX) === true) {
			throw( new \InvalidArgumentException( "profile location x is empty or malicious" ));
		}

		// Verify that profile location x will fit in the database.
		if(strlen($newProfileLocationX) > 32) {
			throw(new \RangeException("location x is too large"));
		}

		// Store profile location x if all else passes.
		$this->profileLocationX = $newProfileLocationX;
	}
	/**
	 * Accessor method for profile location y.
	 *
	 * @return string value of profile location y
	 **/
	public function getProfileLocationY() {
		return($this->profileLocationY);
	}

	/**
	 * Mutator method for profile location y.
	 *
	 * @param string @newProfileLocationY new value of profile location y
	 * @throws \InvalidArgumentException if $newProfileLocationY is insecure
	 * @throws \RangeException if $newProfileLocationY is > 32 characters
	 * @throws \TypeError if $newProfileLocationY is not a string
	 **/
	public function setProfileLocationY(string $newProfileLocationY) {

		// Verify that profile location y is secure.
		$newProfileLocationY = trim($newProfileLocationY);
		$newProfileLocationY = filter_var($newProfileLocationY, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newProfileLocationY) === true) {
			throw( new \InvalidArgumentException( "profile location y is empty or malicious" ));
		}

		// Verify that profile location y will fit in the database.
		if(strlen($newProfileLocationY) > 32) {
			throw(new \RangeException("location y is too large"));
		}

		// Store profile location y if all else passes.
		$this->profileLocationY = $newProfileLocationY;
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

		// Create query template.
		$query = "INSERT INTO profile(profileActivationToken, profileAtHandle, profileCloudinaryId, profileEmail, profileHash, profileSalt, profileLocationX, profileLocationY) VALUES(:profileActivationToken, :profileAtHandle, :profileCloudinaryId, :profileEmail, :profileHash, :profileSalt, :profileLocationX, :profileLocationY)";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template.
		$parameters = ["profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileCloudinaryId" => $this->profileCloudinaryId, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt, "profileLocationX" => $this->profileLocationX, "profileLocationY" => $this->profileLocationY];
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
		$query = "UPDATE profile SET profileActivationToken = :profileActivationToken, profileAtHandle = :profileAtHandle, profileCloudinaryId = :profileCloudinaryId, profileEmail = :profileEmail, profileHash = :profileHash, profileSalt = :profileSalt, profileLocationX = :profileLocationX, profileLocationY = :profileLocationY WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// Bind the member variables to the place holders in the template.
		$parameters = ["profileId" => $this->profileId, "profileActivationToken" => $this->profileActivationToken, "profileAtHandle" => $this->profileAtHandle, "profileCloudinaryId" => $this->profileCloudinaryId, "profileEmail" => $this->profileEmail, "profileHash" => $this->profileHash, "profileSalt" => $this->profileSalt, "profileLocationX" => $this->profileLocationX, "profileLocationY" => $this->profileLocationY
		];
		$statement->execute($parameters);
	}
	/**
	 * Gets the Profile by profile id
	 *
	 * @param \PDO $pdo $pdo PDO connection object
	 * @param int $profileId profile id to search for
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileId(\PDO $pdo, int $profileId):?Profile {

		// Sanitize the profile id before searching
		if($profileId <= 0) {
			throw(new \PDOException("profile id is not postive"));
		}

		// Create query template
		$query = "SELECT profileId, profileActivationToken, profileAtHandle, profileCloudinaryId, profileEmail, profileHash, profileSalt, profileLocationX, profileLocationY FROM profile WHERE profileId = :profileId";
		$statement = $pdo->prepare($query);

		// Bind the profile id to the place holder in the template
		$parameters = ["profileId" => $profileId];
		$statement->execute($parameters);

		// Grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileCloudinaryId"], $row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profileLocationX"], $row["profileLocationY"]);
			}
		} catch(\Exception $exception) {

			// If the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}
	/**
	 * Get the profile by profile activation token
	 *
	 * @param string $profileActivationToken
	 * @param \PDO object $pdo
	 * @return Profile|null Profile or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileActivationToken(\PDO $pdo, string $profileActivationToken) : ?Profile {

		// Make sure activation token is in the right format and that it is a string representation of a hexadecimal
		$profileActivationToken = trim($profileActivationToken);
		if(ctype_xdigit($profileActivationToken) === false) {
			throw(new \InvalidArgumentException("profile activation token is empty or in the wrong format"));
		}

		// Create the query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileCloudinaryId, profileEmail, profileHash, profileSalt, profileLocationX, profileLocationY FROM profile WHERE profileActivationToken = :profileActivationToken";
		$statement = $pdo->prepare($query);

		// Bind the profile activation token to the placeholder in the template
		$parameters = ["profileActivationToken" => $profileActivationToken];
		$statement->execute($parameters);

		// Grab the Profile from mySQL
		try {
			$profile = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileCloudinaryId"], $row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profileLocationX"], $row["profileLocationY"]);
			}
		} catch(\Exception $exception) {

			// If the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($profile);
	}

	/**
	 * Gets the Profile by at handle
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $profileAtHandle at handle to search for
	 * @return \SPLFixedArray of all profiles found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getProfileByProfileAtHandle(\PDO $pdo, string $profileAtHandle) : \SPLFixedArray {

		// Sanitize the at handle before searching
		$profileAtHandle = trim($profileAtHandle);
		$profileAtHandle = filter_var($profileAtHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($profileAtHandle) === true) {
			throw(new \PDOException("not a valid at handle"));
		}

		// Create query template
		$query = "SELECT  profileId, profileActivationToken, profileAtHandle, profileCloudinaryId, profileEmail, profileHash, profileSalt, profileLocationX, profileLocationY FROM profile WHERE profileAtHandle = :profileAtHandle";
		$statement = $pdo->prepare($query);

		// Bind the profile at handle to the place holder in the template
		$parameters = ["profileAtHandle" => $profileAtHandle];
		$statement->execute($parameters);

		$profiles = new \SPLFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);

		while (($row = $statement->fetch()) !== false) {
			try {
				$profile = new Profile($row["profileId"], $row["profileActivationToken"], $row["profileAtHandle"], $row["profileCloudinaryId"], $row["profileEmail"], $row["profileHash"], $row["profileSalt"], $row["profileLocationX"], $row["profileLocationY"]);
				$profiles[$profiles->key()] = $profile;
				$profiles->next();
			} catch(\Exception $exception) {

				// If the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($profiles);
	}

	/**
	 * Formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		return (get_object_vars($this));

	}
}