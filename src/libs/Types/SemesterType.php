<?php

namespace Clearuns\Types;

class SemesterType extends EnumType
{
	protected $name = 'enumsemester';
	protected $values = array('FIRST', 'SECOND', 'SUMMER');
}
