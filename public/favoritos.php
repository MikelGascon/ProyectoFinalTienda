<?php
require_once '../config/config.php';
require_once '../src/Entity/bootstrap.php';

require_once '../src/Entity/Producto.php';
require_once '../src/Entity/Marcas.php';
require_once '../src/Entity/TipoRopa.php';
require_once '../src/Entity/TallaRopa.php';
require_once '../src/Entity/CategoriaSexo.php';
require_once '../src/Entity/Usuario.php';

use App\Entity\Producto;

session_start();

// 1. LÓGICA PARA OBTENER LOS PRODUCTOS FAVORITOS
$usuario_id = $_SESSION['usuario_id'] ?? null;
$productosFavoritos = [];

if ($usuario_id) {
    $conn = $entityManager->getConnection();
    // Obtenemos los IDs de los productos marcados como favoritos por este usuario
    $ids = $conn->fetchFirstColumn("SELECT producto_id FROM favoritos WHERE usuario_id = ?", [$usuario_id]);

    if (!empty($ids)) {
        $repo = $entityManager->getRepository(Producto::class);
        $productosFavoritos = $repo->createQueryBuilder('p')
            ->where('p.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()->getResult();
    }
}

// 2. MAPEO DE IMÁGENES
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

$pageTitle = "Mis Favoritos - El Corte Rebelde";
include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../src/CSS/favoritos.css">
   
</head>
<body>

<div class="layout">
    <aside class="sidebar">
        <div class="filter-group">
            <h3>Mi Cuenta</h3>
            <p style="font-size: 0.9rem; color: #666;">
                Hola, <strong><?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?></strong>
            </p>
        </div>
        <hr>
        <div class="filter-group">
            <a href="filtro.php" style="text-decoration:none; color: #000; display:block; margin-bottom:15px;">Ir a la Tienda</a>
            <a href="carrito.php" style="text-decoration:none; color: #000; display:block;">Mi Carrito</a>
        </div>
    </aside>

    <main class="main-container">
        <div class="grid-productos">
            <div style="grid-column: 1 / -1; margin-bottom: 30px;">
                <h1 style="font-size: 1.8rem;">Mis Favoritos ♥</h1>
                <p style="color: #888;">Tienes <?= count($productosFavoritos) ?> artículos guardados.</p>
            </div>

            <?php if (empty($productosFavoritos)): ?>
                <div class="wishlist-empty" style="grid-column: 1 / -1; text-align: center; padding: 50px 0;">
                    <p style="font-size: 1.1rem; color: #777; margin-bottom: 20px;">Tu lista de deseos está vacía.</p>
                    <a href="filtro.php" class="btn-link btn-dark" style="display:inline-block; padding: 12px 25px;">Ver catálogo</a>
                </div>
            <?php else: ?>
                <?php foreach ($productosFavoritos as $p): ?>
                    <?php
                    $idProd = $p->getId();
                    $nombreProd = $p->getNombre();
                    $urlImagen = $img_productos[$nombreProd] ?? $img_productos['Default'];
                    ?>
                    <div class="producto-card">
                        <div class="prod-img">
                            <img src="<?= $urlImagen ?>" alt="<?= htmlspecialchars($nombreProd) ?>" class="img-fit">
                            
                            <a href="toggle_favoritos.php?id=<?= $idProd ?>" class="btn-favorito-eliminar" title="Quitar de favoritos">
                                ♥
                            </a>
                        </div>

                        <div class="prod-name"><?= htmlspecialchars($nombreProd) ?></div>
                        <div class="prod-price"><?= number_format($p->getPrecio(), 2) ?> €</div>
                        
                        <div class="prod-info" style="font-size: 0.8rem; color: #999; margin-bottom: 10px;">
                            <?= $p->getMarca() ? $p->getMarca()->getNombre() : 'Colección Rebelde' ?>
                        </div>

                        <div class="prod-actions">
                            <a href="detalles.php?id=<?= $idProd ?>" class="btn-link btn-outline">Detalles</a>
                            <a href="agregar_carrito.php?id=<?= $idProd ?>" class="btn-link btn-dark">Añadir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include "../src/components/footer.php" ?>

</body>
</html>