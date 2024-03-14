<?php
require __DIR__ . "/../../../vendor/autoload.php";

use Clearuns\DB\Models;
use Clearuns\Service\Auth;

session_start();

$user = Auth::requireAuthenticated([Models\RoleType::ADMIN]);
$roles = Models\Role::getUserRoles($user->id);

$_SESSION["current_role"] = "ADMIN";
