<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "estudiantes";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['clase_id']) || empty($_POST['contacto'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $clase_id = $_POST['clase_id'];
        $contacto = $_POST['contacto'];

        $sql_update = mysqli_query($conexion, "UPDATE estudiantes SET nombre = '$nombre', clase_id = '$clase_id', contacto = '$contacto' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Estudiante actualizado correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar el estudiante</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: estudiantes.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM estudiantes WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: estudiantes.php");
} else {
    $data = mysqli_fetch_array($sql);
    $id = $data['id'];
    $nombre = $data['nombre'];
    $clase_id = $data['clase_id'];
    $contacto = $data['contacto'];
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Estudiante
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" placeholder="Ingrese el nombre del estudiante">
                        </div>
                        <div class="form-group">
                            <label for="clase_id">Clase</label>
                            <select name="clase_id" id="clase_id" class="form-control">
                                <option value="" disabled>Seleccione una clase</option>
                                <?php
                                $query_clases = mysqli_query($conexion, "SELECT id, nombre FROM clases");
                                while ($clase = mysqli_fetch_assoc($query_clases)) {
                                    $selected = ($clase['id'] == $clase_id) ? 'selected' : '';
                                    echo '<option value="' . $clase['id'] . '" ' . $selected . '>' . $clase['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="contacto">Contacto</label>
                            <input type="text" name="contacto" id="contacto" class="form-control" value="<?php echo $contacto; ?>" placeholder="Ingrese contacto">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="estudiantes.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
