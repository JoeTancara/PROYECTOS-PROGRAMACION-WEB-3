<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "participaciones";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['estudiante_id']) || empty($_POST['actividad_id']) || empty($_POST['fecha'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = $_POST['id'];
        $estudiante_id = $_POST['estudiante_id'];
        $actividad_id = $_POST['actividad_id'];
        $fecha = $_POST['fecha'];

        $sql_update = mysqli_query($conexion, "UPDATE participaciones SET estudiante_id = '$estudiante_id', actividad_id = '$actividad_id', fecha = '$fecha' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Participación actualizada correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la participación</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: participaciones.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM participaciones WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: participaciones.php");
} else {
    $data = mysqli_fetch_array($sql);
    $id = $data['id'];
    $estudiante_id = $data['estudiante_id'];
    $actividad_id = $data['actividad_id'];
    $fecha = $data['fecha'];
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Participación
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="estudiante_id">Estudiante</label>
                            <select name="estudiante_id" id="estudiante_id" class="form-control">
                                <option value="" disabled>Seleccione un estudiante</option>
                                <?php
                                $query_estudiantes = mysqli_query($conexion, "SELECT id, nombre FROM estudiantes");
                                while ($estudiante = mysqli_fetch_assoc($query_estudiantes)) {
                                    $selected = ($estudiante['id'] == $estudiante_id) ? 'selected' : '';
                                    echo '<option value="' . $estudiante['id'] . '" ' . $selected . '>' . $estudiante['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="actividad_id">Actividad</label>
                            <select name="actividad_id" id="actividad_id" class="form-control">
                                <option value="" disabled>Seleccione una actividad</option>
                                <?php
                                $query_actividades = mysqli_query($conexion, "SELECT id, nombre FROM actividades");
                                while ($actividad = mysqli_fetch_assoc($query_actividades)) {
                                    $selected = ($actividad['id'] == $actividad_id) ? 'selected' : '';
                                    echo '<option value="' . $actividad['id'] . '" ' . $selected . '>' . $actividad['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="participaciones.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
