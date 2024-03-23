<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity
 * @ORM\Table(name="faculty_profile")
 */
class FacultyProfile
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 */
	private int $user_id;

	/** @ORM\Column(type="bool", options={ "default": false }) */
	private bool $is_adviser = false;

	/**
	 * @ORM\OneToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private User $user;

	/**
	 * @var ArrayCollection<Section>
	 * @ORM\OneToMany(targetEntity="Section", mappedBy="faculty_profile")
	 */
	private Collection $handled_sections;
}
