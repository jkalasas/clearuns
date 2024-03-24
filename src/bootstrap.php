<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . "/../vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
	paths: array(__DIR__ . "/libs/Models"),
	isDevMode: true,
);

$connection = DriverManager::getConnection(array(
	"driver" => "pdo_mysql",
	"host" => getenv("DB_HOST") ?: "127.0.0.1",
	"port" => (int) getenv("DB_PORT") ?: 3306,
	"user" => getenv("DB_USER") ?: "root",
	"password" => getenv("DB_PASSWORD") ?: "",
	"dbname" => getenv("DB_NAME") ?: "meow",
));

$entity_manager = new EntityManager($connection, $config);
