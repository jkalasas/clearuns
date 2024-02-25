<?php
require_once __DIR__ . "/../db/models/role.php";
require_once __DIR__ . "/../../includes/db/auth.php";
require_once __DIR__ . "/../../includes/db/models/role.php";

/**
 * Requires the user to be authenticated
 * @var PDO $conn connection to the db
 * @var Role[]|null $roles required roles to access the page
 * @return User user instance of currently authenticated user
 */
function require_authenticated(PDO $conn, array $roles = null): User
{
	if (!isset($_SESSION)) session_start();

	if (!isset($_SESSION["userID"])) {
		header("Location: /login.php");
		exit();
	}

	$user = getAuthUser($conn, $_SESSION["userID"]);

	if ($user == null) {
		header("Location: /login.php");
		unset($_SESSION["userID"]);
		exit();
	} else if ($roles != null && !Role::verify_all_in_user($conn, $user->id, $roles)) {
		header("Location: /app");
		exit();
	}

	return $user;
}
