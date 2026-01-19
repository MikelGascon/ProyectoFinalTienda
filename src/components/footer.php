<?php
/**
 * Footer Component
 * Incluye: Footer completo y scripts de Bootstrap
 * 
 * Variables opcionales:
 * - $basePath: Ruta base para recursos (default: "../src")
 */

$basePath = $basePath ?? "../src";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- Footer -->
    <footer class="py-5 pb-4 border-top">
        <div class="container">
            <div class="row">
                <!-- Logo & Social -->
                <div class="col-12 col-lg-3 mb-4">
                    <div class="mb-3">
                        <img src="<?php echo $basePath; ?>/img/logo_rebelde.png" alt="Logo Rebelde" height="40"
                            class="d-inline-block">
                    </div>
                    <div class="social-icons">
                        <a href="https://x.com/" class="text-dark text-decoration-none fs-5 me-3"><i
                                class="bi bi-twitter-x"></i></a>
                        <a href="https://www.instagram.com/" class="text-dark text-decoration-none fs-5 me-3"><i
                                class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/" class="text-dark text-decoration-none fs-5 me-3"><i
                                class="bi bi-youtube"></i></a>
                        <a href="https://es.linkedin.com/" class="text-dark text-decoration-none fs-5 me-3"><i
                                class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <!-- Use Cases -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Ayuda</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../public/preguntas_frecuentes.php" class="text-secondary text-decoration-none small">Preguntas
                                frecuentes</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Tramitar
                                devolucion</a>
                        </li>
                        <li class="mb-2"><a href="../public/servicios_tienda.php" class="text-secondary text-decoration-none small">Servicios de la
                                tienda</a>
                        </li>
                        <li class="mb-2"><a href="../public/tarjeta_regalo.php" class="text-secondary text-decoration-none small">Tarjeta de
                                regalo</a>
                    </ul>
                </div>

                <!-- Trabaja con nostros -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Empresa</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../public/nosotros.php" class="text-secondary text-decoration-none small">Quienes somos</a>
                        </li>
                        <li class="mb-2"><a href="../public/trabaja_nosotros.php" class="text-secondary text-decoration-none small">Trabaja con
                                nosotros</a>
                        </li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <h6 class="fw-semibold small mb-3">Resources</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Blog</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Best
                                practices</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Colors</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Color wheel</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Support</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Developers</a>
                        </li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none small">Resource
                                library</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Añadir el eslogan de CopyRight-->
            <div>
                CopyRight - Todos los derechos reservador a CorteRebelde
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
