<?php
session_start();

if (isset($_SESSION["userID"])) {
	header("Location: /app");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require_once __DIR__ . "/../includes/db/config.php";
	require_once __DIR__ . "/../includes/db/auth.php";

	$conn = createConnection();
	$user = authenticateUser($conn, $_POST["email"], $_POST["password"]);

	if ($user == null) {
		$_SESSION["loginError"] = "Meowmeow";
	} else {
		$_SESSION["userID"] = $user->id;
		header("Location: /app");
		exit();
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Login | Clearuns</title>
</head>

<body>
	<?php
	if (isset($_SESSION["loginError"])) {
	?>
		<h1>Invalid credentials</h1>
	<?php
		unset($_SESSION["loginError"]);
	}
	?>

	<form action="/login.php" method="POST">
		<label for="email">Email</label>
		<input type="email" id="email" name="email" />
		<label for="password">Password</label>
		<input type="password" id="password" name="password" />
		<input type="submit" />
	</form>
</body>

</html>
