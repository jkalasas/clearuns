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

	#[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP", "on update" => "CURRENT_TIMESTAMP"])]
	private \DateTime $created_at;

	#[ORM\Column(type: "datetime", options: ["default" => "CURRENT_TIMESTAMP", "on update" => "CURRENT_TIMESTAMP"])]
	private \DateTime $updated_at;

	public function getID(): int
	{
		return $this->id;
	}

	public function authenticate(string $password, callable $checkHash): bool
	{
		return $checkHash($password, $this->$password);
	}

	/**
	 * @return array<RoleType, bool>
	 */
	public function getRoles()
	{
		return array(
			RoleType::ADMIN => $this->is_admin,
			RoleType::FACULTY => $this->is_faculty,
			RoleType::STUDENT => $this->is_student
		);
	}
}
