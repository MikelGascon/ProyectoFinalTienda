<?php
<<<<<<< HEAD
// Raiz main del proyecto
define("BASE_URL", 'C:\xampp\htdocs\ProyectoFinal\ProyectoFinalTienda');
=======
// --- RUTA FÍSICA (Para PHP: require, include) ---
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);
>>>>>>> 76a950a500300eb3454d04bbb988d334629cb4a1

// --- RUTA URL (Para HTML: href, src, action) ---
define("BASE_URL", "http://localhost/CorteRebelde/ProyectoFinalTienda");

// --- SUB-RUTAS PARA PHP (Usan ROOT_PATH) ---
define("ENTITY_PATH", ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "Entity");
define("PROCESS_PATH", ROOT_PATH . "src" . DIRECTORY_SEPARATOR . "procesos");

// --- SUB-RUTAS PARA HTML (Usan BASE_URL) ---
define("IMG_URL", "/src/img");
define("CSS_URL", "/src/css");
define("JS_URL", "/src/Js");
define('ENTITY_URL', "/src/Entity");
define("PROCESS_URL", "/src/procesos");
?>