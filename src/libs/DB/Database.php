<?php

namespace Clearuns\DB;

use PDO;

class Database
{
	static private PDO $conn;

	static private function createConnection()
	{
		$DB_HOST = getenv("DB_HOST");
		$DB_USER = getenv("DB_USER");
		$DB_NAME = getenv("DB_NAME");
		$DB_PASSWORD = getenv("DB_PASSWORD");

		$sql = file_get_contents(__DIR__ . "/scripts/schemas.sql");
		$conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
		$conn->exec($sql);

		return $conn;
	}

	static public function getConnection()
	{
		if (isset(static::$conn)) return static::$conn;
		$conn = static::createConnection();

		static::$conn = $conn;

		return $conn;
	}
}
