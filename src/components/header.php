<?php
// Detectar la ruta base según la ubicación del archivo que incluye este componente
$basePath = $basePath ?? "../src";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo $basePath; ?>/Css/styles.css" rel="stylesheet">
</head>

<body>
    <?php if ($showBanner): ?>
        <!-- Top Banner -->
        <div id="topBanner" class="top-banner bg-primary-custom text-white text-center py-2 position-relative small">
            <span><?php echo htmlspecialchars($bannerText); ?></span>
            <button type="button" class="btn-close btn-close-white btn-sm" aria-label="Close"
                onclick="document.getElementById('topBanner').style.display='none'"></button>
        </div>
    <?php endif; ?>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow-sm py-3">
        <div class="container">
            <!-- Menú hamburguesa -->
            <button class="btn border-0 me-2 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                aria-label="Abrir menú">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- Logo -->
            <a class="navbar-brand ms-3" href="index.php">
                <img src="<?php echo $basePath; ?>/img/logo_rebelde.png" alt="Logo Rebelde" height="40"
                    class="d-inline-block">
            </a>

            <!-- Spacer para centrar el logo en móvil -->
            <div class="d-lg-none flex-grow-1"></div>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-medium mx-2" href="#">INICIO</a>
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