<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes | El Corte Rebelde</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
        }

        .hero-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .logo-rebelde {
            width: 120px;
            margin-bottom: 20px;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--marron-oscuro);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: var(--marron-oscuro);
        }

        .accordion-button:hover {
            background-color: var(--marron-claro);
            color: white;
        }

        .accordion-item {
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <?php include "../src/components/header.php"; ?>

    <!-- Hero -->
    <section class="hero-section text-center">
        <div class="container">
            <img src="../src/img/logo_rebelde.png" alt="Logo El Corte Rebelde" class="logo-rebelde">
            <h1 class="fw-bold">Preguntas Frecuentes</h1>
            <p class="text-muted mx-auto" style="max-width: 700px;">
                Resolvemos las dudas más comunes sobre nuestras marcas, envíos y servicios.
            </p>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-5">
        <div class="container" style="max-width: 900px;">

            <div class="accordion" id="faqAccordion">

                <!-- 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            ¿Los productos son originales?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí. En El Corte Rebelde solo vendemos artículos 100% originales y certificados. Trabajamos exclusivamente con distribuidores oficiales y proveedores autorizados de marcas de lujo.
                        </div>
                    </div>
                </div>

                <!-- 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            ¿Los productos son nuevos o de segunda mano?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Todos nuestros productos son completamente nuevos, de primera mano y en su embalaje original. No vendemos artículos usados ni reacondicionados.
                        </div>
                    </div>
                </div>

                <!-- 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            ¿Qué marcas ofrecéis?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Disponemos de una selección de firmas de lujo como Gucci, Louis Vuitton, Balenciaga, Dior, Prada, Off-White, Burberry y otras marcas premium reconocidas internacionalmente.
                        </div>
                    </div>
                </div>

                <!-- 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            ¿Hacéis envíos a toda España?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí, realizamos envíos a cualquier punto de España. También ofrecemos envío express en determinadas zonas.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                            ¿Realizáis envíos internacionales?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí, enviamos a varios países de la Unión Europea. Para envíos fuera de Europa, puedes consultarnos directamente.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                            ¿Cuánto tarda en llegar mi pedido?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Los envíos dentro de España suelen tardar entre 24 y 72 horas laborables. Los envíos internacionales pueden tardar entre 3 y 7 días.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                            ¿Puedo devolver un producto?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí, aceptamos devoluciones dentro de los primeros 14 días desde la recepción del pedido, siempre que el artículo esté sin usar, con etiquetas y en su embalaje original.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                            ¿Los productos incluyen factura o certificado?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí. Todos los artículos se envían con su factura correspondiente y, cuando la marca lo incluye, con tarjeta de autenticidad o documentación oficial.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                            ¿Tenéis tienda física?
                        </button>
                    </h2>
                    <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Actualmente operamos online, pero estamos trabajando en abrir un showroom privado para clientes que buscan una experiencia más exclusiva.
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <?php include "../src/components/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
