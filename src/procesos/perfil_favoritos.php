<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../Entity/bootstrap.php';

require_once "../Entity/Favoritos.php";
require_once "../Entity/Producto.php";
require_once "../Entity/Usuario.php";


session_start();

$usuario_id = $_SESSION['usuario_id'] ?? null;


// 4. MAPEO DE IMÁGENES
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

// Query real a favoritos - Ajusta según tu estructura de BD

$favoritos = []; // Usaremos esta variable para el bucle del HTML

if ($usuario_id) {
    try {
        $conn = $entityManager->getConnection();
        
        // Traemos ID, Nombre y Precio de la tabla productos
        $sql = "SELECT p.id, p.nombre, p.precio 
                FROM favoritos f 
                INNER JOIN productos p ON f.producto_id = p.id 
                WHERE f.usuario_id = ?";

        $favoritos = $conn->fetchAllAssociative($sql, [$usuario_id]);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

?>


<div class="section-title">
    <i class="bi bi-heart-fill"></i> Mis Favoritos
    <span class="count-badge"><?php echo count($favoritos); ?> productos</span>
</div>

<div class="favoritos-actions mb-4">
    <div class="btn-group">
        <button class="filter-btn active" data-view="grid">
            <i class="bi bi-grid-3x3-gap"></i> Cuadrícula
        </button>
        <button class="filter-btn" data-view="list">
            <i class="bi bi-list-ul"></i> Lista
        </button>
    </div>
</div>

<div class="favoritos-container" data-view="grid">
    <?php if (empty($favoritos)): ?>
        <div class="empty-state">
            <i class="bi bi-heart-fill"></i>
            <h3>Tu lista de favoritos está vacía</h3>
            <p>Explora nuestra tienda y guarda los productos que te gusten</p>
            
            <a href="../public/filtro.php" class="btn btn-primary">
                Ir a la Tienda
            </a>
        </div>
    <?php else: ?>
        <?php foreach ($favoritos as $producto): 

            $nombreProd = $producto['nombre'];
            $imgUrl = $img_productos[$nombreProd] ?? $img_productos['Default'];

            ?>
            <div class="favorito-item">
                <div class="favorito-img">
                    <img src="<?php echo $imgUrl?>" alt="<?php echo htmlspecialchars($nombreProd)?>">
                </div>
                
                <div class="favorito-info">
                    <h5 class="favorito-nombre"><?php echo htmlspecialchars($nombreProd); ?></h5>
                    
                    <?php if (isset($producto['talla'])): ?>
                        <p class="favorito-talla">Talla: <?php echo htmlspecialchars($producto['talla']); ?></p>
                    <?php endif; ?>
                    
                    <div class="favorito-precio">
                        €<?php echo number_format($producto['precio'], 2); ?>
                    </div>
              
                </div>
                
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
</div>

<div>
    <h2>Para editar favortios dirigese al apartado de Favoritos</h2>
    <a href="../public/favoritos.php"> Redireccion Favoritos</a>
</div>

<script src="../src/Js/favoritos.js"></script>