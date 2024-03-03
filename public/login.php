<?php
session_start();

if (isset($_SESSION["user_id"])) {
	header("Location: /choose-role.php");
	exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require_once __DIR__ . "/../src/libs/db/models/user.php";

	$user = User::authenticateUser($_POST["email"], $_POST["password"]);

	if ($user == null) {
		$_SESSION["login_error"] = "Invalid email or password";
	} else {
		$_SESSION["user_id"] = $user->id;
		header("Location: /choose-role.php");
		exit();
	}
}

require_once __DIR__ . "/../src/templates/utils/PasswordInput.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="./assets/styles/style.css" />
	<title>Login | Clearuns</title>
</head>

<body>
	<form action="/login.php" method="POST" class="login-form">
		<input type="email" id="email" name="email" placeholder="Email" />
		<?php createPasswordInput("password", "", "Password") ?>
		<div class="remember-me-container">
			<span>
				<input type="checkbox" name="remember-me" />
				<label for="remember-me">Remember Me</label>
			</span>
			<a href="#" class="forgot-password">Forgot Password?</a>
		</div>
		<?php
		if (isset($_SESSION["login_error"])) {
		?>
			<span><?php echo $_SESSION["login_error"] ?></span>
		<?php
			unset($_SESSION["login_error"]);
		}
		?>
		<button type="submit" class="login-btn">LOGIN</button>
	</form>
</body>

</html>