<?php
// public/navbar.php
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/Platarformas/PBI-ORION/public/index.php"><i class='bx bx-bar-chart-alt'></i> Orion BI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/public/index.php"><i class='bx bx-home'></i> Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/productos_stock.php"><i class='bx bx-cube'></i> Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/categorias_productos.php"><i class='bx bx-store'></i> Tienda</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/clientes.php"><i class='bx bx-user'></i> Clientes</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/proveedores.php"><i class='bx bx-buildings'></i> Proveedores</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/ingresos_productos.php"><i class='bx bx-receipt'></i> Facturas</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/src/dashboards/resumen_diario.php"><i class='bx bx-bar-chart'></i> Estadísticas</a></li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#"><i class='bx bx-cog'></i> Configuración</a></li>
        <li class="nav-item"><a class="nav-link" href="/Platarformas/PBI-ORION/public/logout.php"><i class='bx bx-log-out'></i> Salir</a></li>
      </ul>
    </div>
  </div>
</nav> 