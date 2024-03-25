<?php
require __DIR__ . "/../src/templates/init.php";

use Clearuns\Service\Auth;
use Clearuns\Service\Role;
use Clearuns\Service\RoleType;

session_start();
$user = Auth::requireAuthenticated($entity_manager);

$roles = $user->getRoles();

/** @var array<string, bool> */
$active_roles = array_filter($roles, fn (bool $active) => $active);

if (count($active_roles) < 1) {
	unset($_SESSION["user_id"]);
	$_SESSION["login_error"] = "User should have at least one role";
	header("Location: /login.php");
	exit();
} else if (count($active_roles) == 1) {
	/** @var string */
	$active_role = array_keys($active_roles)[0];
	header("Location: /" . strtolower($active_role));
	exit();
}

function role_to_icon(string $role)
{
	switch ($role) {
		case "ADMIN":
			return "admin_panel_settings";
		case "FACULTY":
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
			<?php foreach ($active_roles as $role => $active) : ?>
				<li class="role-item font-passion-one relative">
					<i class="role-icon material-symbols-outlined"><?php echo role_to_icon($role) ?></i>
					<a class="stretched-link" href="/<?php echo strtolower($role) ?>"><?php echo $role_str ?></a>
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
