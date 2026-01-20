<?php
session_start();

require_once "../src/BDD/bootstrap.php";
require_once "../src/Entity/Comentario.php";
require_once "../src/Entity/Usuario.php";

use Entity\Comentario;

// Procesar comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentarioTexto = trim($_POST['comentario'] ?? '');
    $rating          = intval($_POST['rating'] ?? 0);

    if (!empty($comentarioTexto) && $rating >= 1 && $rating <= 5) {
        $comentario = new Comentario();
        $comentario->setIdUsuario(1); // temporal
        $comentario->setRating($rating);
        $comentario->setTexto($comentarioTexto);
        $comentario->setFecha(new \DateTime());

        $entityManager->persist($comentario);
        $entityManager->flush();
    }
}

// Obtener comentarios
$query = $entityManager->createQuery("
    SELECT c
    FROM Entity\Comentario c
    WHERE c.fecha = (
        SELECT MAX(c2.fecha)
        FROM Entity\Comentario c2
        WHERE c2.id_usuario = c.id_usuario
    )
    ORDER BY c.fecha DESC
");
$comentarios = $query->getResult();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nosotros | Nuestra Empresa 2026</title>
    <!-- Links necesarios para BootsTrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <style>
        .hero-section {
            background: #f8f9fa;
            padding: 100px 0;
        }

        .team-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
        }

        .icon-box {
            font-size: 2.5rem;
            color: #0d6efd;
        }
    </style>
</head>

<body>

    <?php include "../src/components/header.php" ?>

    <!-- Hero Section (Nuestra Identidad) -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Transformando el futuro desde 2026</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Somos un equipo apasionado dedicado a crear soluciones innovadoras que mejoran la vida de las personas
                en la era digital.
            </p>
        </div>
    </section>

    <!-- Nuestra Historia -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="images.unsplash.com" class="img-fluid rounded shadow" alt="Nuestro Equipo">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold mb-3">Nuestra Historia</h2>
                    <p>En un mundo que cambia rápidamente, nuestra empresa nació con la visión de simplificar la
                        tecnología compleja. Creemos en la transparencia, la innovación constante y el compromiso con
                        nuestros clientes.</p>
                    <p>Desde nuestros humildes comienzos como una startup local, hemos crecido hasta convertirnos en
                        referentes del sector, siempre manteniendo nuestros valores fundamentales intactos.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Valores Clave -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">Nuestros Valores</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-lightbulb icon-box mb-3"></i>
                        <h4 class="fw-bold">Innovación</h4>
                        <p class="text-muted">Buscamos constantemente nuevas formas de superar los límites de lo
                            posible.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-shield-check icon-box mb-3"></i>
                        <h4 class="fw-bold">Confianza</h4>
                        <p class="text-muted">Construimos relaciones duraderas basadas en la honestidad y seguridad.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-people icon-box mb-3"></i>
                        <h4 class="fw-bold">Colaboración</h4>
                        <p class="text-muted">El éxito es un esfuerzo compartido entre nuestro equipo y clientes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas (Prueba Social) -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>10k+</h3>
                    <p>Clientes</p>
                </div>
                <div class="col-md-3">
                    <h3>150+</h3>
                    <p>Proyectos</p>
                </div>
                <div class="col-md-3">
                    <h3>50+</h3>
                    <p>Premios</p>
                </div>
                <div class="col-md-3">
                    <h3>12</h3>
                    <p>Países</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Opiniones de clientes -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">Opiniones de nuestros clientes</h2>
            <div class="row g-4">
                <?php foreach ($comentarios as $c): ?>
                    <?php
                    $comentario = $c instanceof Comentario ? $c : $c[0];
                    $usuario    = is_array($c) && isset($c[1]) ? $c[1] : null;
                    $texto      = htmlspecialchars($comentario->getTexto());
                    $recortado  = strlen($texto) > 140 ? substr($texto, 0, 140) . '...' : $texto;
                    ?>
                    <div class="col-md-4">
                        <div class="bg-white p-4 rounded shadow-sm h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="text-warning">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="<?php echo $i <= $comentario->getRating() ? 'text-warning' : 'text-muted'; ?>">★</span>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-muted"><?php echo $comentario->getFecha()->format('d/m/Y'); ?> · <?php echo rand(0, 1) ? 'Google' : 'Yelp'; ?></small>
                            </div>
                            <p class="mb-2"><?php echo $recortado; ?></p>
                            <p class="fw-bold mb-0"><?php echo $usuario ? $usuario->getNombre() : 'Usuario'; ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Formulario de comentario -->
            <div class="mt-5">
                <h3 class="fw-bold text-center mb-4">Deja tu comentario</h3>
                <form method="POST" class="mx-auto" style="max-width: 600px;">
                    <div class="mb-3 text-center">
                        <div class="rating-stars" data-rating="0">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <span data-value="<?php echo $i; ?>" style="font-size: 30px; cursor: pointer;" class="text-muted">★</span>
                            <?php endfor; ?>
                        </div>
                        <input type="hidden" name="rating" id="rating-value" value="0">
                    </div>
                    <div class="mb-3">
                        <textarea name="comentario" class="form-control" rows="4" placeholder="Escribe tu opinión..." required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Enviar comentario</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include "../src/components/footer.php" ?>

    <!-- Bootstrap 5 JS -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const stars = document.querySelectorAll(".rating-stars span");
            const ratingInput = document.getElementById("rating-value");

            stars.forEach(star => {
                star.addEventListener("click", () => {
                    const value = parseInt(star.dataset.value);
                    ratingInput.value = value;
                    pintarEstrellas(value);
                });

                star.addEventListener("mouseover", () => {
                    pintarEstrellas(star.dataset.value);
                });

                star.addEventListener("mouseleave", () => {
                    pintarEstrellas(ratingInput.value);
                });
            });

            function pintarEstrellas(value) {
                stars.forEach(s => {
                    s.classList.toggle("text-warning", s.dataset.value <= value);
                    s.classList.toggle("text-muted", s.dataset.value > value);
                });
            }
        });
    </script>


</body>

</html>