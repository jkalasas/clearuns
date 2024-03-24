<?php

namespace Clearuns\Service;

use Clearuns\Models\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class Auth
{
	const SESSION_USER_ID_NAME = "user_id";

	/** @var User|null */
	private static $current_user = null;

	public static function checkHash(string $password, string $hashed_password): bool
	{
		return password_verify($password, $hashed_password);
	}

	public static function authenticateUser(EntityManager $em, string $email, string $password): ?User
	{
		static $hashAlgorithm = fn (string $password, string $hashed_password) => password_verify($password, $hashed_password);

		if (!isset($_SESSION)) session_start();

		$qb = $em->createQueryBuilder()
			->select("u")
			->from("Clearuns\Models\User", "u")
			->where("u.email = :email")
			->setParameter("email", $email);

		$user = null;

		try {
			/** @var User */
			$user = $qb->getQuery()->getSingleResult();
		} catch (NoResultException) {
			return null;
		}

		if (!$user->authenticate($password, $hashAlgorithm)) return null;

		return $user;
	}

	public static function getAuthenticatedUser(EntityManager $em): ?User
	{
		if (isset(static::$current_user)) return static::$current_user;
		else if (!isset($_SESSION)) session_start();
		else if (!isset($_SESSION["user_id"])) return null;

		$id = $_SESSION[static::SESSION_USER_ID_NAME];

		static::$current_user = $em->find("User", $id);
		return static::$current_user;
	}

	static public function requireAuthenticated(EntityManager $em, array $roles = null): User
	{
		if (!isset($_SESSION)) session_start();

		$user = static::getAuthenticatedUser($em);

		if ($user === null) {
			header("Location: /login.php");
			unset($_SESSION[static::SESSION_USER_ID_NAME]);
			exit();
		} else if ($roles != null && !Role::userHasRoles($user, $roles)) {
			header("Location: /app");
			exit();
		}

		return $user;
	}
}
