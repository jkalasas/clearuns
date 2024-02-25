<?php
include_once __DIR__ . "/models/user.php";

function authenticateUser(PDO $conn, string $email, string $password): ?User
{
	$email = trim($email);
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->bindParam(1, $email);
	$stmt->execute();

	$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

	if ($user_data == null) return null;
	else if (!password_verify(trim($password), $user_data["password"])) return null;

	return new User(
		$user_data["id"],
		$user_data["email"],
		$user_data["password"],
		$user_data["first_name"],
		$user_data["last_name"],
		$user_data["created_at"],
		$user_data["updated_at"],
		$user_data["middle_initial"],
		$user_data["suffix"],
	);
}

function getAuthUser(PDO $conn, int $userID): ?User
{
	$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
	$stmt->bindParam(1, $userID);
	$stmt->execute();

	$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user_data == null) return null;

	return new User(
		$user_data["id"],
		$user_data["email"],
		$user_data["password"],
		$user_data["first_name"],
		$user_data["last_name"],
		$user_data["created_at"],
		$user_data["updated_at"],
		$user_data["middle_initial"],
		$user_data["suffix"],
	);
}
