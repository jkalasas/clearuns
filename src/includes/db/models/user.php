<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/role.php";

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

	static public function create(
		string $email,
		string $password,
		string $first_name,
		string $last_name,
		string $middle_initial = null,
		string $suffix = null
	): User {
		global $conn;

		$middle_initial = $middle_initial == "" ? null : $middle_initial;
		$suffix = $suffix == "" ? null : $suffix;

		$stmt = $conn->prepare(<<<EOT
			INSERT INTO users (email, password, first_name, last_name, middle_initial, suffix)
			VALUES (:email, :password, :first_name, :last_name, :middle_initial, :suffix);
		EOT);
		$stmt->bindParam("email", $email);
		$stmt->bindParam("password", $password);
		$stmt->bindParam("first_name", $first_name);
		$stmt->bindParam("last_name", $last_name);
		$stmt->bindParam("middle_initial", $middle_initial);
		$stmt->bindParam("suffix", $suffix);
		$stmt->execute();

		$user_id = $conn->lastInsertId();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
		$stmt->execute([$user_id]);

		$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

		return static::assocToUser($user_data);
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

	static public function getUserByEmail(string $email): ?User
	{
		global $conn;
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
		$stmt->execute([$email]);

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

	/**
	 * Fetch users that has the required roles
	 * @var RoleType[] $roles Required roles
	 * @return User[] list of users that has those roles
	 */
	static public function usersWithRoles(array $roles): array
	{
		global $conn;
		/** @var ?PDOStatement */
		$stmt = null;

		if (count($roles) == 0) {
			$stmt = $conn->prepare("SELECT * FROM users");
		} else {

			$placeholders = implode(",", array_fill(0, count($roles), "?"));

			$stmt = $conn->prepare(<<<EOT
			SELECT * FROM users
			INNER JOIN roles ON users.id = roles.id
			WHERE roles.role IN ($placeholders)
			EOT);

			foreach ($roles as $i => $role) {
				$role_str = roletype_to_str($role);
				$stmt->bindParam($i + 1, $role_str);
			}
		}

		$stmt->execute();
		$users = array();
		$user_count = 0;

		while ($user_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$users[$user_count++] = static::assocToUser($user_data);
		}

		return $users;
	}
}

function create_default_admin()
{
	$admin_users = User::usersWithRoles([RoleType::ADMIN]);

	if (count($admin_users) > 0) return;

	$email = getenv("CLEARUNS_ADMIN_EMAIL") ?: "admin@admin.com";

	$user = User::getUserByEmail($email);

	if ($user == null) {
		$password = getenv("CLEARUNS_ADMIN_PASSWORD") ?: "admin";
		$first_name = getenv("CLEARUNS_ADMIN_FIRST_NAME") ?: "Admin";
		$last_name = getenv("CLEARUNS_ADMIN_LAST_NAME") ?: "Admin";

		$user = User::create($email, $password, $first_name, $last_name);
	}

	Role::create($user->id, RoleType::ADMIN);
}

create_default_admin();
