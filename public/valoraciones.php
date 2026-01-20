<?php
$pageTitle = "Valoraciones de usuarios";
$bannerText = "20% OFF EN COLECCIÓN DE INVIERNO";
$showBanner = true;
$basePath = "../src";

// Header
include '../src/components/header.php';

// 1. CONEXIÓN A LA BASE DE DATOS
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "app_tienda";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 2. CONSULTA: comentarios + usuarios
$result = $conexion->query("
    SELECT c.texto, c.fecha, c.rating, u.nombre
    FROM comentarios c
    JOIN usuarios u ON c.id_usuario = u.id
    ORDER BY c.fecha DESC
");
?>

<div class="lista-valoraciones">
    <h3>Valoraciones de usuarios</h3>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="valoracion-item">

            <!-- ESTRELLAS DE VALORACIÓN -->
            <div class="estrellas">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span class="estrella <?php echo $i <= $row['rating'] ? 'activa' : ''; ?>">★</span>
                <?php endfor; ?>
            </div>

            <!-- 👤 NOMBRE DEL USUARIO -->
            <p class="usuario"><?php echo htmlspecialchars($row['nombre']); ?></p>

            <!-- 💬 TEXTO DEL COMENTARIO -->
            <p class="texto"><?php echo htmlspecialchars($row['texto']); ?></p>

            <!-- 📅 FECHA -->
            <span class="fecha"><?php echo $row['fecha']; ?></span>

        </div>
    <?php endwhile; ?>
</div>

<?php include "../src/components/footer.php"; ?>
