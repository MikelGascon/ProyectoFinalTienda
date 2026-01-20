<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devoluciones | Nuestra Tienda de Ropa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        .hero-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .icon-box {
            font-size: 2.5rem;
            color: #0d6efd;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .step-badge {
            width: 35px;
            height: 35px;
            background: #0d6efd;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-right: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php include "../src/components/header.php" ?>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Tramitar Devolución</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                ¿Tu prenda no es lo que esperabas? No te preocupes. Tienes 30 días para realizar tu devolución de forma sencilla.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="form-container">
                        <form action="procesar_devolucion.php" method="POST">
                            <h3 class="mb-4 fw-bold"><span class="step-badge">1</span> Datos del Pedido</h3>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Número de Pedido</label>
                                    <input type="text" class="form-control" placeholder="#ORD-12345" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" placeholder="tu@email.com" required>
                                </div>
                            </div>

                            <h3 class="mb-4 fw-bold"><span class="step-badge">2</span> Motivo de la Devolución</h3>
                            <div class="mb-4">
                                <select class="form-select" required>
                                    <option value="" selected disabled>Selecciona un motivo...</option>
                                    <option value="talla">La talla es pequeña/grande</option>
                                    <option value="defecto">El producto tiene un defecto</option>
                                    <option value="diferente">No es como en la foto</option>
                                    <option value="arrepentido">He cambiado de opinión</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Comentarios adicionales (Opcional)</label>
                                <textarea class="form-control" rows="3" placeholder="Cuéntanos más para ayudarnos a mejorar..."></textarea>
                            </div>

                            <h3 class="mb-4 fw-bold"><span class="step-badge">3</span> Método de Recogida</h3>
                            <div class="row g-3 mb-5">
                                <div class="col-md-6">
                                    <div class="card h-100 p-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metodo" id="domicilio" checked>
                                            <label class="form-check-label fw-bold" for="domicilio">
                                                Recogida a domicilio
                                            </label>
                                            <p class="small text-muted mb-0">Un transportista pasará por tu dirección en 24/48h.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100 p-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metodo" id="punto_pack">
                                            <label class="form-check-label fw-bold" for="punto_pack">
                                                Punto de Entrega
                                            </label>
                                            <p class="small text-muted mb-0">Llévalo a la oficina de correos más cercana.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg shadow-sm">Confirmar Devolución</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">¿Cómo funciona?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-box-seam icon-box mb-3"></i>
                        <h4 class="fw-bold">Prepara el paquete</h4>
                        <p class="text-muted">Introduce la prenda en su embalaje original con las etiquetas puestas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-truck icon-box mb-3"></i>
                        <h4 class="fw-bold">Envío Gratis</h4>
                        <p class="text-muted">Nosotros nos encargamos de los costes de envío en tu primera devolución.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-4 bg-white rounded shadow-sm">
                        <i class="bi bi-cash-stack icon-box mb-3"></i>
                        <h4 class="fw-bold">Reembolso</h4>
                        <p class="text-muted">Recibirás el dinero en el mismo método de pago en un plazo de 5 a 10 días.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-primary text-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h3>99%</h3>
                    <p>Clientes satisfechos</p>
                </div>
                <div class="col-md-4">
                    <h3>24h</h3>
                    <p>Tiempo medio de respuesta</p>
                </div>
                <div class="col-md-4">
                    <h3>30 días</h3>
                    <p>Periodo de devolución</p>
                </div>
            </div>
        </div>
    </section>

    <?php include "../src/components/footer.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>