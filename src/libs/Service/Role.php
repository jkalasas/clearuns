<?php

namespace Clearuns\Service;

use Clearuns\DB\Model\User;

class Role
{
	static public function roleInUser(RoleType $role, User $user)
	{
		switch ($role) {
			case RoleType::ADMIN:
				return $user->is_admin;
			case RoleType::FACULTY:
				return $user->is_faculty;
			case RoleType::STUDENT:
				return $user->is_student;
		}
	}

	/**
	 * @param int|User $user user object or id to target
	 * @param RoleType[] $required_roles array of required roles
	 * @return bool true if user has the roles
	 */
	static public function userHasRoles(int|User $user, array $required_roles)
	{
		/** @var User */
		$target = $user;
		if (gettype($user) == "integer") {
			$target = User::getUser($user);

			if (!isset($target)) throw new \Exception("User not found");
		}

		foreach ($required_roles as $role) {
			if (!static::roleInUser($role, $user)) return false;
		}
		return true;
	}
}
