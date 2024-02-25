<?php
enum RoleType
{
	case ADMIN;
	case FACULTY;
	case STUDENT;
}

function str_to_roletype(string $role_str): ?RoleType
{
	switch (strtoupper(trim($role_str))) {
		case 'ADMIN':
			return RoleType::ADMIN;
		case 'FACULTY':
			return RoleType::FACULTY;
		case 'STUDENT':
			return RoleType::STUDENT;
	}

	throw new Exception("Role " . $role_str . " doesn't exist");
}

function roletype_to_str(RoleType $role): ?string
{
	switch ($role) {
		case RoleType::ADMIN:
			return 'ADMIN';
		case RoleType::FACULTY:
			return 'FACULTY';
		case RoleType::STUDENT:
			return 'STUDENT';
	}
}

class Role
{
	public int $id;
	public RoleType $role;
	public int $user_id;

	public function __construct(int $id, RoleType|string $role, int $user_id)
	{
		$this->id = $id;
		if (gettype($role) == "string") $this->role = str_to_roletype($role);
		else $this->role = $role;
		$this->user_id = $user_id;
	}

	static public function get_user_roles(PDO $conn, int $user_id)
	{
		$stmt = $conn->prepare("SELECT * FROM roles WHERE user_id=?");
		$stmt->bindParam(1, $user_id);
		$stmt->execute();

		$roles = array();
		$role_count = 0;

		while ($role_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$roles[$role_count++] = new Role(
				$role_data["id"],
				$role_data["role"],
				$role_data["user_id"]
			);
		}

		return $roles;
	}
}
