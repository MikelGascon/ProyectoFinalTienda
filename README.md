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

CorteRebelde/
├── public /
    ├──
    ├── index.php           # Página principal
    ├── filtro.php          # Sistema de filtrado
    ├── producto.php        # Detalle de producto
    ├── carrito.php         # Carrito de compras
├── assets/
    ├── css/           # Estilos
    ├── js/            # Scripts
    └── img/           # Imágenes
├── config/            # Configuración
└── includes/          # Componentes reutilizables


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




