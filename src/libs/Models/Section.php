<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="section")
 */
class Section
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private int|null $id = null;

	/** @ORM\Column(length=10, nullable=false) */
	private string $code;

	/** @ORM\Column(type="integer") */
	private int|null $adviser_id = null;

	/** @ORM\Column(type="integer", nullable=false) */
	private int $course_id;

	/** @ORM\Column(type="integer", nullable=false) */
	private int $school_year_id;

	/** @ORM\Column(type="string", columnDefinition: "ENUM('FIRST', 'SECOND', 'SUMMER')") */
	private string $semester;

	/**
	 * @ORM\ManyToOne(targetEntity="FacultyProfile", inversedBy="handled_sections"
	 * @ORM\JoinColumn(name="adviser_id", referencedColumnName="id")
	 */
	private FacultyProfile $adviser;

	/**
	 * @ORM\ManyToOne(targetEntity="Course", inversedBy="sections")
	 * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
	 */
	private FacultyProfile $course;

	/**
	 * @ORM\ManyToOne(targetEntity="SchoolYear")
	 * @ORM\JoinColumn(name="school_year_id", referencedColumnName="id")
	 */
	private SchoolYear $school_year;
}
