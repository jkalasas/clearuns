<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int|null $id = null;

	/** @ORM\Column(length=255, unique=true, nullable=false) */
	private string $email;

	/** @ORM\Column(length=255, nullable=false) */
	private string $password;

	/** @ORM\Column(length=100, nullable=false) */
	private string $first_name;

	/** @ORM\Column(length=100, nullable=false) */
	private string $last_name;

	/** @ORM\Column(lenght=2, nullable=true) */
	private string|null $middle_initial = null;

	/** @ORM\Column(length=10, nullable=true) */
	private string|null $suffix = null;

	/** @ORM\Column(type="bool", options={ "default": false }) */
	private bool $is_admin = false;

	/** @ORM\Column(type="bool", options={ "default": false }) */
	private bool $is_faculty = false;

	/** @ORM\Column(type="bool", options={ "default": false }) */
	private bool $is_student = false;

	/** @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP", "on update": "CURRENT_TIMESTAMP"}) */
	private \DateTime $created_at;

	/** @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP", "on update": "CURRENT_TIMESTAMP"}) */
	private \DateTime $updated_at;
}
