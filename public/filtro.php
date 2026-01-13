<?php
// --- LÓGICA PHP ---
$filtros_data = [
    'categorias' => ['Hombre', 'Mujer', 'Unisex'],
    'tipos' => ['Camisetas', 'Pantalones', 'Chaquetas', 'Accesorios'],
    'materiales' => ['Algodón', 'Lino', 'Seda', 'Lana'],
    'estampados' => ['Liso', 'Rayas', 'Cuadros', 'Floral'],
    'tallas' => ['XS', 'S', 'M', 'L', 'XL'],
    'colores' => [
        'Blanco' => '#FFFFFF', 'Negro' => '#000000', 'Gris' => '#808080', 
        'Beige' => '#F5F5DC', 'Azul' => '#000080', 'Rojo' => '#FF0000',
        'Verde' => '#556B2F', 'Marrón' => '#8B4513'
    ]
];

// Comprobar si se han enviado filtros
$mostrar_productos = !empty($_GET);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Filtros de Tienda - El Corte Rebelde</title>
    <style>
        :root {
            --marron-claro: #AAA085;
            --marron-oscuro: #8C836A;
            --negro: #000000;
            --gris-medio: #878686;
            --gris-claro: #D9D9D9;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            background-color: #fcfcfc;
        }

        /* Estilo Sidebar */
        .sidebar {
            width: 300px;
            background: #fff;
            padding: 25px;
            height: 100vh;
            border-right: 1px solid var(--gris-claro);
            position: sticky;
            top: 0;
            overflow-y: auto;
        }

        .filter-group { margin-bottom: 20px; }
        
        .filter-group label {
            display: block;
            font-weight: bold;
            font-size: 0.8rem;
            margin-bottom: 8px;
            color: var(--marron-oscuro);
            text-transform: uppercase;
        }

        select, input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--gris-claro);
            border-radius: 4px;
        }

        /* Colores Visuales */
        .color-grid { display: flex; flex-wrap: wrap; gap: 8px; }
        .color-circle {
            width: 25px; height: 25px;
            border-radius: 50%;
            border: 1px solid #ddd;
            cursor: pointer;
            display: inline-block;
        }
        .color-circle input { display: none; }
        .color-circle input:checked + span {
            outline: 2px solid var(--negro);
            outline-offset: 2px;
        }
        .circle-inner { display: block; width: 100%; height: 100%; border-radius: 50%; }

        /* Botón */
        .btn-apply {
            width: 100%;
            padding: 12px;
            background: var(--marron-claro);
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            border-radius: 4px;
        }

        /* Área de Resultados */
        .main-container { flex: 1; padding: 40px; }
        
        .grid-productos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .producto-card {
            background: #fff;
            border: 1px solid #eee;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }

        .placeholder-img {
            background: var(--gris-claro);
            height: 180px;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .no-results {
            color: var(--gris-medio);
            text-align: center;
            margin-top: 100px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <form method="GET">
            <div class="filter-group">
                <label>Categoría</label>
                <select name="categoria">
                    <option value="">Todas</option>
                    <?php foreach($filtros_data['categorias'] as $cat) echo "<option value='$cat'>$cat</option>"; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Tipo</label>
                <select name="tipo">
                    <option value="">Cualquiera</option>
                    <?php foreach($filtros_data['tipos'] as $t) echo "<option value='$t'>$t</option>"; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Colores</label>
                <div class="color-grid">
                    <?php foreach($filtros_data['colores'] as $nombre => $hex): ?>
                        <label class="color-circle">
                            <input type="radio" name="color" value="<?php echo $nombre; ?>">
                            <span class="circle-inner" style="background-color: <?php echo $hex; ?>;" title="<?php echo $nombre; ?>"></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-group">
                <label>Talla</label>
                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                    <?php foreach($filtros_data['tallas'] as $t): ?>
                        <label style="font-size: 0.8rem;"><input type="checkbox" name="tallas[]" value="<?php echo $t; ?>"> <?php echo $t; ?></label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="filter-group">
                <label>Precio Max: <span id="val-p">250</span>€</label>
                <input type="range" name="precio" min="0" max="500" value="250" id="range-p">
            </div>

            <div class="filter-group">
                <label>Material</label>
                <select name="material">
                    <option value="">Cualquiera</option>
                    <?php foreach($filtros_data['materiales'] as $m) echo "<option value='$m'>$m</option>"; ?>
                </select>
            </div>

            <button type="submit" class="btn-apply">APLICAR FILTROS</button>
            <?php if($mostrar_productos): ?>
                <a href="?" style="display:block; text-align:center; margin-top:10px; color:var(--gris-medio); font-size: 0.8rem;">Limpiar</a>
            <?php endif; ?>
        </form>
    </aside>

    <main class="main-container">
        <?php if ($mostrar_productos): ?>
            <div class="grid-productos">
                <?php for($i=1; $i<=6; $i++): ?>
                    <div class="producto-card">
                        <div class="placeholder-img"></div>
                        <div style="font-weight:bold;">Prenda Filtrada #<?php echo $i; ?></div>
                        <div style="color:var(--marron-claro);">35,00€</div>
                    </div>
                <?php endfor; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                Selecciona los filtros a la izquierda y pulsa "Aplicar" para ver los productos disponibles.
            </div>
        <?php endif; ?>
    </main>

    <script>
        // Actualización dinámica del texto del precio
        const range = document.getElementById('range-p');
        const label = document.getElementById('val-p');
        
        range.addEventListener('input', () => {
            label.innerText = range.value;
        });
    </script>
</body>
</html>