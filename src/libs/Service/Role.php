<?php

namespace Clearuns\Service;

use Clearuns\DB\Model\User;

class Role
{
	static private const STR_TO_ROLE_MAP = array(
		"ADMIN" => RoleType::ADMIN,
		"FACULTY" => RoleType::FACULTY,
		"STUDENT" => RoleType::STUDENT,
	);

	static private const ROLE_TO_STR_MAP = array(
		RoleType::ADMIN => "ADMIN",
		RoleType::FACULTY => "FACULTY",
		RoleType::STUDENT => "STUDENT",
	);

	static private const PROPERTY_TO_ROLE_MAP = array(
		"is_admin" => RoleType::ADMIN,
		"is_faculty" => RoleType::FACULTY,
		"is_student" => RoleType::STUDENT,
	);


	static public function strToRole(string $role_str)
	{
		return static::STR_TO_ROLE_MAP[$role_str];
	}

	static public function roleToStr(RoleType $role)
	{
		return static::ROLE_TO_STR_MAP[$role];
	}

	/**
	 * @param int|User $user User object or user ID
	 * @param bool $throw_null=false Throw error if user is null
	 * @return User?
	 */
	static private function fetchUser(int|User $user, bool $throw_null = false)
	{
		$target = $user;
		if (gettype($user) == "integer") {
			$target = User::getUser($user);
		}

		if ($throw_null && !isset($target))
			throw new \Exception("User not found");
		return $target;
	}

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
		$target = static::fetchUser($user, true);

		foreach ($required_roles as $role) {
			if (!static::roleInUser($role, $target)) return false;
		}
		return true;
	}

	static public function extractRoles(int|User $user)
	{
		$target = static::fetchUser($user, true);

		/** @var RoleType[] */
		$roles = array();

		foreach (static::PROPERTY_TO_ROLE_MAP as $key => $role) {
			if ($target->$key) array_push($roles, $role);
		}

		return $roles;
	}
}
