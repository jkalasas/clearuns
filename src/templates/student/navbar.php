<?php

require_once __DIR__ . "/../utils/NavBar.php";

use Clearuns\Templates\NavBar;

$links = array(
	array("path" => "/student/", "icon" => "home", "label" => "Home"),
	array("path" => "/logout.php", "icon" => "logout", "label" => "Logout"),
);

NavBar::render($links);
