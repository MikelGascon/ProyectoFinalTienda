<?php
$pageTitle = $pageTitle ?? "Tienda Online";
$bannerText = $bannerText ?? "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = $showBanner ?? true;

// Ruta base según la ubicación del archivo que incluye este componente
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

    <!-- Links necesarios para BootsTrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

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
    <nav class="navbar sticky-top shadow-sm py-2 opacidad">
        <div class="container d-flex align-items-center">
            <!-- Menú hamburguesa -->
            <div class="hamburger-container">
                <button class="btn border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu"
                    aria-label="Abrir menú">
                    <i class="bi bi-list hamburger-icon"></i>
                </button>
            </div>

            <!-- Logo -->
            <a class="navbar-brand logo-position" href="index.php">
                <img src="<?php echo $basePath; ?>/img/logo_rebelde.png" alt="Logo Rebelde" height="40"
                    class="d-inline-block">
            </a>

            <!-- Search Bar (Desktop/Tablet) -->
            <form class="search-container d-none d-md-flex mx-auto">
                <div class="search-wrapper w-100">
                    <input class="form-control search-box px-3 py-2" type="text" id="searchInput" placeholder=""
                        aria-label="Buscar">
                    <button type="button" class="btn-clear-search" id="clearSearch" aria-label="Limpiar búsqueda">
                        <i class="bi bi-x"></i>
                    </button>
                    <button type="submit" class="btn-search" aria-label="Buscar">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Spacer para móvil -->
            <div class="d-md-none flex-grow-1"></div>

            <!-- Icons -->
            <div class="d-flex align-items-center gap-3 icons-container">
                <a href="../public/login.php" class="icon-btn text-decoration-none text-dark fs-5"><i
                        class="bi bi-person"></i></a>
                <a href="../public/carrito.php" class="icon-btn text-decoration-none text-dark fs-5"><i
                        class="bi bi-cart2"></i></a>
                <a href="#" class="icon-btn text-decoration-none text-dark fs-6"><i class="bi bi-heart"></i></a>
            </div>
        </div>

        <!-- Search Bar (Mobile) -->
        <div class="container d-md-none pt-2">
            <form class="search-container w-100">
                <div class="search-wrapper w-100">
                    <input class="form-control search-box-mobile px-3 py-2" type="text" placeholder="" aria-label="Buscar">
                    <button type="button" class="btn-clear-search" aria-label="Limpiar búsqueda">
                        <i class="bi bi-x"></i>
                    </button>
                    <button type="submit" class="btn-search" aria-label="Buscar">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </nav>

    <!-- Opciones Menu hamburguesa -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title">Menú</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">Mujer</a>
                </li>
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">Hombre</a>
                </li>
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="#">Niños</a>
                </li>
                <li class="nav-item py-2 border-bottom">
                    <a class="nav-link" href="nosotros.php">Sobre Nosotros</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Script para el buscador -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearSearch');

            if (searchInput && clearBtn) {
                // Mostrar/ocultar botón X según el contenido del input
                searchInput.addEventListener('input', function () {
                    if (this.value.length > 0) {
                        clearBtn.classList.add('visible');
                    } else {
                        clearBtn.classList.remove('visible');
                    }
                });

                // Limpiar el input al hacer clic en la X
                clearBtn.addEventListener('click', function () {
                    searchInput.value = '';
                    clearBtn.classList.remove('visible');
                    searchInput.focus();
                });
            }

            // Efecto glassmorphism en navbar al hacer scroll
            const navbar = document.querySelector('.navbar.opacidad');
            if (navbar) {
                window.addEventListener('scroll', function () {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }
        });
    </script>

</body>

</html>