<?php
require_once __DIR__ . "/../../libs/db/models/role.php";
require_once __DIR__ . "/../../libs/utils/auth.php";

session_start();

$user = require_authenticated([RoleType::ADMIN]);
$roles = Role::getUserRoles($user->id);

$_SESSION["current_role"] = "ADMIN";
