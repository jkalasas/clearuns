<?php
require_once __DIR__ . "/../db/models/Role.php";
require_once __DIR__ . "/../db/models/User.php";

/**
 * Requires the user to be authenticated
 * @var PDO $conn connection to the db
 * @var Role[]|null $roles required roles to access the page
 * @return User user instance of currently authenticated user
 */
function require_authenticated(array $roles = null): User
{
	if (!isset($_SESSION)) session_start();

	if (!isset($_SESSION["user_id"])) {
		header("Location: /login.php");
		exit();
	}

	$user = User::getAuthenticatedUser();

	if ($user == null) {
		header("Location: /login.php");
		unset($_SESSION["user_id"]);
		exit();
	} else if ($roles != null && !Role::verifyAllInUser($user->id, $roles)) {
		header("Location: /app");
		exit();
	}

	return $user;
}
