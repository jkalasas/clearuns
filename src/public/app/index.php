<?php
require_once __DIR__ . "/../../includes/db/config.php";
require_once __DIR__ . "/../../includes/db/auth.php";

session_start();

if (!isset($_SESSION["userID"])) {
	header("Location: /login.php");
	exit();
}

$conn = createConnection();
$user = getAuthUser($conn, $_SESSION["userID"]);

if ($user == null) {
	unset($_SESSION["userID"]);
	header("Location: /login.php");
	exit();
}
?>

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