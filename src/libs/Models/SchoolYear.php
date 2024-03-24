<?php

namespace Clearuns\Models;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "school_year")]
class SchoolYear
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private int $id;

	#[ORM\Column(type: "integer", nullable: false)]
	private int $start_year;

	#[ORM\Column(type: "integer", nullable: false)]
	private int $end_year;
}
