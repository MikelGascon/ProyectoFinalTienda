<?php
// Configuración inicial
$siteName = "LOGO";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../src/Css/styles.css" rel="stylesheet">
</head>

<body>
    <!-- Top Banner -->
    <div class="top-banner bg-primary-custom text-white text-center py-2 position-relative small">
        <span>20% OFF EN COLECCIÓN DE INVIERNO</span>
        <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Close"></button>
    </div>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm py-3">
        <div class="container">
            <!-- Mobile Menu Button -->
            <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Logo -->
            <a class="navbar-brand" href="">
                <img src="../src/img/logo_rebelde.png" alt="Logo Rebelde" height="40" class="d-inline-block">
            </a>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-medium mx-2" href="#">TEXTO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium mx-2" href="#">TEXTO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium mx-2" href="#">TEXTO</a>
                    </li>
                </ul>
            </div>

            <!-- Search Bar (Desktop) -->
            <form class="d-none d-lg-flex mx-3">
                <input class="form-control search-box px-3 py-2" type="search" placeholder="Buscar..."
                    aria-label="Buscar">
            </form>

            <!-- Icons -->
            <div class="d-flex align-items-center">
                <a href="#" class="icon-btn text-decoration-none fs-5 ms-3 d-none d-lg-inline"><i
                        class="bi bi-search"></i></a>
                <a href="#" class="icon-btn text-decoration-none fs-5 ms-3"><i class="bi bi-cart2"></i></a>
                <a href="#" class="icon-btn text-decoration-none fs-5 ms-3"><i class="bi bi-person"></i></a>
            </div>
        </div>
    </nav>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Menú</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form class="mb-4">
                <input class="form-control search-box" type="search" placeholder="Buscar...">
            </form>
            <ul class="navbar-nav">
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">TEXTO</a>
                </li>
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">TEXTO</a>
                </li>
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">TEXTO</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Hero Slider -->
    <section class="hero-slider bg-dark">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="d-flex align-items-center justify-content-start h-100 ps-5">
                        <!-- Espacio para imagen de fondo -->
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase">Comprar</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-start h-100 ps-5">
                        <!-- Espacio para imagen de fondo -->
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase">Comprar</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="d-flex align-items-center justify-content-start h-100 ps-5">
                        <!-- Espacio para imagen de fondo -->
                        <a href="#" class="btn btn-comprar py-2 px-4 fw-medium text-uppercase">Comprar</a>
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

    <!-- Footer -->
    <footer class="py-5 pb-4 border-top">
        <div class="container">
            <div class="row">
                <!-- Logo & Social -->
                <div class="col-12 col-lg-3 mb-4">
                    <div class="mb-3">
                        <img src="../src/img/logo_rebelde.png" alt="Logo Rebelde" height="40" class="d-inline-block">
                    </div>
                    <div class="social-icons">
                        <a href="#" class="text-dark text-decoration-none fs-5 me-3"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="text-dark text-decoration-none fs-5 me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-dark text-decoration-none fs-5 me-3"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="text-dark text-decoration-none fs-5 me-3"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <!-- Use Cases -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Use cases</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">UI design</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">UX design</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Wireframing</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Diagramming</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Brainstorming</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Online
                                whiteboard</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Team
                                collaboration</a></li>
                    </ul>
                </div>

                <!-- Explore -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Explore</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Design</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Prototyping</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Development
                                features</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Design
                                systems</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Collaboration
                                features</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Design
                                process</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">FigJam</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Resources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Best
                                practices</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Colors</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Color wheel</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Support</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Developers</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Resource
                                library</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Close top banner
        document.querySelector('.top-banner .btn-close')?.addEventListener('click', function () {
            document.querySelector('.top-banner').style.display = 'none';
        });
    </script>
</body>

</html>