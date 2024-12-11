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
        $estudiante_id = $_POST['estudiante_id'];
        $actividad_id = $_POST['actividad_id'];
        $fecha = $_POST['fecha'];

        $query = mysqli_query($conexion, "SELECT * FROM participaciones WHERE estudiante_id = '$estudiante_id' AND actividad_id = '$actividad_id' AND fecha = '$fecha'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">La participación ya existe</div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO participaciones(estudiante_id, actividad_id, fecha) VALUES ('$estudiante_id', '$actividad_id', '$fecha')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">Participación registrada</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al registrar la participación</div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nueva_participacion"><i class="fas fa-plus"></i></button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>Actividad</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT p.id, e.nombre AS estudiante, a.nombre AS actividad, p.fecha 
                                              FROM participaciones p 
                                              INNER JOIN estudiantes e ON p.estudiante_id = e.id 
                                              INNER JOIN actividades a ON p.actividad_id = a.id");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['estudiante']; ?></td>
                        <td><?php echo $data['actividad']; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td>
                            <a href="editar_participacion.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_participacion.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="nueva_participacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nueva Participación</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="estudiante_id">Estudiante</label>
                        <select name="estudiante_id" id="estudiante_id" class="form-control">
                            <option value="" selected disabled>Seleccione un estudiante</option>
                            <?php
                            $query_estudiantes = mysqli_query($conexion, "SELECT id, nombre FROM estudiantes");
                            while ($estudiante = mysqli_fetch_assoc($query_estudiantes)) {
                                echo '<option value="' . $estudiante['id'] . '">' . $estudiante['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="actividad_id">Actividad</label>
                        <select name="actividad_id" id="actividad_id" class="form-control">
                            <option value="" selected disabled>Seleccione una actividad</option>
                            <?php
                            $query_actividades = mysqli_query($conexion, "SELECT id, nombre FROM actividades");
                            while ($actividad = mysqli_fetch_assoc($query_actividades)) {
                                echo '<option value="' . $actividad['id'] . '">' . $actividad['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control">
                    </div>
                    <input type="submit" value="Guardar Participación" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
