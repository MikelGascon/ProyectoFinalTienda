<?php
// --- RUTA FÍSICA (Para PHP: require, include) ---
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR); 

// --- RUTA URL (Para HTML: href, src, action) ---
define("BASE_URL", "http://localhost/CorteRebelde/ProyectoFinalTienda");

// --- SUB-RUTAS PARA PHP (Usan ROOT_PATH) ---
define("ENTITY_PATH", ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "Entity");
define("PROCESS_PATH", ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "procesos");

// --- SUB-RUTAS PARA HTML (Usan BASE_URL) ---
define("IMG_URL", BASE_URL . "/src/img");
define("CSS_URL", BASE_URL . "/src/css");
?>
