<?php
// 1. CONEXIÓN A LA BASE DE DATOS
$host = "localhost";
$user = "root";
$pass = "root";
$db   = "app_tienda";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 2. CONSULTA SQL CON INNER JOIN Y LEFT JOIN
$sql = "SELECT p.*, c.nombre AS nombre_categoria, t.nombre AS nombre_tipo, m.nombre AS nombre_marca
        FROM productos p
        INNER JOIN categoriaSexo c ON p.categoriaId = c.id
        INNER JOIN tipoRopa t ON p.tipo_ropaId = t.id
        LEFT JOIN marcas m ON p.marcaId = m.id
        WHERE 1=1";

// 3. FILTROS DINÁMICOS
if (!empty($_GET['marca'])) {
    $marca = $conexion->real_escape_string($_GET['marca']);
    $sql .= " AND m.nombre = '$marca'";
}

if (!empty($_GET['categoria'])) {
    $categoria = $conexion->real_escape_string($_GET['categoria']);
    $sql .= " AND c.nombre = '$categoria'";
}

if (!empty($_GET['tipo'])) {
    $tipo = $conexion->real_escape_string($_GET['tipo']);
    $sql .= " AND t.nombre = '$tipo'";
}

if (!empty($_GET['color'])) {
    $color = $conexion->real_escape_string($_GET['color']);
    $sql .= " AND p.color = '$color'";
}

if (!empty($_GET['precio'])) {
    $precio_max = (float)$_GET['precio'];
    $sql .= " AND p.precio <= $precio_max";
}

$resultado = $conexion->query($sql);

$filtros_data = [
    'marcas' => ['Gucci', 'Dior', 'Moncler', 'Versace', 'Louis Vuitton'],
    'categorias' => ['Hombre', 'Mujer', 'Unisex'],
    'tipos' => ['Camisetas', 'Pantalones', 'Chaquetas', 'Accesorios', 'Vestidos'],
    'colores' => [
        'Blanco' => '#FFFFFF', 'Negro' => '#000000', 'Gris' => '#808080', 
        'Beige' => '#F5F5DC', 'Azul' => '#000080', 'Rojo' => '#FF0000',
        'Verde' => '#556B2F', 'Marrón' => '#8B4513'
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Luxury - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-claro: #D9D9D9;
        }

        body { margin: 0; font-family: Arial, sans-serif; display: flex; background-color: #fcfcfc; }

        .sidebar {
            width: 300px; background: #fff; padding: 25px; height: 100vh;
            border-right: 1px solid var(--gris-claro); position: sticky; top: 0; overflow-y: auto;
        }

        .filter-group { margin-bottom: 20px; }
        .filter-group label {
            display: block; font-weight: bold; font-size: 0.75rem;
            margin-bottom: 8px; color: var(--marron-oscuro); text-transform: uppercase;
        }

        select, input[type="range"] { width: 100%; padding: 10px; border-radius: 4px; border: 1px solid var(--gris-claro); }

        .color-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .color-circle { width: 25px; height: 25px; border-radius: 50%; border: 1px solid #ddd; cursor: pointer; position: relative; }
        .color-circle input { display: none; }
        .color-circle input:checked + .inner { outline: 2px solid var(--negro); outline-offset: 2px; }
        .inner { display: block; width: 100%; height: 100%; border-radius: 50%; }

        .btn-apply {
            width: 100%; padding: 14px; background: var(--marron-claro);
            color: white; border: none; cursor: pointer; font-weight: bold; border-radius: 4px;
        }

        .main-container { flex: 1; padding: 40px; }
        .grid-productos { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 30px; }
        
        .producto-card { background: #fff; border: 1px solid #eee; padding: 20px; text-align: center; border-radius: 15px; }
        .prod-img { background: #f5f5f5; height: 220px; margin-bottom: 15px; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #ccc; }
        .marca-tag { color: var(--marron-claro); font-size: 0.7rem; font-weight: 800; text-transform: uppercase; margin-bottom: 5px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <form method="GET">
            <div class="filter-group">
                <label>Marca de Lujo</label>
                <select name="marca">
                    <option value="">Todas las marcas</option>
                    <?php foreach($filtros_data['marcas'] as $m): ?>
                        <option value="<?php echo $m; ?>" <?php echo (isset($_GET['marca']) && $_GET['marca'] == $m) ? 'selected' : ''; ?>><?php echo $m; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Categoría</label>
                <select name="categoria">
                    <option value="">Todas</option>
                    <?php foreach($filtros_data['categorias'] as $cat): ?>
                        <option value="<?php echo $cat; ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat) ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Tipo de Ropa</label>
                <select name="tipo">
                    <option value="">Cualquiera</option>
                    <?php foreach($filtros_data['tipos'] as $t): ?>
                        <option value="<?php echo $t; ?>" <?php echo (isset($_GET['tipo']) && $_GET['tipo'] == $t) ? 'selected' : ''; ?>><?php echo $t; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Colores</label>
                <div class="color-grid">
                    <?php foreach($filtros_data['colores'] as $nombre => $hex): ?>
                        <label class="color-circle">
                            <input type="radio" name="color" value="<?php echo $nombre; ?>" <?php echo (isset($_GET['color']) && $_GET['color'] == $nombre) ? 'checked' : ''; ?>>
                            <span class="inner" style="background-color: <?php echo $hex; ?>;"></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-group">
                <label>Precio Máx: <span id="val-p"><?php echo $_GET['precio'] ?? '2000'; ?></span>€</label>
                <input type="range" name="precio" min="0" max="2000" step="50" value="<?php echo $_GET['precio'] ?? '2000'; ?>" id="range-p">
            </div>

            <button type="submit" class="btn-apply">Aplicar Filtros</button>
            <a href="filtro.php" style="display:block; text-align:center; margin-top:15px; color:#888; font-size:0.75rem; text-decoration:none;">Limpiar</a>
        </form>
    </aside>

    <main class="main-container">
        <div class="grid-productos">
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($prod = $resultado->fetch_assoc()): ?>
                    <div class="producto-card">
                        <div class="prod-img">LUXURY ITEM</div>
                        <div class="marca-tag"><?php echo htmlspecialchars($prod['nombre_marca'] ?? 'General'); ?></div>
                        <div style="font-weight:bold; margin-bottom: 8px;"><?php echo htmlspecialchars($prod['nombre']); ?></div>
                        <div style="color:var(--marron-oscuro); font-weight:bold; font-size: 1.2rem;"><?php echo number_format($prod['precio'], 2); ?>€</div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div style="grid-column: 1 / -1; text-align: center; margin-top: 100px; color: #bbb;">
                    <h3>No se encontraron artículos</h3>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <script>
        const range = document.getElementById('range-p');
        const label = document.getElementById('val-p');
        range.addEventListener('input', () => { label.innerText = range.value; });
    </script>
</body>
</html>