# CorteRebelde

**Tienda de ropa moderna con estilo urbano y rebelde**

![Estado del proyecto](https://img.shields.io/badge/estado-en%20desarrollo-yellow)
![Versión](https://img.shields.io/badge/versión-1.0.0-blue)
![Licencia](https://img.shields.io/badge/licencia-MIT-green)

## Descripción

CorteRebelde es una plataforma de e-commerce diseñada para ofrecer ropa moderna y urbana. El sistema permite navegar por catálogos, filtrar productos por categorías, tallas y precios, y gestionar un carrito de compras intuitivo.

## Características

- Catálogo dinámico de productos
- Sistema de filtros avanzado
- Carrito de compras persistente
- Diseño responsive
- Integración con pasarelas de pago
- Sistema de autenticación de usuarios

## Instalación

# Clonar el repositorio
git clone https://github.com/tu-usuario/CorteRebelde.git

# Navegar al directorio
cd CorteRebelde

# Configurar la base de datos
mysql -u root -p < database/schema.sql

# Configurar credenciales
cp config/config.example.php config/config.php
# Editar config.php con tus datos


## Estructura del Proyecto
```text
CorteRebelde/
├── public /
    ├──
    ├── index.php           # Página principal
    ├── filtro.php          # Sistema de filtrado
    ├── producto.php        # Detalle de producto
    ├── carrito.php         # Carrito de compras
    ├── detalles.php        #Detalles de los productos
    ├──......
├── assets/
    ├── css/           # Estilos
    ├── js/            # Scripts
    └── img/           # Imágenes
├── config/            # Configuración
└── includes/          # Componentes reutilizables
```

## Páginas Principales

### `index.php`
**Página de inicio del sitio**

Muestra el catálogo completo de productos con diseño en flex. Incluye:
- Slider de productos destacados
- Categorías principales (Hombre, Mujer)
- Últimas novedades
- Banner de ofertas

```php
// Carga los productos desde la base de datos
$productos = obtenerProductos();
```

### `filtro.php`
**Sistema de filtrado avanzado**

Permite a los usuarios refinar su búsqueda mediante:
- **Categoría:** Camisetas, pantalones, chaquetas, etc.
- **Precio:** Rangos personalizables
- **Color:** Selector visual de colores
- **Marca:** Filtro por fabricante
```php
// Procesa los filtros seleccionados por el usuario
$resultados = filtrarProductos($_GET['categoria'], $_GET['talla'], $_GET['precio']);
```

### `detalles.php`
**Detalles de los productos**

Permite a los usuarios ver los detalles de cada producto.Incluye:
-**Favoritos:** Botón para añadir a favoritos.
-**Carrito:** Añadir el producto al carrito después de ver sus detalles.
-Los detalles importantes del producto.
-Imagen del producto elegido.
```php
// Selecciona el producto para acceder a los detalles
$producto = $entityManager->find(Producto::class, $id);
if (!$producto) { echo "Producto no encontrado."; exit; }
```


### `carrito.php`
**Sistema de agregar productos al carrito**

Permite ver los productos añadidos al carrito.Incluye:
-**Filtros:** Botón para volver a ver los productos con filtrado avanzado.
-**Metodo de pago:** Botón de finalizar compra que te lleva directamente al metodo de pago.
-**Vaciar carrito:** Metodo que utilizamos para vaciar el carrito completo.
-Un botón con forma de cruz para eleminar prodcto por producto.
```php
// Contador de productos que implementamos desde 0
$carrito = $_SESSION['carrito'] ?? [];
$totalGeneral = 0;
```

### `Metodo_pago.php`
**Sistema para pagar el pedido**

Permite poder pagar las tarjetas de regalo y los pedidos de productos.Inlcuye:
-Precio total del pedido que vas a proceder a pagar.
-Metodos diferentes para pagar: tarjeta de crédito,paypal,transferencia.
-Seleccionando un metodo de pago, accedes para meter los datos.
-**Factura:** Al finalizar la compra se te descarga una factura de toda la compra.
```php
// Código para descargar la factura y volver a la página principal
<?php if ($descargarFactura): ?>
<script>
    (function() {
        const contenido = `<?php echo addslashes($contenidoFactura); ?>`;
        const blob = new Blob([contenido], { type: 'text/plain' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'factura_compra.txt';
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
            setTimeout(() => {
            window.location.href = 'index.php';
        }, 1500);
    })();
</script>
<?php endif; ?>

```

### `nosotros.php`
**Página con información de la empresa**

-Descripción pequeña de nuestra empresa.
-Unos div con una imagen y nuestra historia.
-Información extra.
-**comentarios:** Apartado donde puedes escribir un comentario y dar hasta 5 estrellas.
```php
//Obtener el código que escribe el usuario
$query = $entityManager->createQuery("
SELECT c
    FROM Entity\Comentario c
    WHERE c.fecha = (
        SELECT MAX(c2.fecha)
        FROM Entity\Comentario c2
        WHERE c2.usuario = c.usuario
    )
    ORDER BY c.fecha DESC

");
$comentarios = $query->getResult();
```
### `perfil.php`
**Información sobre el usuario**

Información adicional y personal del propio usuario.Inlcuye:
-Información personal , como nombre completo, dirección del usuario.
-Pedidos que haya hecho por nuestra página web.
-**Tarjeta regalo:** Opción a ver tus tarjetas regalo y también acceder a la página de las tarjetas para comprar una.
-**Favoritos:** Ver la lista de favoritos y acceder a la página de favoritos.
-Configuracción de la página y del perfil, como por ejemplo cambiar de contraseña.
-Opción de cerrar sesión
```php
//Información del usuario
$usuario_id = $_SESSION['usuario_id'] ?? null;
$nombreUsuario = $_SESSION['nombre'] ?? 'Usuario';
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$email = $_SESSION['email'] ?? 'email@example.com';
```





