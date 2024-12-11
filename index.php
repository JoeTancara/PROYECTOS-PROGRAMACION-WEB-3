<?php
session_start();
if (!empty($_SESSION['active'])) {
    header('location: src/');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<div class="alert alert-danger" role="alert">
            Ingrese su usuario y su clave
            </div>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $clave = md5(mysqli_real_escape_string($conexion, $_POST['clave']));
            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE usuario = '$user' AND clave = '$clave' AND estado = 1");
            mysqli_close($conexion);
            $resultado = mysqli_num_rows($query);
            if ($resultado > 0) {
                $dato = mysqli_fetch_array($query);
                $_SESSION['active'] = true;
                $_SESSION['idUser'] = $dato['idusuario'];
                $_SESSION['nombre'] = $dato['nombre'];
                $_SESSION['user'] = $dato['usuario'];
                header('location: src/');
            } else {
                $alert = '<div class="alert alert-danger" role="alert">
                Usuario o Contraseña Incorrecta
                </div>';
                session_destroy();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Iniciar Sesión - Taller Mecánico</title>
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="assets/js/all.min.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(90deg, #2d3436, #1e272e);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }

        .card {
            border: 1px solid #bdc3c7;
            border-radius: 10px;
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3), -5px -5px 15px rgba(255, 255, 255, 0.1);
            background: linear-gradient(145deg, #3a3b3c, #232526);
            color: white;
        }

        .card-header {
            background-color: #e74c3c; /* Color mecánico */
            color: white;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-bottom: 2px solid #c0392b;
        }

        .card-header i {
            font-size: 60px;
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #e74c3c;
            border-color: #c0392b;
            color: #fff;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            border-color: #e74c3c;
        }

        .form-control {
            background: #2c3e50;
            color: white;
            border: 1px solid #34495e;
            border-radius: 5px;
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.5), inset -2px -2px 5px rgba(255, 255, 255, 0.1);
        }

        .form-control:focus {
            background: #34495e;
            color: white;
            outline: none;
            box-shadow: 0px 0px 5px #e74c3c;
        }

        .card-footer {
            background-color: #2c3e50;
            border-top: 2px solid #34495e;
        }
    </style>
</head>

<body>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <i class="fas fa-tools"></i> <!-- Icono mecánico -->
                                    <h3 class="font-weight-light my-4">Iniciar Sesión</h3>
                                </div>
                                <div class="card-body">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label class="small mb-1" for="usuario"><i class="fas fa-user"></i> Usuario</label>
                                            <input class="form-control py-4" id="usuario" name="usuario" type="text" placeholder="Ingrese usuario" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="clave"><i class="fas fa-key"></i> Contraseña</label>
                                            <input class="form-control py-4" id="clave" name="clave" type="password" placeholder="Ingrese Contraseña" required />
                                        </div>
                                        <div class="alert alert-danger text-center d-none" id="alerta" role="alert"></div>
                                        <?php echo isset($alert) ? $alert : ''; ?>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary btn-block" type="submit">Iniciar Sesión</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <small class="text-muted">Taller Mecánico &copy; 2024</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="assets/js/scripts.js"></script>
</body>

</html>
