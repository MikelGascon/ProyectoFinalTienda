<?php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv; 

require_once __DIR__ . '/../../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../../');
$dotenv->load();

// Resto de tu configuración...
$paths = [__DIR__]; 
$isDevMode = true;

$dbParams = [
    'driver'   => 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'dbname'   => $_ENV['DB_NAME'],
    'port'     => $_ENV['DB_PORT'],
];

$config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
$connection = DriverManager::getConnection($dbParams, $config);
$entityManager = new EntityManager($connection, $config);

return $entityManager;
