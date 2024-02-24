<?php

function createConnection(): PDO
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
