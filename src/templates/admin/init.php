<?php
require_once __DIR__ . "/../../../vendor/autoload.php";

use Clearuns\Service\Auth;
use Clearuns\Service\Role;
use Clearuns\Service\RoleType;

session_start();

$user = Auth::requireAuthenticated([RoleType::ADMIN]);
$roles = Role::extractRoles($user);

$_SESSION["current_role"] = "ADMIN";
