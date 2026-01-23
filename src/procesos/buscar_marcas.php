<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';
require_once __DIR__ . '/../Entity/Marcas.php';

use App\Entity\Marcas;

header('Content-Type: application/json');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$entityManager = $entityManager ?? require __DIR__ . '/../Entity/bootstrap.php';
$repo = $entityManager->getRepository(Marcas::class);
$marcas = $repo->findAll();

$results = [];
if ($q !== '') {
    $qLower = mb_strtolower($q);
    $startsWith = [];
    $contains = [];
    foreach ($marcas as $marca) {
        $nombre = $marca->getNombre();
        $nombreLower = mb_strtolower($nombre);
        if (mb_strpos($nombreLower, $qLower) === 0) {
            $startsWith[] = $nombre;
        } elseif (mb_strpos($nombreLower, $qLower) !== false) {
            $contains[] = $nombre;
        }
    }
    $results = array_merge($startsWith, $contains);
} else {
    foreach ($marcas as $marca) {
        $results[] = $marca->getNombre();
    }
}

echo json_encode($results);
