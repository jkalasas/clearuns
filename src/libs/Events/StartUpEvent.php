<?php

namespace Clearuns\Events;

use Clearuns\Models\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class StartUpEvent
{
	private static function createAdminUser(EntityManager $em)
	{
		$qb = $em->createQueryBuilder()
			->select("COUNT(u) AS count")
			->from("Clearuns\Models\User", "u")
			->where("u.is_admin = 1");

		$count = $qb->getQuery()->getSingleScalarResult();

		if ($count > 0);

		$email = getenv("CLEARUNS_ADMIN_EMAIL") ?: "admin@admin.com";

		$qb = $em->createQueryBuilder()
			->select("u")
			->from("Clearuns\Models\User", "u")
			->where("u.email = :email")
			->setParameter("email", $email);

		$user = null;

		try {
			/** @var User */
			$user = $qb->getQuery()->getSingleResult();
			$roles = $user->getRoles();

			if (!$roles["ADMIN"]) {
				$user->setRoles(true);
				$em->flush();
			}
		} catch (NoResultException) {
			$user = new User();
			$user->setEmail($email);
			$user->setPassword(getenv("CLEARUNS_ADMIN_PASSWORD") ?: "admin");
			$user->setName(
				getenv("CLEARUNS_ADMIN_FIRST_NAME") ?: "Admin",
				getenv("CLEARUNS_ADMIN_LAST_NAME") ?: "Admin",
			);
			$user->setRoles(true);
			$em->persist($user);
			$em->flush();
		}
	}

	public static function start(EntityManager $em)
	{
		static::createAdminUser($em);
	}
}
