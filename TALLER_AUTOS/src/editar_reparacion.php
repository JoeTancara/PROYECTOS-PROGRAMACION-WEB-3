<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "reparaciones";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['vehiculo_id']) || empty($_POST['fecha']) || empty($_POST['costo']) || empty($_POST['descripcion'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = $_POST['id'];
        $vehiculo_id = $_POST['vehiculo_id'];
        $fecha = $_POST['fecha'];
        $costo = $_POST['costo'];
        $descripcion = $_POST['descripcion'];

        $sql_update = mysqli_query($conexion, "UPDATE reparaciones SET vehículo_id = '$vehiculo_id', fecha = '$fecha', costo = '$costo', descripcion = '$descripcion' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Reparación actualizada correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la reparación</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: reparaciones.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM reparaciones WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: reparaciones.php");
} else {
    $data = mysqli_fetch_array($sql);
    $vehiculo_id = $data['vehículo_id'];
    $fecha = $data['fecha'];
    $costo = $data['costo'];
    $descripcion = $data['descripcion'];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Reparación
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="vehiculo_id">Vehículo</label>
                            <select name="vehiculo_id" id="vehiculo_id" class="form-control">
                                <option value="" disabled>Seleccione un vehículo</option>
                                <?php
                                $query_vehiculos = mysqli_query($conexion, "SELECT id, matricula FROM vehiculos");
                                while ($vehiculo = mysqli_fetch_assoc($query_vehiculos)) {
                                    $selected = ($vehiculo['id'] == $vehiculo_id) ? 'selected' : '';
                                    echo '<option value="' . $vehiculo['id'] . '" ' . $selected . '>' . $vehiculo['matricula'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $fecha; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="costo">Costo</label>
                            <input type="number" step="0.01" name="costo" id="costo" class="form-control" value="<?php echo $costo; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">descripcion</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" required><?php echo $descripcion; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="reparaciones.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
