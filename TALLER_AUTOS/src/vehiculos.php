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
        $matricula = $_POST['matricula'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $cliente_id = $_POST['cliente_id'];

        $query = mysqli_query($conexion, "SELECT * FROM vehiculos WHERE matricula = '$matricula'");
        $result = mysqli_fetch_array($query);

        if ($result > 0) {
            $alert = '<div class="alert alert-danger" role="alert">El vehículo ya existe</div>';
        } else {
            $query_insert = mysqli_query($conexion, "INSERT INTO vehiculos(matricula, marca, modelo, cliente_id) VALUES ('$matricula', '$marca', '$modelo', '$cliente_id')");
            if ($query_insert) {
                $alert = '<div class="alert alert-success" role="alert">Vehículo registrado</div>';
            } else {
                $alert = '<div class="alert alert-danger" role="alert">Error al registrar el vehículo</div>';
            }
        }
    }
    mysqli_close($conexion);
}
?>
<button class="btn btn-primary mb-2" type="button" data-toggle="modal" data-target="#nuevo_vehiculo"><i class="fas fa-plus"></i> AGREGAR VEHICULO</button>
<?php echo isset($alert) ? $alert : ''; ?>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="tbl">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>matricula</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "../conexion.php";

            $query = mysqli_query($conexion, "SELECT v.id, v.matricula, v.marca, v.modelo, c.nombre AS cliente FROM vehiculos v INNER JOIN clientes c ON v.cliente_id = c.id");
            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
            ?>
                    <tr>
                        <td><?php echo $data['id']; ?></td>
                        <td><?php echo $data['matricula']; ?></td>
                        <td><?php echo $data['marca']; ?></td>
                        <td><?php echo $data['modelo']; ?></td>
                        <td><?php echo $data['cliente']; ?></td>
                        <td>
                            <a href="editar_vehiculo.php?id=<?php echo $data['id']; ?>" class="btn btn-success"><i class='fas fa-edit'></i></a>
                            <form action="eliminar_vehiculo.php?id=<?php echo $data['id']; ?>" method="post" class="confirmar d-inline">
                                <button class="btn btn-danger" type="submit"><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
</div>
<div id="nuevo_vehiculo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="my-modal-title">Nuevo Vehículo</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" autocomplete="off">
                    <div class="form-group">
                        <label for="matricula">matricula</label>
                        <input type="text" placeholder="Ingrese matricula del Vehículo" name="matricula" id="matricula" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" placeholder="Ingrese Marca del Vehículo" name="marca" id="marca" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" placeholder="Ingrese Modelo del Vehículo" name="modelo" id="modelo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="cliente_id">Cliente</label>
                        <select name="cliente_id" id="cliente_id" class="form-control">
                            <option value="" selected disabled>Seleccione un cliente</option>
                            <?php
                            $query_clientes = mysqli_query($conexion, "SELECT id, nombre FROM clientes");
                            while ($cliente = mysqli_fetch_assoc($query_clientes)) {
                                echo '<option value="' . $cliente['id'] . '">' . $cliente['nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" value="Guardar Vehículo" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>
