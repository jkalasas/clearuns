<?php

namespace Clearuns\Component\Form;

class UserForm
{
	/**
	 * @param string $email Email of the user
	 * @param string $password Password of the user
	 * @param string $firstname First name of the user
	 * @param string $lastname Last name of the user
	 * @param string $role Role of the user
	 * @param string $action target URL of the form
	 * @param "GET"|"POST" $method HTTP Method for the form
	 * @return void
	 */
	static public function render(
		string $email = "",
		string $password = "",
		string $firstname = "",
		string $lastname = "",
		string $role = "",
		string $formid = "",
		string $action = "",
		string $method = "POST",
	) {
?>
		<form action="<?php echo $action ?>" method="<?php echo $method ?>" id="<?php echo $formid ?>" class="user-create-form">
			<label for="email">Email</label>
			<input type="email" name="email" value="<?php echo $email ?>" />
			<label for="password">Password</label>
			<input type="password" name="password" value="<?php echo $password ?>" />
			<label for="firstname">First Name</label>
			<input type="text" name="firstname" value="<?php echo $firstname ?>" />
			<label for="lastname">Last Name</label>
			<input type="text" name="lastname" value="<?php echo $lastname ?>" />
			<label for="role">Role</label>
			<select name="role" value="<?php echo $role ?>">
				<option value="ADMIN">Admin</option>
				<option value="FACULTY">Faculty</option>
				<option value="STUDENT" selected>Student</option>
			</select>

			<button type="submit">Save</button>
		</form>
<?php
	}
}
