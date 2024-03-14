<?php

namespace Clearuns\Service;

use Clearuns\DB\Model\User;
use Clearuns\DB\Model\Role;

class Auth
{
	static public function requireAuthenticated(array $roles = null): User
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
}
