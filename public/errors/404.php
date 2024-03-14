<?php
require_once "../../src/libs/db/models/user.php";

session_start();

$user = User::getAuthenticatedUser();
$isAuthenticated = !empty($user);
$role = null;

if ($isAuthenticated && isset($_SESSION["current_role"]))
	$role = strtolower($_SESSION["current_role"])
?>

<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php include_once "../../src/templates/fonts.php" ?>
	<link rel="stylesheet" href="../assets/styles/error.css" />
	<title>Not Found | Clearuns</title>
</head>

<body>
	<div class="display_container">
		<div class="container1">OOPS</div>
		<div class="container2">
			<img src="../assets/img/electrical_services.png" class="plug" />
			<h1>404</h1>
		</div>
		<div class="container3">
			<h2>This page doesn't exist</h2>
		</div>
		<div class="buttoncontainer">
			<?php if ($isAuthenticated && !empty($role)) { ?>
				<button><a href="/<?php echo $role ?>/">Go Back to Homepage</a></button>
			<?php } else if ($isAuthenticated) { ?>
				<button><a href="/choose-role.php">Go Back to Homepage</a></button>
			<?php } else { ?>
				<button><a href="/">Run back to homepage</a></button>
			<?php } ?>
		</div>
	</div>
</body>

</html>
