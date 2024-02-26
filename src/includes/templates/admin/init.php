<?php
require_once __DIR__ . "/../../db/models/role.php";
require_once __DIR__ . "/../../utils/auth.php";

session_start();

$user = require_authenticated([RoleType::ADMIN]);
$roles = Role::get_user_roles($user->id);
