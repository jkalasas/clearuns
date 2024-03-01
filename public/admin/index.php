<?php
require_once __DIR__ . "/../../src/templates/admin/init.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Home | Clearuns - Admin</title>
</head>

<body>
	<?php include __DIR__ . "/../../src/templates/admin/navbar.php" ?>
	<h1>Hello, <?php echo "$user->last_name, $user->first_name $user->middle_initial" ?>.!</h1>
</body>

</html>
