<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta Regalo | El Corte Rebelde</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../src/Css/tarjeta_regalo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>

<?php include "../src/components/header.php"; ?>

<section class="hero-section text-center">
    <div class="container">
        <img src="../src/img/logo_rebelde.png" alt="Logo El Corte Rebelde" class="logo-rebelde">
        <h1 class="fw-bold">Tarjetas Regalo</h1>
        <p class="text-muted mx-auto" style="max-width: 700px;">
            El detalle perfecto para quienes viven la moda con actitud.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container" style="max-width: 1000px;">
        <div class="row g-4">

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-bag-heart"></i></div>
                    <h4 class="fw-bold">Tarjeta 25€</h4>
                    <p class="text-muted">Un detalle elegante para sorprender sin excesos.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="25">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-bag-check"></i></div>
                    <h4 class="fw-bold">Tarjeta 50€</h4>
                    <p class="text-muted">Un acierto seguro para amantes del estilo premium.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="50">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-stars"></i></div>
                    <h4 class="fw-bold">Tarjeta 75€</h4>
                    <p class="text-muted">El equilibrio perfecto entre lujo y sorpresa.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="75">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-gem"></i></div>
                    <h4 class="fw-bold">Tarjeta 100€</h4>
                    <p class="text-muted">Un regalo con carácter para ocasiones especiales.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="100">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-trophy"></i></div>
                    <h4 class="fw-bold">Tarjeta 150€</h4>
                    <p class="text-muted">Un gesto de distinción para quienes lo merecen.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="150">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="gift-card">
                    <div class="gift-icon"><i class="bi bi-lightning-charge"></i></div>
                    <h4 class="fw-bold">Tarjeta 200€</h4>
                    <p class="text-muted">El regalo definitivo para los amantes del lujo.</p>

                    <form action="metodo_pago.php" method="POST">
                        <input type="hidden" name="importe" value="200">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control mb-2">
                        <button type="submit" class="btn btn-rebelde w-100">Comprar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-12">
                <div class="gift-card special-card">
                    <div class="gift-icon"><i class="bi bi-pencil-square"></i></div>
                    <h4 class="fw-bold">Tarjeta Personalizada</h4>
                    <p class="text-muted">
                        Define el importe y añade un mensaje único para un regalo inolvidable.
                    </p>

                    <form action="metodo_pago.php" method="POST" class="d-flex gap-3 justify-content-center">
                        <input type="number" name="importe" min="10" max="1000" placeholder="Importe (€)" required class="form-control w-25">
                        <input type="text" name="mensaje" placeholder="Mensaje opcional" class="form-control w-50">
                        <button type="submit" class="btn btn-rebelde">Personalizar</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include "../src/components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>