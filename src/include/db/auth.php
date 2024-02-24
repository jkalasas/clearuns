<?php
include_once __DIR__ . "/models/user.php";

function authenticateUser(PDO $conn, string $email, string $password): ?User
{
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND password=?");
	$stmt->bindParam(1, $email);
	$stmt->bindParam(2, $password);
	$stmt->execute();

	$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user_data == null) return null;

	return new User($user_data["id"], $user_data["email"], $user_data["password"]);
}

function getAuthUser(PDO $conn, int $userID): ?User
{
	$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
	$stmt->bindParam(1, $userID);
	$stmt->execute();

	$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user_data == null) return null;

	return new User($user_data["id"], $user_data["email"], $user_data["password"]);
}
