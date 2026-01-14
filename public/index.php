<?php
$pageTitle = "Tienda Online - Inicio";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";

// Incluir header (top banner + navbar)
include '../src/components/header.php';
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <!-- Custom CSS -->
    <link href="<?php echo $basePath; ?>/Css/styles.css" rel="stylesheet">
</head>

<body>

    <!-- Hero Slider -->
    <section class="hero-slider bg-dark">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active"
                    style="background-image: url('https://images.pexels.com/photos/298863/pexels-photo-298863.jpeg'); background-size: cover; background-position: center;">
                    <div class="d-flex align-items-end justify-content-center h-100 pb-5">
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase mb-2">Comprar</a>
                    </div>
                </div>
                <div class="carousel-item"
                    style="background-image: url('https://images.pexels.com/photos/934070/pexels-photo-934070.jpeg'); background-size: cover; background-position: center;">
                    <div class="d-flex align-items-end justify-content-center h-100 pb-5">
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase mb-2">Comprar</a>
                    </div>
                </div>
                <div class="carousel-item"
                    style="background-image: url('https://images.pexels.com/photos/1488463/pexels-photo-1488463.jpeg'); background-size: cover; background-position: center;">
                    <div class="d-flex align-items-end justify-content-center h-100 pb-5">
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase mb-2">Comprar</a>
                    </div>
                </div>
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
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row g-3 g-md-4">
                                <div class="col-4">
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="product-placeholder bg-secondary-subtle rounded-3">
                                        <!-- Espacio para foto producto -->
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
            <div class="row g-0">
                <div class="col-12 col-md-4">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden">
                        <!-- Espacio para imagen de fondo categoría -->
                        <h5 class="fw-normal small lh-base">Lorem ipsum<br>dolor sit amet</h5>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden">
                        <!-- Espacio para imagen de fondo categoría -->
                        <h5 class="fw-normal small lh-base">Lorem ipsum<br>dolor sit amet</h5>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="category-card d-flex align-items-end p-3 text-white position-relative overflow-hidden">
                        <!-- Espacio para imagen de fondo categoría -->
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
                    <div class="text-center">
                        <div
                            class="photo-placeholder d-flex align-items-center justify-content-center text-white fw-semibold rounded-3 mb-3">
                            FOTO
                        </div>
                        <h6 class="fw-normal mb-1">Nombre producto</h6>
                        <p class="fw-bold mb-0">PRECIO</p>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="text-center">
                        <div
                            class="photo-placeholder d-flex align-items-center justify-content-center text-white fw-semibold rounded-3 mb-3">
                            FOTO
                        </div>
                        <h6 class="fw-normal mb-1">Nombre producto</h6>
                        <p class="fw-bold mb-0">PRECIO</p>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="text-center">
                        <div
                            class="photo-placeholder d-flex align-items-center justify-content-center text-white fw-semibold rounded-3 mb-3">
                            FOTO
                        </div>
                        <h6 class="fw-normal mb-1">Nombre producto</h6>
                        <p class="fw-bold mb-0">PRECIO</p>
                    </div>
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
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <div class="brand-logo border rounded px-4 py-3 fw-medium text-uppercase small">LOGO MARCA</div>
                <div class="brand-logo border rounded px-4 py-3 fw-medium text-uppercase small">LOGO MARCA</div>
                <div class="brand-logo border rounded px-4 py-3 fw-medium text-uppercase small">LOGO MARCA</div>
                <div class="brand-logo border rounded px-4 py-3 fw-medium text-uppercase small">LOGO MARCA</div>
                <div class="brand-logo border rounded px-4 py-3 fw-medium text-uppercase small">LOGO MARCA</div>
            </div>
        </div>
    </section>

    <?php include '../src/components/footer.php'; ?>

</body>

</html>