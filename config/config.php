<?php
// --- RUTA FÍSICA (Para PHP: require, include) ---
define("ROOT_PATH", dirname(__DIR__) . DIRECTORY_SEPARATOR);

// --- RUTA URL (Para HTML: href, src, action) ---
define("BASE_URL", "http://localhost/CorteRebelde/ProyectoFinalTienda");



// --- SUB-RUTAS PARA HTML (Usan BASE_URL) ---
define("IMG_URL", "/src/img");
define("CSS_URL", "/src/css");
define("JS_URL", "/src/Js");
define('ENTITY_URL', "/src/Entity");
define("PROCESS_URL", "/src/procesos");
define("COMPONENT_URL","/src/components")
?>