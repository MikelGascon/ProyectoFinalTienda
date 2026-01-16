<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabaja con Nosotros | El Corte Rebelde</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- 🔥 CSS EXTERNO -->
    <link rel="stylesheet" href="../src/Css/trabaja_nosotros.css">
</head>

<body>

    <?php include "../src/components/header.php"; ?>

    <section class="hero-section text-center">
        <div class="container">

            <img src="../src/img/logo_rebelde.png" alt="Logo El Corte Rebelde" class="logo-rebelde">

            <h1 class="display-4 fw-bold mb-4">Únete a El Corte Rebelde</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                En El Corte Rebelde vivimos la moda con actitud. Buscamos personas auténticas, creativas y con ganas de formar parte de una marca que rompe con lo tradicional.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">¿Qué te ofrece El Corte Rebelde?</h2>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="beneficio-card shadow-sm text-center">
                        <i class="bi bi-lightning-charge icon-box mb-3"></i>
                        <h4 class="fw-bold">Crecimiento real</h4>
                        <p class="text-muted">Formación en moda, ventas, estilismo y gestión de tienda para impulsar tu carrera.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="beneficio-card shadow-sm text-center">
                        <i class="bi bi-people-fill icon-box mb-3"></i>
                        <h4 class="fw-bold">Ambiente joven</h4>
                        <p class="text-muted">Un equipo dinámico, cercano y con pasión por la moda urbana y rebelde.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="beneficio-card shadow-sm text-center">
                        <i class="bi bi-stars icon-box mb-3"></i>
                        <h4 class="fw-bold">Moda con identidad</h4>
                        <p class="text-muted">Participa en colecciones, campañas y lanzamientos que marcan estilo.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Vacantes disponibles</h2>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="vacante-box">
                        <h5 class="fw-bold">Dependiente/a de tienda</h5>
                        <p>Atención al cliente, estilismo, reposición y apoyo en probadores. Buscamos actitud rebelde y pasión por la moda.</p>
                        <button class="btn btn-dark">Aplicar</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="vacante-box">
                        <h5 class="fw-bold">Visual Merchandiser</h5>
                        <p>Encárgate de la imagen de tienda, escaparates y presentación de colecciones con estilo propio.</p>
                        <button class="btn btn-dark">Aplicar</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="vacante-box">
                        <h5 class="fw-bold">Gestor/a de eCommerce</h5>
                        <p>Subida de productos, control de stock online, pedidos y experiencia de usuario.</p>
                        <button class="btn btn-dark">Aplicar</button>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="vacante-box">
                        <h5 class="fw-bold">Marketing y Redes Sociales</h5>
                        <p>Creación de contenido, campañas, colaboraciones y gestión de Instagram/TikTok.</p>
                        <button class="btn btn-dark">Aplicar</button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="py-5 text-center">
        <div class="container">
            <h2 class="fw-bold mb-4">¿Quieres formar parte de El Corte Rebelde?</h2>
            <p class="lead mb-4">Envíanos tu CV y cuéntanos por qué encajas con nuestro estilo único.</p>
            <a href="mailto:rrhh@elcorterebelde.com" class="btn-rebelde">Enviar candidatura</a>
        </div>
    </section>

    <?php include "../src/components/footer.php"; ?>

</body>
</html>
