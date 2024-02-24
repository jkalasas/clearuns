<?php

function createConnection(): PDO
{
	$DB_HOST = getenv("DB_HOST");
	$DB_USER = getenv("DB_USER");
	$DB_NAME = getenv("DB_NAME");
	$DB_PASSWORD = getenv("DB_PASSWORD");

	$conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);

	$conn->exec("
	CREATE TABLE IF NOT EXISTS users (
		id INT AUTO_INCREMENT PRIMARY KEY,
		email VARCHAR(1028) NOT NULL,
		password VARCHAR(32) NOT NULL
	)
	");

	return $conn;
}
