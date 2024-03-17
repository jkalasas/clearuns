<?php

namespace Clearuns\Service;

use Clearuns\DB\Model\User;
use Clearuns\Service\Role;
use Clearuns\Service\RoleType;

class Auth
{
	/**
	 * @param RoleType[]|null $roles Required roles to check in the user
	 * @return User
	 */
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
		} else if ($roles != null && !Role::userHasRoles($user, $roles)) {
			header("Location: /app");
			exit();
		}

		return $user;
	}
}
