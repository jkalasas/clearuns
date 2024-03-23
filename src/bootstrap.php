<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . "/../vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
	paths: array(__DIR__ . "/libs/Models"),
	isDevMode: true,
);

$DB_HOST = getenv("DB_HOST");
$DB_USER = getenv("DB_USER");
$DB_NAME = getenv("DB_NAME");
$DB_PASSWORD = getenv("DB_PASSWORD");


$connection = DriverManager::getConnection(array(
	"driver" => "pdo_mysql",
	"host" => getenv("DB_HOST"),
	"user" => getenv("DB_USER"),
	"password" => getenv("DB_PASSWORD"),
	"dbname" => "meow",
));

$entity_manager = new EntityManager($connection, $config);
