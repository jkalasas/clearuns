<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="student_profile")
 */
#[ORM\Entity]
#[ORM\Table(name: "student_profile")]
class StudentProfile
{
	#[ORM\Id]
	#[ORM\Column(type: "integer")]
	private int $user_id;

	#[ORM\Column(type: "boolean", options: ["default" => false])]
	private bool $is_irregular = false;

	#[ORM\Column(type: "integer", nullable: false)]
	private int $year_level;

	#[ORM\OneToOne(targetEntity: "User")]
	#[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
	private User $user;
}
