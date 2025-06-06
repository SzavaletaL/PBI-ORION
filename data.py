import mysql.connector
from faker import Faker
import random
from datetime import datetime, timedelta
from decimal import Decimal

# Configuración de la conexión a la base de datos
config = {
    'user': 'luissalas',
    'password': 'luissalas2025',
    'host': 'dataepis.uandina.pe',
    'port': 49206,
    'database': 'supermercado'
}

# Inicializar Faker con localización en español
fake = Faker('es_ES')

# Listas para almacenar IDs generados
categoria_ids = []
proveedor_ids = []
cliente_ids = []
producto_ids = []
venta_ids = []

try:
    # Establecer conexión con la base de datos
    conn = mysql.connector.connect(**config)
    cursor = conn.cursor()

    # Crear categorías (10 registros)
    for _ in range(10):
        nombre = fake.unique.word().capitalize()
        cursor.execute("INSERT INTO categorias (nombre) VALUES (%s)", (nombre,))
        categoria_ids.append(cursor.lastrowid)
    conn.commit()

    # Crear proveedores (15 registros)
    for _ in range(15):
        nombre = fake.unique.company()
        contacto = fake.name()
        telefono = fake.phone_number()
        cursor.execute(
            "INSERT INTO proveedores (nombre, contacto, telefono) VALUES (%s, %s, %s)",
            (nombre, contacto, telefono)
        )
        proveedor_ids.append(cursor.lastrowid)
    conn.commit()

    # Crear clientes (100 registros)
    for _ in range(100):
        nombre = fake.name()
        correo = fake.email()
        telefono = fake.phone_number()
        cursor.execute(
            "INSERT INTO clientes (nombre, correo, telefono) VALUES (%s, %s, %s)",
            (nombre, correo, telefono)
        )
        cliente_ids.append(cursor.lastrowid)
    conn.commit()

    # Crear productos (200 registros)
    for _ in range(200):
        nombre = fake.unique.bs().title()  # Business terms como nombres de productos
        id_categoria = random.choice(categoria_ids)
        precio = round(random.uniform(1.0, 500.0), 2)
        stock = random.randint(0, 100)
        cursor.execute(
            "INSERT INTO productos (nombre, id_categoria, precio, stock) VALUES (%s, %s, %s, %s)",
            (nombre, id_categoria, precio, stock)
        )
        producto_ids.append(cursor.lastrowid)
    conn.commit()

    # Crear ingresos de stock (300 registros)
    for _ in range(300):
        fecha = fake.date_between(start_date='-1y', end_date='today')
        id_proveedor = random.choice(proveedor_ids)
        id_producto = random.choice(producto_ids)
        cantidad = random.randint(10, 200)
        # Costo unitario entre 50-90% del precio del producto
        cursor.execute("SELECT precio FROM productos WHERE id = %s", (id_producto,))
        precio_producto = cursor.fetchone()[0]
        factor = Decimal(str(random.uniform(0.5, 0.9)))
        costo_unitario = round(precio_producto * factor, 2)        
        cursor.execute(
            "INSERT INTO ingresos (fecha, id_proveedor, id_producto, cantidad, costo_unitario) VALUES (%s, %s, %s, %s, %s)",
            (fecha, id_proveedor, id_producto, cantidad, costo_unitario)
        )
    conn.commit()

    # Crear ventas (500 registros)
    for _ in range(500):
        fecha = fake.date_between(start_date='-1y', end_date='today')
        id_cliente = random.choice(cliente_ids)
        # Total de venta temporal (se actualizará después)
        cursor.execute(
            "INSERT INTO ventas (fecha, id_cliente, total_venta) VALUES (%s, %s, 0)",
            (fecha, id_cliente)
        )
        venta_id = cursor.lastrowid
        venta_ids.append(venta_id)
        
        # Crear detalles de venta (1-5 productos por venta)
        total_venta = 0
        productos_venta = random.sample(producto_ids, k=random.randint(1, 5))
        
        for producto_id in productos_venta:
            cursor.execute("SELECT precio FROM productos WHERE id = %s", (producto_id,))
            precio = cursor.fetchone()[0]
            cantidad = random.randint(1, 10)
            subtotal = round(precio * cantidad, 2)
            total_venta += subtotal
            
            cursor.execute(
                "INSERT INTO detalle_venta (id_venta, id_producto, cantidad, subtotal) VALUES (%s, %s, %s, %s)",
                (venta_id, producto_id, cantidad, subtotal)
            )
        
        # Actualizar el total de la venta
        cursor.execute(
            "UPDATE ventas SET total_venta = %s WHERE id = %s",
            (round(total_venta, 2), venta_id)
        )
    conn.commit()

    print("¡Datos generados exitosamente!")

except mysql.connector.Error as err:
    print(f"Error de MySQL: {err}")
    if 'conn' in locals() and conn.is_connected():
        conn.rollback()
finally:
    # Cerrar conexiones
    if 'cursor' in locals() and cursor:
        cursor.close()
    if 'conn' in locals() and conn.is_connected():
        conn.close()