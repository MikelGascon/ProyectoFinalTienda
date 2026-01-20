-- Nombre de la tabla
/* CREATE DATABASE app_tienda; 
USE app_tienda;

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

CREATE TABLE favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- Evita que un usuario guarde el mismo producto dos veces
    UNIQUE KEY usuario_producto (usuario_id, producto_id) 
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
('Vestido corto', 2, 5, 1, 390.00, 'Beige'),
('Chaqueta Dior ',3,3,2,470.00,'Blanco'),
('Llavero',1,4,5,150.00,'Negro'),
('Camiseta Versace',2,1,4,650.00,'Blanco'),
('Pantalones Dior',3,2,2,150.00,'Negro'),
('Chaqueta Moncler',2,3,3,900.00,'Rojo'),
('Vestido Verde',2,5,1,280.00,'Verde'),
('Chaqueta moncler',1,3,3,280.00,'Negro'),
('Sudadera Dior',1,3,2,280.00,'Azul'),
('Bolso gucci',2,5,1,280.00,'Beige'),
('Collar Versace',2,5,1,280.00,'Multicolor');

CREATE TABLE tarjetas_regalo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NULL,
    importe DECIMAL(10,2) NOT NULL,
    mensaje VARCHAR(255) NULL,
    fecha_compra DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

*/