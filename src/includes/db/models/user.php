<?php
class User
{
	public int $id;
	public string $email;
	public string $password;
	public string $first_name;
	public string $last_name;
	public string|null $middle_initial = null;
	public string|null $suffix = null;
	public DateTime $created_at;
	public DateTime $updated_at;


	public function __construct(
		int $id,
		string $email,
		string $password,
		string $first_name,
		string $last_name,
		string|DateTime $created_at,
		string|DateTime $updated_at,
		string|null $middle_initial = null,
		string|null $suffix = null,
	) {
		$this->id = $id;
		$this->email = $email;
		$this->password = $password;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->middle_initial = $middle_initial;
		$this->suffix = $suffix;

		if (gettype($created_at) == "string")
			$this->created_at = new DateTime($created_at);
		else $this->created_at = $created_at;

		if (gettype($updated_at) == "string")
			$this->updated_at = new DateTime($updated_at);
		else $this->updated_at = $updated_at;
	}
}