<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "course")]
class Course
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int|null $id = null;

	#[ORM\Column(length: 255, unique: true, nullable: false)]
	private string $name;

	#[ORM\Column(length: 10)]
	private string|null $short_name = null;

	#[ORM\Column(type: "integer", nullable: false)]
	private int $department_id;

	#[ORM\ManyToOne(targetEntity: "Department", inversedBy: "course")]
	#[ORM\JoinColumn(name: "department_id", referencedColumnName: "id")]
	private Department $department;

	/** @var ArrayCollection<Course> **/
	#[ORM\OneToMany(targetEntity: "Section", mappedBy: "course")]
	private Collection $sections;
}
