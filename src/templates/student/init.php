<?php
require_once __DIR__ . "/../../bootstrap.php";

use Clearuns\Service\Auth;

session_start();

$user = Auth::requireAuthenticated($entity_manager, ["STUDENT"]);
$roles = $user->getRoles();

$_SESSION["current_role"] = "STUDENT";
