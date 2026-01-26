<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de Tienda | El Corte Rebelde</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../src/Css/servicios_tienda.css">
</head>

<body>

    <?php include "../src/components/header.php"; ?>

    <!-- HERO -->
    <section class="hero-section text-center">
        <div class="container">
            <img src="../src/img/logo_rebelde.png" alt="Logo El Corte Rebelde" class="logo-rebelde">
            <h1 class="fw-bold">Servicios de Tienda</h1>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Descubre todos los servicios exclusivos que ofrecemos para elevar tu experiencia de compra.
            </p>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section class="py-5">
        <div class="container" style="max-width: 1000px;">

            <div class="row g-4">

                <!-- Servicio 1 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-bag-check"></i>
                        </div>
                        <h4 class="fw-bold">Asesoría Personalizada</h4>
                        <p class="text-muted">
                            Nuestro equipo te ayuda a encontrar el estilo perfecto según tus gustos, necesidades y ocasión.
                        </p>
                    </div>
                </div>

                <!-- Servicio 2 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-truck"></i>
                        </div>
                        <h4 class="fw-bold">Envíos Express</h4>
                        <p class="text-muted">
                            Recibe tus pedidos en 24-48 horas con nuestro servicio de envío rápido y seguro.
                        </p>
                    </div>
                </div>

                <!-- Servicio 3 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-gift"></i>
                        </div>
                        <h4 class="fw-bold">Packaging Premium</h4>
                        <p class="text-muted">
                            Todos los productos se entregan con envoltorio exclusivo, ideal para regalos especiales.
                        </p>
                    </div>
                </div>

                <!-- Servicio 4 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold">Garantía de Autenticidad</h4>
                        <p class="text-muted">
                            Cada artículo incluye factura oficial y, cuando corresponde, certificado de autenticidad.
                        </p>
                    </div>
                </div>

                <!-- Servicio 5 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h4 class="fw-bold">Devoluciones Fáciles</h4>
                        <p class="text-muted">
                            Dispones de 14 días para devolver cualquier producto sin complicaciones.
                        </p>
                    </div>
                </div>

                <!-- Servicio 6 -->
                <div class="col-md-6">
                    <div class="servicio-card">
                        <div class="icono-servicio">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h4 class="fw-bold">Atención al Cliente 24/7</h4>
                        <p class="text-muted">
                            Estamos disponibles para resolver tus dudas en cualquier momento del día.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <?php include "../src/components/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
