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
        $vehiculo_id = $_POST['vehiculo_id'];
        $fecha = $_POST['fecha'];
        $costo = $_POST['costo'];
        $descripcion = $_POST['descripcion'];

        $query_insert = mysqli_query($conexion, "INSERT INTO reparaciones(vehículo_id, fecha, costo, descripcion) VALUES ('$vehiculo_id', '$fecha', '$costo', '$descripcion')");
        if ($query_insert) {
            $alert = '<div class="alert alert-success" role="alert">Reparación registrada</div>';
        } else {
            $alert = '<div class="alert alert-danger" role="alert">Error al registrar la reparación</div>';
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nueva_reparacion"><i class="fas fa-plus"></i> AGREGAR REPARACIÓN</button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Vehículo</th>
                <th>Fecha</th>
                <th>Costo</th>
                <th>descripcion</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT r.id, v.matricula AS vehiculo, r.fecha, r.costo, r.descripcion 
                                              FROM reparaciones r 
                                              INNER JOIN vehiculos v ON r.vehiculo_id = v.id");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['vehiculo']; ?></td>
                        <td><?php echo $data['fecha']; ?></td>
                        <td><?php echo $data['costo']; ?></td>
                        <td><?php echo $data['descripcion']; ?></td>
                        <td>
                            <a href="editar_reparacion.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_reparacion.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="nueva_reparacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nueva Reparación</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="vehiculo_id">Vehículo</label>
                        <select name="vehiculo_id" id="vehiculo_id" class="form-control">
                            <option value="" selected disabled>Seleccione un vehículo</option>
                            <?php
                            $query_vehiculos = mysqli_query($conexion, "SELECT id, matricula FROM vehiculos");
                            while ($vehiculo = mysqli_fetch_assoc($query_vehiculos)) {
                                echo '<option value="' . $vehiculo['id'] . '">' . $vehiculo['matricula'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="number" step="0.01" name="costo" id="costo" class="form-control" placeholder="Ingrese el costo" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">descripcion</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingrese la descripcion" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Reparación</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
