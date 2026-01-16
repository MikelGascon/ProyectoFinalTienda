-- Nombre de la tabla
/* CREATE DATABASE app_tienda; */

-- Tabla de los usuarios
/*
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    categoriaId VARCHAR(50),
    tipo_ropaId VARCHAR(50),
    precio DECIMAL(10,2),
    color VARCHAR(30),
    tallaId VARCHAR(10),
    marcaId VARCHAR(10)
);

CREATE TABLE marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE categoriaSexo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

CREATE TABLE tipoRopa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);
CREATE TABLE tallaRopa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);
INSERT INTO categoriaSexo (nombre) VALUES ('Hombre'), ('Mujer'), ('Unisex');

INSERT INTO tipoRopa (nombre) VALUES ('Camisetas'), ('Pantalones'), ('Chaquetas'), ('Accesorios'), ('Vestidos');

INSERT INTO marcas (nombre) VALUES ('Gucci'), ('Dior'), ('Moncler'), ('Versace'), ('Louis Vuitton');

-- 4. INSERCIÓN DE PRODUCTOS DE EJEMPLO
-- Nota: Los números en categoriaId, tipo_ropaId y marcaId corresponden a los IDs de arriba
INSERT INTO productos (nombre, categoriaId, tipo_ropaId, marcaId, precio, color) VALUES
('Camiseta Logo Gold', 1, 1, 1, 250.00, 'Negro'),
('Bolso Saddle Mini', 2, 4, 2, 1800.00, 'Azul'),
('Chaqueta Maya Down', 1, 3, 3, 1200.00, 'Azul Marino'),
('Camisa Silk Print', 3, 1, 4, 650.00, 'Multicolor'),
('Cartera Monogram', 3, 4, 5, 450.00, 'Marrón'),
('Pantalón Denim Slim', 1, 2, 1, 490.00, 'Gris'),
('Vestido Noche Dior', 2, 5, 2, 2100.00, 'Rojo'),
('Gafas de Sol Medusa', 3, 4, 4, 280.00, 'Negro');
*/