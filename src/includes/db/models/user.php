<?php
class User
{
	public int $id;
	public string $email;
	public string $password;

	public function __construct(int $id, string $email, string $password)
	{
		$this->id = $id;
		$this->email = $email;
		$this->password = $password;
	}
}
