<?php

namespace Clearuns\DB\Model;

use Clearuns\DB\Database;
use PDO;

class Department extends BaseModel
{
	public int $id;
	public string $name;
	public string $short_name = null;

	public function __construct(int $id, string $name, string $short_name = null)
	{
		$this->id = $id;
		$this->name = $name;
		$this->short_name = $short_name;
	}

	static protected function assocToModel($data)
	{
		return new Department(
			$data["id"],
			$data["name"],
			$data["short_name"],
		);
	}

	static public function create(string $name, string $short_name = null)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare(<<<EOT
			INSERT INTO department (name, short_name)
			VALUES (:name, :short_name);
		EOT);
		$stmt->execute(array("name" => $name, "short_name" => $short_name));

		$id = $conn->lastInsertId();

		return static::getDepartment($id);
	}

	static public function getDepartment(int $id)
	{
		$conn = Database::getConnection();
		$stmt = $conn->prepare("SELECT * FROM department WHERE id=:id");
		$stmt->execute(array("id" => $id));
		$data = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!isset($data)) return false;

		return static::assocToModel($data);
	}
}
