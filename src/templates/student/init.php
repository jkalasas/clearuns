<?php
require __DIR__ . "/../../../vendor/autoload.php";

use Clearuns\DB\Model;
use Clearuns\Service\Auth;

session_start();

$user = Auth::requireAuthenticated([Model\RoleType::STUDENT]);
$roles = Model\Role::getUserRoles($user->id);

$_SESSION["current_role"] = "STUDENT";
