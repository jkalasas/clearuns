<?php

namespace Clearuns\DB\Models;

use Exception, PDO;
use Clearuns\DB\Database;

class Role extends BaseModel
{
	public int $id;
	public RoleType $role;
	public int $user_id;

	public function __construct(int $id, RoleType|string $role, int $user_id)
	{
		$this->id = $id;
		if (gettype($role) == "string") $this->role = static::strToRoletype($role);
		else $this->role = $role;
		$this->user_id = $user_id;
	}

	static protected function assocToModel($data)
	{
		return new Role(
			$data["id"],
			$data["role"],
			$data["user_id"],
		);
	}

	static public function create(int $user_id, RoleType|string $role): Role
	{
		global $conn;

		if (gettype($role) == "string") $role = static::strToRoleType($role);

		$role_str = static::roleTypeToStr($role);

		$stmt = $conn->prepare("INSERT INTO roles (role,user_id) VALUES (:role,:user_id)");
		$stmt->execute(["role" => $role_str, "user_id" => $user_id]);

		$role_id = $conn->lastInsertId();
		$stmt = $conn->prepare("SELECT * FROM roles WHERE id=?");
		$stmt->execute([$role_id]);

		$role_data = $stmt->fetch(PDO::FETCH_ASSOC);

		return static::assocToModel($role_data);
	}

	/**
	 * @param int $user_id Target user to get the roles from
	 * @return Role[]
	 */
	static public function getUserRoles(int $user_id)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT * FROM roles WHERE user_id=?");
		$stmt->bindParam(1, $user_id);
		$stmt->execute();

		/** @var Role[] */
		$roles = array();
		$role_count = 0;

		while ($role_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$roles[$role_count++] = static::assocToModel($role_data);
		}

		return $roles;
	}

	static public function verifyInUser(int $user_id, RoleType $role): bool
	{
		$conn = Database::getConnection();
		$role_str = static::roleTypeToStr($role);
		$stmt = $conn->prepare("SELECT COUNT(*) FROM roles WHERE user_id=? AND role=?");
		$stmt->bindParam(1, $user_id);
		$stmt->bindParam(2, $role_str);
		$stmt->execute();

		/** @var int */
		$count = $stmt->fetch(PDO::FETCH_COLUMN);

		return $count > 0;
	}

	/**
	 * Verifies if all roles required exists in the user
	 * @var PDO $conn Connection to the db
	 * @var RoleType[] $roles Roles to check in the user
	 * @return bool True if roles exists in the user, otherwise false
	 */
	static public function verifyAllInUser(int $user_id, array $roles): bool
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT role FROM roles WHERE user_id=?");
		$stmt->bindParam(1, $user_id);
		$stmt->execute();
		$roles_data = $stmt->fetchAll(PDO::FETCH_COLUMN);

		foreach ($roles_data as $index => $role_str) {
			$roles_data[$index] = static::strToRoleType($role_str);
		}

		foreach ($roles as $role) {
			if (!in_array($role, $roles_data)) return false;
		}

		return true;
	}

	static public function strToRoleType(string $role_str): RoleType
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

	static public function roleTypeToStr(RoleType $role): string
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
}
