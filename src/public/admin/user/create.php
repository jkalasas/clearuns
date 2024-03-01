<?php
require_once __DIR__ . "/../../../includes/templates/admin/init.php";
require_once __DIR__ . "/../../../includes/templates/admin/userForm.php";

if (!isset($_SESSION)) session_start();

$email = isset($_GET["email"]) ? $_GET["email"] : "";
$firstname = isset($_GET["firstname"]) ? $_GET["firstname"] : "";
$lastname = isset($_GET["lastname"]) ? $_GET["lastname"] : "";
$role = isset($_GET["role"]) ? $_GET["role"] : "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require_once __DIR__ . "/../../../includes/db/models/role.php";
	require_once __DIR__ . "/../../../includes/db/models/user.php";

	function errorLogin(string $err)
	{
		$email = $_POST["email"];
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$role = $_POST["role"];

		$_SESSION["user-creation-error"] = $err;
		header("Location: /admin/user/create.php?email=$email&firstname=$firstname&lastname=$lastname&role=$role");
		exit();
	}

	$required_data = ["email", "password", "firstname", "lastname", "role"];

	foreach ($required_data as $key) {
		if (!isset($_POST[$key])) errorLogin("Missing or invalid information");
	}

	$user = User::getUserByEmail($email);

	if ($user != null) {
		errorLogin("User already exists with that email");
	}

	$user = User::create($_POST["email"], $_POST["password"], $_POST["firstname"], $_POST["lastname"]);

	$role = $_POST["role"];

	Role::create($user->id, $role);

	echo "Successfully added $user->id";
}
?>


<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Create User | Clearuns - Admin</title>
</head>

<body>
	<?php include __DIR__ . "/../../../includes/templates/admin/navbar.php" ?>
	<h1>Hello, <?php echo "$user->last_name, $user->first_name $user->middle_initial" ?>.!</h1>
	<?php if (isset($_SESSION["user-creation-error"])) { ?>
		<h2><?php echo $_SESSION["user-creation-error"] ?></h2>
	<?php
		unset($_SESSION["user-creation-error"]);
	}
	?>

	<?php
	createUserForm($email, "", $firstname, $lastname, $role, "user-form", "/admin/user/create.php");
	?>
</body>

</html>