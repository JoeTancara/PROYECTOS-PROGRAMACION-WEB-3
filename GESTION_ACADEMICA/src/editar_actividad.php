<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "actividades";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre']) || empty($_POST['categoria_id'])) {
        $alert = '<div class="alert alert-danger" role="alert">Todos los campos son obligatorios</div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria_id = $_POST['categoria_id'];

        $sql_update = mysqli_query($conexion, "UPDATE actividades SET nombre = '$nombre', categoria_id = '$categoria_id' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Actividad actualizada correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la actividad</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: actividades.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM actividades WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: actividades.php");
} else {
    $data = mysqli_fetch_array($sql);
    $id = $data['id'];
    $nombre = $data['nombre'];
    $categoria_id = $data['categoria_id'];
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Actividad
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" placeholder="Ingrese el nombre de la actividad">
                        </div>
                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select name="categoria_id" id="categoria_id" class="form-control">
                                <option value="" disabled>Seleccione una categoría</option>
                                <?php
                                $query_categorias = mysqli_query($conexion, "SELECT id, nombre FROM categoriasactividad");
                                while ($categoria = mysqli_fetch_assoc($query_categorias)) {
                                    $selected = ($categoria['id'] == $categoria_id) ? 'selected' : '';
                                    echo '<option value="' . $categoria['id'] . '" ' . $selected . '>' . $categoria['nombre'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="actividades.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
