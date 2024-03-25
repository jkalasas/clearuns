<?php

namespace Clearuns\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class EnumType extends Type
{
	protected $name;
	protected $values = array();

	public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
	{
		$values = array_map(function ($val) {
			return "'" . $val . "'";
		}, $this->values);

		return "ENUM(" . implode(", ", $values) . ")";
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		return $value;
	}

	public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): mixed
	{
		if (!in_array($value, $this->values)) {
			throw new \InvalidArgumentException("Invalid '" . $this->name . "' value.");
		}
		return $value;
	}

	public function getName()
	{
		return $this->name;
	}

	public function requiresSQLCommentHint(AbstractPlatform $platform)
	{
		return true;
	}
}
