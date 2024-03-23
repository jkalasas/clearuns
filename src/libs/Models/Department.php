<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="department")
 */
class Department
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int|null $id = null;

	/** @ORM\Column(length=255, unique=true, nullable=false) */
	private string $name;

	/** @ORM\Column(length=10) */
	private string|null $short_name = null;

	/** 
	 * @var ArrayCollection<Course>
	 * @ORM\OneToMany(targetEntity="Course", mappedBy="department") 
	 **/
	private Collection $courses;
}
