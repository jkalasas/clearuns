<?php

namespace Clearuns\DB\Model;

use Clearuns\DB\Database;
use PDO;

class StudentProfile extends BaseModel
{
	public int $user_id;
	public int $year_level;
	public int $course_id;
	public bool $is_irregular = false;

	public function __construct(int $user_id, int $year_level, int $course_id, bool $is_irregular = false)
	{
		$this->user_id = $user_id;
		$this->year_level = $year_level;
		$this->course_id = $course_id;
		$this->is_irregular = $is_irregular;
	}

	static protected function assocToModel($data)
	{
		return new StudentProfile(
			$data["user_id"],
			$data["year_level"],
			$data["course_id"],
			$data["is_irregular"],
		);
	}

	static public function create(int $user_id, int $year_level, int $course_id, bool $is_irregular = false)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare(<<<EOT
			INSERT INTO student_profile (user_id, year_level, course_id, is_irregular)
			VALUES (:user_id, :year_level, :course_id, :is_irregular);
		EOT);
		$stmt->execute(array(
			"user_id" => $user_id,
			"year_level" => $year_level,
			"course_id" => $course_id,
			"is_irregular" => $is_irregular,
		));

		$id = $conn->lastInsertId();

		return static::getStudentProfile($id);
	}

	static public function getStudentProfile(int $user_id)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT * FROM student_profile WHERE user_id = :user_id");
		$stmt->execute(array("user_id" => $user_id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($data)) return null;

		return static::assocToModel($data);
	}
}
