<?php
require_once __DIR__ . "/../../includes/db/config.php";
require_once __DIR__ . "/../../includes/db/models/role.php";
require_once __DIR__ . "/../../includes/utils/auth.php";

$conn = create_connection();
$user = require_authenticated($conn, [RoleType::FACULTY]);
$roles = Role::get_user_roles($conn, $user->id);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home | Clearuns - Faculty</title>
</head>

<body>
	<h1>Hello, <?php echo "$user->last_name, $user->first_name $user->middle_initial" ?>.!</h1>
	<?php if (count($roles) > 1) { ?>
		<a href="/choose-role.php">Change Role</a>
	<?php } ?>
	<a href="/logout.php">Logout</a>
</body>

</html>
