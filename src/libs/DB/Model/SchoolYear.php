<?php

namespace Clearuns\DB\Model;

use Clearuns\DB\Database;
use PDO;

class SchoolYear extends BaseModel
{
	public int $id;
	public int $start_year;
	public int $end_year;

	public function __construct($id, $start_year, $end_year)
	{
		$this->id = $id;
		$this->start_year = $start_year;
		$this->end_year = $end_year;
	}

	static protected function assocToModel($data)
	{
		return new SchoolYear(
			$data["id"],
			$data["start_year"],
			$data["end_year"],
		);
	}

	static public function create(int $start_year, int $end_year)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare(<<<EOT
			INSERT INTO school_year (start_year, end_year)
			VALUES (:start_year, :end_year);
		EOT);
		$stmt->execute(array("start_year" => $start_year, "end_year" => $end_year));
		$id = $conn->lastInsertId();

		return static::getSchoolYear($id);
	}


	static public function getSchoolYear(int $id)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT * FROM school_year WHERE id=:id");
		$stmt->execute(array("id" => $id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($data)) return null;

		return static::assocToModel($data);
	}

	static public function getByYears(int $start_year, int $end_year)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare(<<<EOT
			SELECT * FROM school_year
			WHERE start_year = :start_year AND end_year = :end_year
			EOT);
		$stmt->execute(array("start_year" => $start_year, "end_year" => $end_year));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($data)) return null;

		return static::assocToModel($data);
	}
}
