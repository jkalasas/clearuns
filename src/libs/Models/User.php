<?php

namespace Clearuns\Models;

use Clearuns\Service\RoleType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "user")]
class User
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int|null $id = null;

	#[ORM\Column(length: 255, unique: true, nullable: false)]
	private string $email;

	#[ORM\Column(length: 255, nullable: false)]
	private string $password;

	#[ORM\Column(length: 100, nullable: false)]
	private string $first_name;

	#[ORM\Column(length: 100, nullable: false)]
	private string $last_name;

	#[ORM\Column(length: 2, nullable: true)]
	private string|null $middle_initial = null;

	#[ORM\Column(length: 10, nullable: true)]
	private string|null $suffix = null;

	#[ORM\Column(type: "boolean", options: ["default" => false])]
	private bool $is_admin = false;

	#[ORM\Column(type: "boolean", options: ["default" => false])]
	private bool $is_faculty = false;

	#[ORM\Column(type: "boolean", options: ["default" => false])]
	private bool $is_student = false;

	#[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP", "on update" => "CURRENT_TIMESTAMP"])]
	private \DateTime|null $created_at = null;

	#[ORM\Column(type: "datetime", nullable: true, options: ["default" => "CURRENT_TIMESTAMP", "on update" => "CURRENT_TIMESTAMP"])]
	private \DateTime|null $updated_at = null;

	public function getID(): int
	{
		return $this->id;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function getMiddleInitial()
	{
		return $this->middle_initial;
	}

	public function getSuffix()
	{
		return $this->suffix;
	}

	public function getTimeCreated()
	{
		return $this->created_at;
	}

	public function getLastUpdated()
	{
		return $this->updated_at;
	}

	public function setEmail(string $email)
	{
		// if (filter_var($email, FILTER_VALIDATE_EMAIL))
		// 	throw new \InvalidArgumentException("'" . $email . "' is an invalid email.");

		$this->email = $email;
	}

	public function setFirstName(string $first_name)
	{
		$this->first_name = $first_name;
	}

	public function setLastName(string $last_name)
	{
		$this->last_name = $last_name;
	}

	public function setMiddleInitial(string|null $middle_initial)
	{
		$this->middle_initial = $middle_initial;
	}

	public function setSuffix(string|null $suffix)
	{
		$this->suffix = $suffix;
	}

	public function setPassword(string $password)
	{
		$this->password = password_hash($password, PASSWORD_BCRYPT);
	}

	public function setRoles(bool $admin = null, bool $faculty = false, bool $student = false)
	{
		if (isset($admin)) $this->is_admin = $admin;
		if (isset($faculty)) $this->is_faculty = $faculty;
		if (isset($student)) $this->is_student = $student;
	}

	public function authenticate(string $password): bool
	{
		return password_verify($password, $this->password);
	}

	/**
	 * @return array<RoleType, bool>
	 */
	public function getRoles()
	{
		return array(
			"ADMIN" => $this->is_admin,
			"FACULTY" => $this->is_faculty,
			"STUDENT" => $this->is_student
		);
	}

	public static function getByID(EntityManager $em, int $id): ?User
	{
		return $em->find(User::class, $id);
	}

	public static function getByEmail(EntityManager $em, string $email): ?User
	{
		$qb = $em->createQueryBuilder()
			->select("u")
			->from(User::class, "u")
			->where("u.email = :email")
			->setParameter("email", $email);

		try {
			return $qb->getQuery()->getSingleResult();
		} catch (\Doctrine\ORM\NoResultException) {
			return null;
		}
	}
}
