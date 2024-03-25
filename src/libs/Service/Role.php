<?php

namespace Clearuns\Service;

use Clearuns\Models\User;

class Role
{
	/**
	 * @param User $user Target user to check roles
	 * @param string[] $roles Array of required roles
	 * @return bool True if user have all the roles
	 */
	public static function userHasRoles(User $user, array $roles)
	{
		$user_roles = $user->getRoles();

		foreach ($roles as $role) {
			if (!isset($user_roles[$role]) || !$user_roles[$role]) return false;
		}

		return true;
	}
}
