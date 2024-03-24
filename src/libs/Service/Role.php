<?php

namespace Clearuns\Service;

use Clearuns\Models\User;

class Role
{
	/**
	 * @param User $user Target user to check roles
	 * @param RoleType[] $roles Array of required roles
	 * @return bool True if user have all the roles
	 */
	static public function userHasRoles(User $user, array $roles)
	{
		$user_roles = $user->getRoles();

		foreach ($roles as $role) {
			if (!$user_roles[$role]) return false;
		}

		return true;
	}
}
