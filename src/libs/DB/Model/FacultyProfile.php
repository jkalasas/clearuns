<?php

namespace Clearuns\DB\Model;

use Clearuns\DB\Database;
use PDO;

class FacultyProfile extends BaseModel
{
	public int $user_id;
	public int $department_id;
	public bool $is_adviser = false;

	public function __construct(int $user_id, int $department_id, bool $is_adviser = false)
	{
		$this->user_id = $user_id;
		$this->department_id = $department_id;
		$this->is_adviser = $is_adviser;
	}

	static protected function assocToModel($data)
	{
		return new FacultyProfile(
			$data["user_id"],
			$data["department_id"],
			$data["is_adviser"],
		);
	}

	static public function create(int $user_id, int $department_id, bool $is_adviser = false)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare(<<<EOT
			INSERT INTO faculty_profile (user_id,department_id,is_adviser)
			VALUES (:user_id, :department_id, :is_adviser);
		EOT);
		$stmt->execute(array(
			"user_id" => $user_id,
			"department_id" => $department_id,
			"is_adviser" => $is_adviser,
		));

		$id = $conn->lastInsertId();

		return static::getFacultyProfile($id);
	}

	static public function getFacultyProfile(int $user_id)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT * FROM faculty_profile WHERE user_id = :user_id");
		$stmt->execute(array("user_id" => $user_id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		return static::assocToModel($data);
	}
}
