<?php
require_once __DIR__ . "/../includes/db/models/role.php";
require_once __DIR__ . "/../includes/utils/auth.php";

session_start();
$user = require_authenticated();

$roles = Role::getUserRoles($user->id);

if (count($roles) < 1) {
	unset($_SESSION["user_id"]);
	$_SESSION["login_error"] = "User should have at least one role";
	header("Location: /login.php");
	exit();
} else if (count($roles) == 1) {
	$role_str = roletype_to_str($roles[0]->role);
	header("Location: /" . strtolower($role_str));
	exit();
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Choose Role | Clearuns</title>
</head>

<body>
	<h1>Choose Role</h1>
	<ul>
		<?php foreach($roles as $role) { 
			$role_str = roletype_to_str($role->role);
		?>
		<li><a href="/<?php echo strtolower($role_str) ?>"><?php echo $role_str ?></a></li>
		<?php } ?>
	</ul>
</body>

</html>
