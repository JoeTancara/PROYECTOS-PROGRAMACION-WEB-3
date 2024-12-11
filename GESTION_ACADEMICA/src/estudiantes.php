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
        $nombre = $_POST['nombre'];
        $clase_id = $_POST['clase_id'];
        $contacto = $_POST['contacto'];

        $query = mysqli_query($conexion, "SELECT * FROM estudiantes WHERE nombre = '$nombre' AND clase_id = '$clase_id'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">El estudiante ya existe en esta clase</div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO estudiantes(nombre, clase_id, contacto) VALUES ('$nombre', '$clase_id', '$contacto')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">Estudiante registrado</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al registrar el estudiante</div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_estudiante"><i class="fas fa-plus"></i></button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Clase</th>
                <th>Contacto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT e.id, e.nombre AS estudiante, c.nombre AS clase, e.contacto 
                                              FROM estudiantes e 
                                              INNER JOIN clases c ON e.clase_id = c.id");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['estudiante']; ?></td>
                        <td><?php echo $data['clase']; ?></td>
                        <td><?php echo $data['contacto']; ?></td>
                        <td>
                            <a href="editar_estudiante.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_estudiante.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="nuevo_estudiante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Estudiante</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" placeholder="Ingrese Nombre del Estudiante" name="nombre" id="nombre" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="clase_id">Clase</label>
                        <select name="clase_id" id="clase_id" class="form-control">
                            <option value="" selected disabled>Seleccione una clase</option>
                            <?php
                            $query_clases = mysqli_query($conexion, "SELECT id, nombre FROM clases");
                            while ($clase = mysqli_fetch_assoc($query_clases)) {
                                echo '<option value="' . $clase['id'] . '">' . $clase['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contacto">Contacto</label>
                        <input type="text" placeholder="Ingrese Contacto" name="contacto" id="contacto" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Estudiante" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
