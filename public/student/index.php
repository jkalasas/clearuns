<?php
require_once __DIR__ . "/../../src/templates/student/init.php";

$first_name = $user->getFirstName();
$last_name = $user->getLastName();
$middle_initial = $user->getMiddleInitial();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/assets/styles/style.css" />
	<title>Home | Clearuns - Student</title>
</head>

<body>
	<?php include "../../src/templates/student/navbar.php" ?>
	<main>
		<h1>Hello, <?php echo htmlspecialchars("$last_name, $first_name $middle_initial") ?>.!</h1>
	</main>
</body>

</html>
