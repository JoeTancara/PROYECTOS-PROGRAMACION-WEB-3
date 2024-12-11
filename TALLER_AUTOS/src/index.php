<?php include_once "includes/header.php";
require "../conexion.php";

$clientes = mysqli_query($conexion, "SELECT * FROM clientes");
$totalClientes = mysqli_num_rows($clientes);

$vehiculos = mysqli_query($conexion, "SELECT * FROM vehiculos");
$totalVehiculos = mysqli_num_rows($vehiculos);

$tiposReparacion = mysqli_query($conexion, "SELECT * FROM tiposreparacion");
$totalTiposReparacion = mysqli_num_rows($tiposReparacion);

$reparaciones = mysqli_query($conexion, "SELECT * FROM reparaciones");
$totalReparaciones = mysqli_num_rows($reparaciones);

// Datos dinámicos para gráficas
$datosReparaciones = [];
$vehiculosReparaciones = mysqli_query($conexion, "SELECT v.matricula AS vehiculo, COUNT(r.id) AS total FROM reparaciones r INNER JOIN vehiculos v ON r.vehIculo_id = v.id GROUP BY v.matricula");
while ($row = mysqli_fetch_assoc($vehiculosReparaciones)) {
    $datosReparaciones['labels'][] = $row['vehiculo'];
    $datosReparaciones['data'][] = $row['total'];
}

$datosClientesVehiculos = [];
$clientesVehiculos = mysqli_query($conexion, "SELECT c.nombre AS cliente, COUNT(v.id) AS total FROM vehiculos v INNER JOIN clientes c ON v.cliente_id = c.id GROUP BY c.nombre");
while ($row = mysqli_fetch_assoc($clientesVehiculos)) {
    $datosClientesVehiculos['labels'][] = $row['cliente'];
    $datosClientesVehiculos['data'][] = $row['total'];
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">PANEL DE ADMINISTRACIÓN DEL TALLER AUTOMOTRIZ</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Clientes -->
    <a class="col-xl-3 col-md-6 mb-4" href="clientes.php">
        <div class="card border-left-info shadow h-100 py-2 bg-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Clientes</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalClientes; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Vehiculos -->
    <a class="col-xl-3 col-md-6 mb-4" href="vehiculos.php">
        <div class="card border-left-success shadow h-100 py-2 bg-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">vehiculos</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalVehiculos; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-car fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Tipos de Reparación -->
    <a class="col-xl-3 col-md-6 mb-4" href="tiposreparacion.php">
        <div class="card border-left-warning shadow h-100 py-2 bg-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Tipos de Reparación</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalTiposReparacion; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cogs fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Reparaciones -->
    <a class="col-xl-3 col-md-6 mb-4" href="reparaciones.php">
        <div class="card border-left-danger shadow h-100 py-2 bg-danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Reparaciones</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalReparaciones; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tools fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

</div>

<!-- Gráficas -->
<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Reparaciones por Vehículo</h6>
            </div>
            <div class="card-body">
                <canvas id="chartReparaciones"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-success text-white">
                <h6 class="m-0 font-weight-bold">Clientes con vehiculos</h6>
            </div>
            <div class="card-body">
                <canvas id="chartClientes"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Listado de Clientes -->
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-info text-white">
        <h6 class="m-0 font-weight-bold">Listado de Clientes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>telefono</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($clientes)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm"><i class="fas fa-edit"></i></a>
                                <a href="eliminar_cliente.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script para gráficas -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxReparaciones = document.getElementById('chartReparaciones');
    const chartReparaciones = new Chart(ctxReparaciones, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($datosReparaciones['labels']); ?>,
            datasets: [{
                label: 'Reparaciones',
                data: <?php echo json_encode($datosReparaciones['data']); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
        }
    });

    const ctxClientes = document.getElementById('chartClientes');
    const chartClientes = new Chart(ctxClientes, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($datosClientesVehiculos['labels']); ?>,
            datasets: [{
                label: 'vehiculos',
                data: <?php echo json_encode($datosClientesVehiculos['data']); ?>,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
        }
    });
</script>

<?php include_once "includes/footer.php"; ?>
