<?php
require_once __DIR__ . "/config.php";


if (!isset($conn)) {
	$conn = create_connection();
}
