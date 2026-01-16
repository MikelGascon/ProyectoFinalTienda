<?php
// Dentro de src/BDD/bootstrap.php

// 1. El autoload está DOS niveles arriba
require_once __DIR__ . '/../../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Dotenv\Dotenv;

// 2. El archivo .env está DOS niveles arriba (en la raíz)
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// 3. Las Entidades están en un nivel paralelo (subir uno y entrar en Entity)
$paths = [__DIR__ . '/../Entity']; 
$isDevMode = true;

$dbParams = array(
    'driver'   => 'pdo_mysql',
    'host'     => $_ENV['DB_HOST'],
    'port'     => $_ENV['DB_PORT'],
    'dbname'   => $_ENV['DB_NAME'],
    'user'     => $_ENV['DB_USER'],
    'password' => $_ENV['DB_PASS'],
    'charset'  => 'utf8mb4' 
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
$entityManager = EntityManager::create($dbParams, $config);