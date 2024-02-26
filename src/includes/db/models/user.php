<?php
require_once __DIR__ . "/../init.php";

class User
{
	public int $id;
	public string $email;
	public string $password;
	public string $first_name;
	public string $last_name;
	public string|null $middle_initial = null;
	public string|null $suffix = null;
	public DateTime $created_at;
	public DateTime $updated_at;

	static private ?User $currentUser = null;

	public function __construct(
		int $id,
		string $email,
		string $password,
		string $first_name,
		string $last_name,
		string|DateTime $created_at,
		string|DateTime $updated_at,
		string|null $middle_initial = null,
		string|null $suffix = null,
	) {
		$this->id = $id;
		$this->email = $email;
		$this->password = $password;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->middle_initial = $middle_initial;
		$this->suffix = $suffix;

		if (gettype($created_at) == "string")
			$this->created_at = new DateTime($created_at);
		else $this->created_at = $created_at;

		if (gettype($updated_at) == "string")
			$this->updated_at = new DateTime($updated_at);
		else $this->updated_at = $updated_at;
	}

	static private function assocToUser($entry)
	{
		return new User(
			$entry["id"],
			$entry["email"],
			$entry["password"],
			$entry["first_name"],
			$entry["last_name"],
			$entry["created_at"],
			$entry["updated_at"],
			$entry["middle_initial"],
			$entry["suffix"],
		);
	}

	static public function getUser(int $id): ?User
	{
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
		$stmt->bindParam(1, $id);
		$stmt->execute();

		$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($user_data == null) return null;

		return static::assocToUser($user_data);
	}

	static public function authenticateUser(string $email, string $password): ?User
	{
		global $conn;
		$email = trim($email);
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
		$stmt->bindParam(1, $email);
		$stmt->execute();

		$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($user_data == null) return null;
		else if (!password_verify(trim($password), $user_data["password"])) return null;

		static::$currentUser = static::assocToUser($user_data);

		return static::$currentUser;
	}

	static public function getAuthenticatedUser(): ?User
	{
		if (static::$currentUser) return static::$currentUser;
		else if (!isset($_SESSION["user_id"])) return null;

		static::$currentUser = static::getUser($_SESSION["user_id"]);
		return static::$currentUser;
	}
}
