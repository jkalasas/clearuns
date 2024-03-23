<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;

require __DIR__ . "/src/bootstrap.php";

ConsoleRunner::run(
	new SingleManagerProvider($entity_manager)
);
