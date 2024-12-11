<?php include_once "includes/header.php";
require "../conexion.php";

$usuarios = mysqli_query($conexion, "SELECT * FROM usuario");
$totalU = mysqli_num_rows($usuarios);

$estudiantes = mysqli_query($conexion, "SELECT * FROM estudiantes");
$totalC = mysqli_num_rows($estudiantes);

$clases = mysqli_query($conexion, "SELECT * FROM clases");
$totalClases = mysqli_num_rows($clases);

$categoria = mysqli_query($conexion, "SELECT * FROM categoriasactividad");
$totalCategoria = mysqli_num_rows($categoria);

$actividades = mysqli_query($conexion, "SELECT * FROM actividades");
$totalActividad = mysqli_num_rows($actividades);

$participaciones = mysqli_query($conexion, "SELECT * FROM participaciones");
$totalParticipaciones = mysqli_num_rows($participaciones);

?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Panel de Administración</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Usuarios -->
    <a class="col-xl-3 col-md-6 mb-4" href="usuarios.php">
        <div class="card border-left-primary shadow h-100 py-2 bg-primary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Usuarios</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalU; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Clases -->
    <a class="col-xl-3 col-md-6 mb-4" href="clases.php">
        <div class="card border-left-info shadow h-100 py-2 bg-info">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Clases</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalClases; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Estudiantes -->
    <a class="col-xl-3 col-md-6 mb-4" href="estudiantes.php">
        <div class="card border-left-success shadow h-100 py-2 bg-success">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Estudiantes</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalC; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Categorías -->
    <a class="col-xl-3 col-md-6 mb-4" href="categoriasactividad.php">
        <div class="card border-left-warning shadow h-100 py-2 bg-warning">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Categorías</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalCategoria; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Actividades -->
    <a class="col-xl-3 col-md-6 mb-4" href="actividades.php">
        <div class="card border-left-danger shadow h-100 py-2 bg-danger">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Actividades</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalActividad; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-running fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Participaciones -->
    <a class="col-xl-3 col-md-6 mb-4" href="participaciones.php">
        <div class="card border-left-secondary shadow h-100 py-2 bg-secondary">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Participaciones</div>
                        <div class="h5 mb-0 font-weight-bold text-white"><?php echo $totalParticipaciones; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

</div>

<?php include_once "includes/footer.php"; ?>
