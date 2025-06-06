-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS supermercado;
USE supermercado;

-- Tabla: Categorías de productos
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- Tabla: Productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_categoria INT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id)
);

-- Tabla: Proveedores
CREATE TABLE IF NOT EXISTS proveedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    contacto VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla: Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100),
    telefono VARCHAR(20)
);

-- Tabla: Ventas
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    id_cliente INT,
    total_venta DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

-- Tabla: Detalle de ventas
CREATE TABLE IF NOT EXISTS detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT,
    id_producto INT,
    cantidad INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES ventas(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);

-- Tabla: Ingresos de stock (proveedores)
CREATE TABLE IF NOT EXISTS ingresos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    id_proveedor INT,
    id_producto INT,
    cantidad INT NOT NULL,
    costo_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id),
    FOREIGN KEY (id_producto) REFERENCES productos(id)
);
