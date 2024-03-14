<?php
require_once __DIR__ . "/../src/libs/db/models/Role.php";
require_once __DIR__ . "/../src/libs/utils/auth.php";

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

function role_to_icon(RoleType $role)
{
	switch ($role) {
		case RoleType::ADMIN:
			return "admin_panel_settings";
		case RoleType::FACULTY:
			return "badge";
		default:
			return "school";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./assets/styles/style.css" />
	<title>Choose Role | Clearuns</title>
</head>

<body id="choose-role">
	<main>
		<h1 class="font-passion-one text-center" style="font-size: 3rem">CHOOSE <br /> ACCOUNT</h1>
		<ul class="role-types">
			<?php foreach ($roles as $role) : ?>
				<?php $role_str = roletype_to_str($role->role) ?>
				<li class="role-item font-passion-one relative">
					<i class="role-icon material-symbols-outlined"><?php echo role_to_icon($role->role) ?></i>
					<a class="stretched-link" href="/<?php echo strtolower($role_str) ?>"><?php echo $role_str ?></a>
				</li>
			<?php endforeach; ?>
			<li class="role-item font-passion-one relative">
				<i class="role-icon material-symbols-outlined">logout</i>
				<a class="stretched-link" href="/logout.php">Logout</a>
			</li>
		</ul>
	</main>
</body>

</html>
