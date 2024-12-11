<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "vehiculos";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['matricula']) || empty($_POST['marca']) || empty($_POST['modelo']) || empty($_POST['cliente_id'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = $_POST['id'];
        $matricula = $_POST['matricula'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $cliente_id = $_POST['cliente_id'];

        $sql_update = mysqli_query($conexion, "UPDATE vehiculos SET matricula = '$matricula', marca = '$marca', modelo = '$modelo', cliente_id = '$cliente_id' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Vehículo actualizado correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el vehículo</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: vehiculos.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM vehiculos WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: vehiculos.php");
} else {
    $data = mysqli_fetch_array($sql);
    $id = $data['id'];
    $matricula = $data['matricula'];
    $marca = $data['marca'];
    $modelo = $data['modelo'];
    $cliente_id = $data['cliente_id'];
}
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Vehículo
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="matricula">matricula</label>
                            <input type="text" name="matricula" id="matricula" class="form-control" value="<?php echo $matricula; ?>" placeholder="Ingrese matricula del Vehículo" required>
                        </div>
                        <div class="form-group">
                            <label for="marca">Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control" value="<?php echo $marca; ?>" placeholder="Ingrese Marca del Vehículo" required>
                        </div>
                        <div class="form-group">
                            <label for="modelo">Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control" value="<?php echo $modelo; ?>" placeholder="Ingrese Modelo del Vehículo" required>
                        </div>
                        <div class="form-group">
                            <label for="cliente_id">Cliente</label>
                            <select name="cliente_id" id="cliente_id" class="form-control">
                                <option value="" disabled>Seleccione un cliente</option>
                                <?php
                                $query_clientes = mysqli_query($conexion, "SELECT id, nombre FROM clientes");
                                while ($cliente = mysqli_fetch_assoc($query_clientes)) {
                                    $selected = ($cliente['id'] == $cliente_id) ? 'selected' : '';
                                    echo '<option value="' . $cliente['id'] . '" ' . $selected . '>' . $cliente['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="vehiculos.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<?php include_once "includes/footer.php"; ?>
