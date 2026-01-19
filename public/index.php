<?php
require_once __DIR__ . '/../config/config.php';
$pageTitle = "El Corte Rebelde";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";
include '../src/components/header.php';

// Incluir header (top banner + navbar)
//include   COMPONENT_URL .'/header.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Links necesarios para BootsTrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link href="<?php echo $basePath; ?>/Css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-video-container">
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="<?php echo $basePath; ?>/img/video_hero_dior.mp4" type="video/mp4">
            </video>
            <div class="hero-content">
                <h1 class="hero-title">Nueva colección 2026</h1>
                <a href="filtro.php" class="hero-link">Descubre más</a>
            </div>
        </div>
    </section>

    <!-- New Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-uppercase mb-4">NUEVO</h2>

            <!-- Contenedor con flechas fuera -->
            <div class="new-products-section position-relative px-5">
                <!-- Flecha izquierda -->
                <button
                    class="carousel-arrow prev position-absolute top-50 start-0 translate-middle-y bg-transparent border-0 fs-3"
                    type="button" data-bs-target="#newProductsCarousel" data-bs-slide="prev">
                    <i class="bi bi-arrow-left"></i>
                </button>

                <!-- Carrusel -->
                <div id="newProductsCarousel" class="carousel slide" data-bs-ride="false">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row g-3 g-md-4">
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/1055691/pexels-photo-1055691.jpeg'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/27308637/pexels-photo-27308637.png'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/27230001/pexels-photo-27230001.png'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row g-3 g-md-4">
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/20470892/pexels-photo-20470892.jpeg'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/27239701/pexels-photo-27239701.png'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder rounded-3"
                                        style="background-image: url('https://images.pexels.com/photos/25054142/pexels-photo-25054142.jpeg'); background-size: cover; background-position: center;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flecha derecha -->
                <button
                    class="carousel-arrow next position-absolute top-50 end-0 translate-middle-y bg-transparent border-0 fs-3"
                    type="button" data-bs-target="#newProductsCarousel" data-bs-slide="next">
                    <i class="bi bi-arrow-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-4">
        <div class="container-fluid px-0">
            <div class="categories-row">
                <div class="category-col">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden"
                        style="background-image: url('https://images.pexels.com/photos/1187777/pexels-photo-1187777.jpeg'); background-size: cover; background-position: center;">
                        <h5 class="fw-normal small lh-base">Lorem ipsum<br>dolor sit amet</h5>
                    </div>
                </div>
                <div class="category-col">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden"
                        style="background-image: url('https://images.pexels.com/photos/29391506/pexels-photo-29391506.jpeg'); background-size: cover; background-position: center;">
                        <h5 class="fw-normal small lh-base">Lorem ipsum<br>dolor sit amet</h5>
                    </div>
                </div>
                <div class="category-col">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden"
                        style="background-image: url('https://images.pexels.com/photos/5898472/pexels-photo-5898472.jpeg'); background-size: cover; background-position: center;">
                        <h5 class="fw-normal small lh-base">Lorem ipsum<br>dolor sit amet</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Text Navigation -->
    <section class="py-4">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center gap-3 gap-md-4 flex-wrap">
                <span class="fw-semibold text-uppercase" role="button">TEXTO</span>
                <div class="dot rounded-circle"></div>
                <span class="fw-semibold text-uppercase" role="button">TEXTO</span>
                <div class="dot rounded-circle"></div>
                <span class="fw-semibold text-uppercase" role="button">TEXTO</span>
                <div class="dot rounded-circle"></div>
                <span class="fw-semibold text-uppercase" role="button">TEXTO</span>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-6 col-md-4">
                    <a href="#producto1" class="text-decoration-none text-dark">
                        <div class="text-center">
                            <div class="photo-placeholder product-card rounded-3 mb-3">
                                <div class="img-default" style="background-image: url('https://images.pexels.com/photos/15462793/pexels-photo-15462793.jpeg');"></div>
                                <div class="img-hover" style="background-image: url('https://images.vestiairecollective.com/images/resized/w=1024,q=75,f=auto,/produit/bolsos-clutch-gucci-de-terciopelo-caqui-30611847-1_3.jpg');"></div>
                            </div>
                            <h6 class="fw-normal mb-1">Nombre producto</h6>
                            <p class="fw-bold mb-0">PRECIO</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#producto2" class="text-decoration-none text-dark">
                        <div class="text-center">
                            <div class="photo-placeholder product-card rounded-3 mb-3">
                                <div class="img-default" style="background-image: url('https://assets.christiandior.com/is/image/diorprod/LOOK_H_26_2_LOOK_002_E01-1?$r9x10_raw$&crop=0,0,4000,5000&wid=1536&hei=1661&scale=0.8303&bfc=on&qlt=85');"></div>
                                <div class="img-hover" style="background-image: url('https://assets.christiandior.com/is/image/diorprod/683M629A4002C889_SBG_E01-5?$r9x10_raw$&crop=0,0,4000,5000&wid=1536&hei=1661&scale=0.8303&bfc=on&qlt=85');"></div>
                            </div>
                            <h6 class="fw-normal mb-1">Nombre producto</h6>
                            <p class="fw-bold mb-0">PRECIO</p>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-4">
                    <a href="#producto3" class="text-decoration-none text-dark">
                        <div class="text-center">
                            <div class="photo-placeholder product-card rounded-3 mb-3">
                                <div class="img-default" style="background-image: url('https://assets.christiandior.com/is/image/diorprod/LOOK_F_26_2_LOOK_007_E07?$r9x10_raw$&crop=0,0,4000,5000&wid=1024&hei=1107&scale=0.5535&bfc=on&qlt=85');"></div>
                                <div class="img-hover" style="background-image: url('https://assets.christiandior.com/is/image/diorprod/E4464WOMLQD309_SBG_E03?$r9x10_raw$&crop=0,0,4000,5000&wid=1024&hei=1107&scale=0.5535&bfc=on&qlt=85');"></div>
                            </div>
                            <h6 class="fw-normal mb-1">Nombre producto</h6>
                            <p class="fw-bold mb-0">PRECIO</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Free Shipping Banner -->
    <section class="shipping-banner py-5 text-center text-white">
        <div class="container">
            <h3 class="fw-semibold mb-0 fs-4 fs-md-3">ENVÍO GRATIS A PARTIR DE 50€</h3>
        </div>
    </section>

    <!-- Brand Logos -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center gap-5">
                <div class="brand-logo"><img src="../src/img/logo_dior.png" alt="dior"></div>
                <div class="brand-logo"><img src="../src/img/logo_gucci.png" alt="gucci"></div>
                <div class="brand-logo"><img src="../src/img/logo_loius.png" alt="loius"></div>
                <div class="brand-logo"><img src="../src/img/logo_moncler.png" alt="moncler"></div>
                <div class="brand-logo"><img src="../src/img/logo_versace.png" alt="versace"></div>
            </div>
        </div>
    </section>

    <!-- Comentarios-->

    <!--
    Crear un div, mas que muestre un panel de poder poner comentarios de los usuarios, Se mostraran los detalles de las  
    valoraciones, en una pagina diferente
    
    -->


 <?php include "../src/components/footer.php"?>
</body>

</html>