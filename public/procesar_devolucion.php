<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud Recibida | Nuestra Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .success-card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            margin-top: 100px;
        }
        .check-icon {
            font-size: 80px;
            color: #198754; /* Verde éxito */
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="success-card">
                    <i class="bi bi-check-circle-fill check-icon"></i>
                    <h1 class="display-6 fw-bold mt-4">¡Solicitud Enviada!</h1>
                    <p class="lead text-muted mb-4">
                        Hemos recibido tu trámite de devolución correctamente. 
                        En breve recibirás un correo con las instrucciones de envío.
                    </p>
                    
                    <div class="bg-light p-3 rounded mb-4 text-start">
                        <small class="text-uppercase fw-bold text-muted d-block mb-1">Resumen del trámite:</small>
                        <ul class="list-unstyled mb-0">
                            <li><strong>Pedido:</strong> <?php echo htmlspecialchars($_POST['pedido'] ?? 'N/A'); ?></li>
                            <li><strong>Estado:</strong> En revisión</li>
                        </ul>
                    </div>

                    <a href="index.php" class="btn btn-primary btn-lg px-5 shadow-sm">
                        Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>