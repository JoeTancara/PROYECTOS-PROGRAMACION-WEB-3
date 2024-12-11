<?php include_once "includes/header.php";
include "../conexion.php";
$id_user = $_SESSION['idUser'];
$permiso = "categoriasactividad";
$sql = mysqli_query($conexion, "SELECT p.*, d.* FROM permisos p INNER JOIN detalle_permisos d ON p.id = d.id_permiso WHERE d.id_usuario = $id_user AND p.nombre = '$permiso'");
$existe = mysqli_fetch_all($sql);
if (empty($existe) && $id_user != 1) {
    header("Location: permisos.php");
}

if (!empty($_POST)) {
    $alert = "";
    if (empty($_POST['nombre'])) {
        $alert = '<div class="alert alert-danger" role="alert">El campo nombre es obligatorio</div>';
    } else {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        $sql_update = mysqli_query($conexion, "UPDATE categoriasactividad SET nombre = '$nombre' WHERE id = $id");

        if ($sql_update) {
            $alert = '<div class="alert alert-success" role="alert">Categoría actualizada correctamente</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al actualizar la categoría</div>';
        }
    }
}

// Mostrar datos
if (empty($_REQUEST['id'])) {
    header("Location: categorias.php");
}
$id = $_REQUEST['id'];
$sql = mysqli_query($conexion, "SELECT * FROM categoriasactividad WHERE id = $id");
$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
    header("Location: categorias.php");
} else {
    $data = mysqli_fetch_array($sql);
    $id = $data['id'];
    $nombre = $data['nombre'];
}
?>
<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Modificar Categoría
                </div>
                <div class="card-body">
                    <form action="" method="post" autocomplete="off">
                        <?php echo isset($alert) ? $alert : ''; ?>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $nombre; ?>" placeholder="Ingrese Nombre de la Categoría">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar Cambios</button>
                        <a href="categoriasactividad.php" class="btn btn-danger">Atrás</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<?php include_once "includes/footer.php"; ?>
