<?php
$pageTitle = "El Corte Rebelde";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";

// Incluir header (top banner + navbar)
include '../src/components/header.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto | Mi Tienda 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <style>
        .product-img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
        }

        .price-tag {
            font-size: 2rem;
            color: #0d6efd;
            font-weight: bold;
        }

        .container{
            position: relative;
            top: 10px;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container">
        <div class="row bg-white p-4 shadow-sm rounded">
            <!-- Columna de Imagen -->
            <div class="col-md-6 mb-4">
                <img src="images.unsplash.com" class="img-fluid product-img" alt="Reloj Inteligente">
            </div>

            <!-- Columna de Detalles -->
            <div class="col-md-6">

                <h1 class="display-5 fw-bold">Reloj Inteligente Pro 2026</h1>
                <div class="mb-3">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-half text-warning"></i>
                    <span class="ms-2 text-muted">(124 reseñas)</span>
                </div>

                <p class="price-tag mb-3">$199.99</p>
                <p class="lead">Experimenta la última tecnología en tu muñeca. Sensor de salud avanzado, batería de 7
                    días y resistencia al agua profesional.</p>

                <hr>

                <!-- Opciones de Compra -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Color:</label>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-dark rounded-circle p-3"></button>
                        <button class="btn btn-outline-primary rounded-circle p-3"></button>
                        <button class="btn btn-outline-secondary rounded-circle p-3"></button>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-3">
                        <input type="number" class="form-control form-control-lg text-center" value="1" min="1">
                    </div>
                    <div class="col-9">
                        <button class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-cart-plus"></i> Añadir al Carrito
                        </button>
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-truck"></i> Envío gratuito a todo el país por compras mayores a $50.
                </div>
            </div>
        </div>

        <!-- Especificaciones Técnicas -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">Especificaciones Detalladas</h3>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Marca</th>
                            <td>TechLife</td>
                        </tr>
                        <tr>
                            <th>Modelo</th>
                            <td>Pro 2026</td>
                        </tr>
                        <tr>
                            <th>Compatibilidad</th>
                            <td>iOS, Android</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>Titanio y Cristal de Zafiro</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   <?php  require "../src/components/footer.php"?>

    <!-- JS de Bootstrap -->
    <script src="cdn.jsdelivr.net"></script>
</body>

</html>