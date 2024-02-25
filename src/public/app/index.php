<?php
require_once __DIR__ . "/../../includes/db/config.php";
require_once __DIR__ . "/../../includes/utils/auth.php";

session_start();

$conn = create_connection();
$user = require_authenticated($conn);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Clearuns</title>
</head>

<body>
	<h1>Successfully logged in</h1>
	<h2>Hello, <?php echo $user->email; ?>!</h2>
	<a href="/logout.php">Logout</a>
</body>

</html>
