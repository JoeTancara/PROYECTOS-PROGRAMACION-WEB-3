<?php
require 'empleados.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>CRUD EN PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <h1>UNIVERSIDAD MAYOR DE SAN ANDRES</h1>
        <h2>FACULTAD DE CIENCIAS PURAS Y NATURALES</h2>
    </header>
    <nav>
        <a href="#">INFORMATICA</a>
    </nav>

    <div class="container">
        <form action="" method="post"  enctype="multipart/form-data">

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Empleado</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <input type="hidden" required name="txtID" value="<?php echo $txtID;?>" placeholder="" id="txtID" require="">
                            <br>

                            <div class="form-group col-md-4">
                                <label for="">Nombre(s):</label>
                                <input type="text" class="form-control" <?php echo (isset($error['Nombre']))?"is-invalid":"";?> required name="txtNombre" value="<?php echo $txtNombre;?>" placeholder="" id="txtNombre" require="">
                                <div class="invalid-feedback">
                                <?php echo (isset($error['Nombre']))?$error['Nombre']:"";?>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Apellido Paterno:</label>
                                <input type="text" class="form-control" required name="txtApellidoP" value="<?php echo $txtApellidoP;?>" placeholder="" id="txtApellidoP" require="">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Apellido Materno:</label>
                                <input type="text" class="form-control" required name="txtApellidoM" value="<?php echo $txtApellidoM;?>" placeholder="" id="txtApellidoM" require="">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Correo:</label>
                                <input type="email" class="form-control" required name="txtCorreo" value="<?php echo $txtCorreo;?>" placeholder="" id="txtCorreo" require="">
                                <br>
                            </div>

                            <div class="form-group col-md-12">        
                                <label for="">Foto:</label>
                                <?php if($txtFoto != "") {?>
                                    <br/>
                                    <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../Img/<?php echo $txtFoto; ?>" >
                                    <br/>
                                    <br/>
                                <?php }?>
                                <input type="file" accept="image/*" name="txtFoto" value="<?php echo $txtFoto;?>" placeholder="" id="txtFoto" require="">
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button value="btnAgregar" <?php echo $accionAgregar; ?> class="btn btn-success" type="submit" name="accion">AGREGAR</button>
                        <button value="btnModificar" <?php echo $accionModificar; ?> class="btn btn-warning" type="submit" name="accion">MODIFICAR</button>
                        <button value="btnEliminar" onClick="return Confirmar('¿Realmente deseas borrar?');" <?php echo $accionEliminar; ?> class="btn btn-danger" type="submit" name="accion">ELIMINAR</button>
                        <button value="btnCancelar" <?php echo $accionCancelar; ?> class="btnspo btn-primary" type="submit" name="accion">CANCELAR</button>
                    </div>
                </div>
            </div>
        </div>
     <br><br> 
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Agregar Registro +
        </button>
    <br><br>
        </form>

        <div class="row">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>FOTO</th>
                        <th>NOMBRE COMPLETO</th>
                        <th>CORREO</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <?php foreach($listaEmpleados as $empleado){?>
                    <tr>
                        <td><img class="img-thumbnail" width="100px" src="../Img/<?php echo $empleado['Foto']; ?>" alt=""></td>
                        <td><?php echo $empleado['ApellidoP']; ?> <?php echo $empleado['ApellidoM']; ?> <?php echo $empleado['Nombre']; ?></td>
                        <td><?php echo $empleado['Correo']; ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="txtID" value="<?php echo $empleado['id']; ?>">
                                <input type="hidden" name="txtNombre" value="<?php echo $empleado['Nombre']; ?>">
                                <input type="hidden" name="txtApellidoP" value="<?php echo $empleado['ApellidoP']; ?>">
                                <input type="hidden" name="txtApellidoM" value="<?php echo $empleado['ApellidoM']; ?>">
                                <input type="hidden" name="txtCorreo" value="<?php echo $empleado['Correo']; ?>">



                                <input type="submit" value="SELECCIONAR" name="accion" class="btn btn-success">
                                <button value="btnEliminar" onClick="return Confirmar('¿Realmente deseas borrar?');" type="submit" name="accion" class="btn btn-danger">ELIMINAR</button>
                            </form>                       
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    <?php if($mostrarModal) {?>
        <script>
                $('#exampleModal').modal('show');
        </script>
    <?php }?>
    <script>
        function Confirmar(Mensaje){
            return (confirm(Mensaje))?true:false;
        }
    </script>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Sitio Web JoeDev - Joe Tancara</p>
    </footer>
</body>
</html>
