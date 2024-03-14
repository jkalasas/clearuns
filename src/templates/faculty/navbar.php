<?php

use Clearuns\Component\NavBar;

$links = array(
	array("path" => "/faculty/", "icon" => "home", "label" => "Home"),
	array("path" => "/logout.php", "icon" => "logout", "label" => "Logout"),
);

NavBar::render($links);
