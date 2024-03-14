<?php

abstract class BaseModel
{
	/**
	 * @param ArrayAccess<string, mixed> $data Object with data for model
	 * @return self
	 **/
	abstract static protected function assocToModel($data);
}
