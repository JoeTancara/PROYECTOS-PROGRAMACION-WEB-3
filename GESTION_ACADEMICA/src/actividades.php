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
        $nombre = $_POST['nombre'];
        $categoria_id = $_POST['categoria_id'];

        $query = mysqli_query($conexion, "SELECT * FROM actividades WHERE nombre = '$nombre' AND categoria_id = '$categoria_id'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">La actividad ya existe en esta categoría</div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO actividades(nombre, categoria_id) VALUES ('$nombre', '$categoria_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">Actividad registrada</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al registrar la actividad</div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nueva_actividad"><i class="fas fa-plus"></i></button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT a.id, a.nombre AS actividad, c.nombre AS categoria 
                                              FROM actividades a 
                                              INNER JOIN categoriasactividad c ON a.categoria_id = c.id");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['actividad']; ?></td>
                        <td><?php echo $data['categoria']; ?></td>
                        <td>
                            <a href="editar_actividad.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_actividad.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="nueva_actividad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nueva Actividad</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" placeholder="Ingrese Nombre de la Actividad" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-control">
                            <option value="" selected disabled>Seleccione una categoría</option>
                            <?php
                            $query_categorias = mysqli_query($conexion, "SELECT id, nombre FROM categoriasactividad");
                            while ($categoria = mysqli_fetch_assoc($query_categorias)) {
                                echo '<option value="' . $categoria['id'] . '">' . $categoria['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" value="Guardar Actividad" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
