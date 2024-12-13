<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD con Modales</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">CRUD </h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalCrear">Nuevo Usuario</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conexion.php';
            $query = "SELECT * FROM usuarios";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['nombre']}</td>
                    <td>{$row['correo']}</td>
                    <td>{$row['telefono']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditar{$row['id']}'>Editar</button>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalEliminar{$row['id']}'>Eliminar</button>
                    </td>
                </tr>";

                // Modal para editar
                echo "
                <div class='modal fade' id='modalEditar{$row['id']}' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form action='scripts/actualizar.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Editar Usuario</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='mb-3'>
                                        <label>Nombre:</label>
                                        <input type='text' name='nombre' class='form-control' value='{$row['nombre']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label>Correo:</label>
                                        <input type='email' name='correo' class='form-control' value='{$row['correo']}' required>
                                    </div>
                                    <div class='mb-3'>
                                        <label>Teléfono:</label>
                                        <input type='text' name='telefono' class='form-control' value='{$row['telefono']}' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' class='btn btn-warning'>Guardar cambios</button>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";

                // Modal para eliminar
                echo "
                <div class='modal fade' id='modalEliminar{$row['id']}' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form action='scripts/eliminar.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Eliminar Usuario</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";
            }
            ?>
        </tbody>
    </table>
</div>
<div class="container mt-5">
    <h2 class="text-center">Gestión de Asistencias</h2>
    <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalCrearAsistencia">Registrar Asistencia</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'conexion.php';
            $query = "SELECT asistencias.id, usuarios.nombre AS usuario, asistencias.fecha, asistencias.estado 
                      FROM asistencias 
                      INNER JOIN usuarios ON asistencias.usuario_id = usuarios.id";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['usuario']}</td>
                    <td>{$row['fecha']}</td>
                    <td>{$row['estado']}</td>
                    <td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#modalEditarAsistencia{$row['id']}'>Editar</button>
                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalEliminarAsistencia{$row['id']}'>Eliminar</button>
                    </td>
                </tr>";

                // Modal para editar asistencia
                echo "
                <div class='modal fade' id='modalEditarAsistencia{$row['id']}' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form action='scripts/actualizar_asistencia.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Editar Asistencia</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <div class='mb-3'>
                                        <label>Estado:</label>
                                        <select name='estado' class='form-control'>
                                            <option value='Presente' " . ($row['estado'] == 'Presente' ? 'selected' : '') . ">Presente</option>
                                            <option value='Ausente' " . ($row['estado'] == 'Ausente' ? 'selected' : '') . ">Ausente</option>
                                        </select>
                                    </div>
                                    <div class='mb-3'>
                                        <label>Fecha:</label>
                                        <input type='date' name='fecha' class='form-control' value='{$row['fecha']}' required>
                                    </div>
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' class='btn btn-warning'>Guardar cambios</button>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";

                // Modal para eliminar asistencia
                echo "
                <div class='modal fade' id='modalEliminarAsistencia{$row['id']}' tabindex='-1'>
                    <div class='modal-dialog'>
                        <form action='scripts/eliminar_asistencia.php' method='POST'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title'>Eliminar Asistencia</h5>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                </div>
                                <div class='modal-body'>
                                    <p>¿Estás seguro de que deseas eliminar este registro de asistencia?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' class='btn btn-danger'>Eliminar</button>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal para crear asistencia -->
<div class="modal fade" id="modalCrearAsistencia" tabindex="-1">
    <div class="modal-dialog">
        <form action="scripts/crear_asistencia.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Usuario:</label>
                        <select name="usuario_id" class="form-control" required>
                            <option value="">Seleccione un usuario</option>
                            <?php
                            $usuariosQuery = "SELECT * FROM usuarios";
                            $usuariosResult = $conn->query($usuariosQuery);
                            while ($usuario = $usuariosResult->fetch_assoc()) {
                                echo "<option value='{$usuario['id']}'>{$usuario['nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Fecha:</label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Estado:</label>
                        <select name="estado" class="form-control" required>
                            <option value="Presente">Presente</option>
                            <option value="Ausente">Ausente</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal para crear -->
<div class="modal fade" id="modalCrear" tabindex="-1">
    <div class="modal-dialog">
        <form action="scripts/crear.php" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Correo:</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
