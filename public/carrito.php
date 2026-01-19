<?php
session_start();

// Mapeo de imágenes (Asegúrate de que coincida con tus nombres en SQL)
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
    'Default' => 'https://via.placeholder.com/500x600?text=No+Image'
];

$carrito = $_SESSION['carrito'] ?? [];
$totalGeneral = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras - El Corte Rebelde</title>
    <link rel="stylesheet" href="../src/Css/carrito.css">
    <style>
        .tabla-productos { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .tabla-productos th { text-align: left; border-bottom: 2px solid #eee; padding: 10px; }
        .tabla-productos td { padding: 15px 10px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .img-carrito { width: 70px; height: 70px; object-fit: cover; border-radius: 4px; }
        .total-compra { text-align: right; padding: 20px; font-size: 1.5rem; font-weight: bold; }
        .btn-eliminar { color: #cc0000; text-decoration: none; font-size: 1.4rem; font-weight: bold; padding: 5px 10px; }
        .btn-eliminar:hover { background: #fee; border-radius: 50%; }
        .vaciar-link { color: #888; text-decoration: underline; font-size: 0.9rem; }
        .vaciar-link:hover { color: #cc0000; }
    </style>
</head>
<body>
    <?php include('../src/components/header.php'); ?>

    <div class="carrito-box">
        <h2>Tu carrito</h2>

        <?php if (!isset($_SESSION['usuario'])): ?>
            <div class="login-aviso">
                <p>Debes iniciar sesión para ver tu carrito.</p>
                <a href="login.php">Ir al login</a>
            </div>
        <?php elseif (empty($carrito)): ?>
            <div class="lista-vacia">No hay productos en el carrito todavía.</div>
            <div class="acciones">
                <a href="filtro.php"><button>Seguir comprando</button></a>
            </div>
        <?php else: ?>
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $id => $item): 
                        $urlImg = $img_productos[$item['nombre']] ?? $img_productos['Default'];
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $totalGeneral += $subtotal;
                    ?>
                    <tr>
                        <td><img src="<?= $urlImg ?>" class="img-carrito"></td>
                        <td><strong><?= htmlspecialchars($item['nombre']) ?></strong></td>
                        <td><?= $item['cantidad'] ?></td>
                        <td><?= number_format($item['precio'], 2) ?> €</td>
                        <td><?= number_format($subtotal, 2) ?> €</td>
                        <td>
                            <a href="eliminar_item.php?id=<?= $id ?>" class="btn-eliminar" title="Eliminar">&times;</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-compra">Total: <?= number_format($totalGeneral, 2) ?> €</div>

            <div class="acciones" style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                <div>
                    <a href="filtro.php"><button style="background: #eee; color: #000; margin-right: 10px; border: 1px solid #ccc;">Seguir comprando</button></a>
                    <button style="background: #000; color: #fff;">Finalizar Pedido</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php include('../src/components/footer.php'); ?>
</body>
</html>