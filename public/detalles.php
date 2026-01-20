<?php
require_once '../config/config.php';
require_once  '../src/Entity/bootstrap.php';
require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';

// Importamos las entidades necesarias
use App\Entity\Producto;

// 1. OBTENER EL ID DE LA URL
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: filtro.php');
    exit;
}

// 2. BUSCAR EL PRODUCTO EN LA BASE DE DATOS
$producto = $entityManager->find(Producto::class, $id);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

// 3. MAPEO DE IMÁGENES (Mismo array que usas en filtro.php para mantener coherencia)
$img_productos = [
    'Camiseta Logo Gold' => 'https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1730222114/784361_XJGTE_1152_001_100_0000_Light-camiseta-de-punto-de-algodon-estampado.jpg',
    'Bolso Saddle Mini' => 'https://assets.christiandior.com/is/image/diorprod/M0455CBAAM66B_SBG_E01?$r2x3_raw$&crop=0,0,4000,5000&wid=1334&hei=2000&scale=1&bfc=on&qlt=85',
    'Chaqueta Maya Down' => 'https://moncler-cdn.thron.com/api/v1/content-delivery/shares/dpx6uv/contents/K29541A1252068950742_4/image/plumifero-con-capucha-maya-nino-azul-marino-moncler-4.jpg?w=1300&q=80',
    'Camisa Silk Print' => 'https://www.versace.com/dw/image/v2/BGWN_PRD/on/demandware.static/-/Sites-ver-master-catalog/default/dw3f96a6e4/original/90_1020082-1A16350_5X000_10_PrintedSilkKnitShirt-Knitwear-Versace-online-store_0_2.jpg?sw=850&q=85&strip=true',
    'Cartera Monogram' => 'https://es.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-cartera-lily-con-cadena--M82509_PM2_Front%20view.jpg',
    'Vestido corto' => 'https://images.thebestshops.com/product_images/original/iKRIX-gucci-short-dresses-web-detailed-viscose-dress-00000124879f00s003.jpg',
    'Chaqueta Dior ' => 'https://dripkickzz.com/wp-content/uploads/2025/10/Dior-sz44-54-fxtx07-6_3863537.webp',
    'Llavero' => 'https://es.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-llavero-lv-dragonne--M62706_PM2_Front%20view.jpg',
    'Camiseta Versace' => 'https://images.thebestshops.com/product_images/original/SL12044-035_02-f4d863.jpg',
    'Pantalones Dior' => 'https://cdn-images.farfetch-contents.com/20/50/49/72/20504972_50589018_600.jpg',
    'Chaqueta Moncler' => 'https://holtrenfrew.scene7.com/is/image/HoltRenfrew1/m_5000896451_01',
    'Vestido Verde' => 'https://images.vestiairecollective.com/images/resized/w=1246,q=75,f=auto,/produit/vestidos-gucci-de-algodon-verde-54802360-1_2.jpg',
    'Chaqueta moncler' => 'https://www.mytheresa.com/media/1094/1238/100/17/P01068383.jpg',
    'Sudadera Dior' => 'https://cdn1.jolicloset.com/img4/detail4b/2024/05/1324295-1/ropa-punto-christian-dior.jpg',
    'Bolso gucci' => 'https://media.gucci.com/style/DarkGray_Center_0_0_1200x1200/1697733137/764960_K9GSG_8367_001_057_0000_Light-minibolso-ophidia.jpg',
    'Collar Versace' => 'https://www.versace.com/dw/image/v2/BGWN_PRD/on/demandware.static/-/Sites-ver-master-catalog/default/dw8e7806c5/original/90_1015461-1A00621_4JNF0_22_IconCrystalNecklace-Necklaces-Versace-online-store_0_1.jpg?sw=850&q=85&strip=true',
    'Default' => 'https://via.placeholder.com/500x600?text=Luxury+Item'
];

$urlImagen = $img_productos[$producto->getNombre()] ?? $img_productos['Default'];

$pageTitle = $producto->getNombre() . " - El Corte Rebelde";
include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/CSS/detalles.css"> 
        
</head>
<body>

<div class="detalles-container">
    <div class="detalles-img">
        <img src="<?= $urlImagen ?>" alt="<?= htmlspecialchars($producto->getNombre()) ?>">
    </div>

    <div class="detalles-info">
        <p style="color: #888; text-transform: uppercase; letter-spacing: 1px;">
            <?= $producto->getMarca() ? $producto->getMarca()->getNombre() : 'Exclusivo' ?>
        </p>
        <h1><?= htmlspecialchars($producto->getNombre()) ?></h1>
        <div class="detalles-precio"><?= number_format($producto->getPrecio(), 2) ?> €</div>
        
        <div class="detalles-meta">
            <div class="meta-item">
                <span class="meta-label">Categoría:</span> 
                <?= $producto->getCategoria() ? $producto->getCategoria()->getNombre() : 'General' ?>
            </div>
            <div class="meta-item">
                <span class="meta-label">Tipo:</span> 
                <?= $producto->getTipoRopa() ? $producto->getTipoRopa()->getNombre() : 'N/A' ?>
            </div>
            <div class="meta-item">
                <span class="meta-label">Talla:</span> 
                <?= $producto->getTalla() ? $producto->getTalla()->getNombre() : 'Única' ?>
            </div>
            <div class="meta-item">
                <span class="meta-label">Color:</span> 
                <?= htmlspecialchars($producto->getColor()) ?>
            </div>
            <div class="meta-item" style="margin-top: 20px; font-style: italic; color: #555;">
                <span class="meta-label">Descripción:</span><br>
                Diseño exclusivo de alta gama, fabricado con materiales premium seleccionados para la colección actual de El Corte Rebelde.
            </div>
        </div>

        <a href="agregar_carrito.php?id=<?= $producto->getId() ?>" class="btn-comprar">
    Añadir a la Cesta
</a>
        <div style="margin-top: 15px;">
            <a href="filtro.php" style="color: #666; font-size: 0.9rem;">← Volver al catálogo</a>
        </div>
    </div>
</div>

<?php include "../src/components/footer.php" ?>
</body>
</html>