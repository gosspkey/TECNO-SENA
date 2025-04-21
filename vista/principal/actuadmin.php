<?php

ob_start(); // Inicia el búfer de salida

require_once '../../confi/conexion.php';
require_once '../../modelo/usuario.php';

$database = new Database();
$conn = $database->getConnection();
$usuarioObj = new Usuario($conn);

// Verificar si hay un ID para editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del usuario
    $stmt = $usuarioObj->listarusu();
    $usuarioData = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Idusu'] == $id) {
            $usuarioData = $row;
            break;
        }
    }

    if (!$usuarioData) {
        echo "Usuario no encontrado.";
        exit();
    }
}

// Si se envía el formulario, actualizar el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioObj->id = $_POST['id'];
    $usuarioObj->nombre = $_POST['nombre'];
    $usuarioObj->apellido = $_POST['apellido'];
    $usuarioObj->identi = $_POST['identi'];
    $usuarioObj->documento = $_POST['documento'];
    $usuarioObj->email = $_POST['correo'];
    $usuarioObj->telefono = $_POST['telefono'];
    $usuarioObj->usuario = $_POST['usuario'];
    $usuarioObj->ficha = $_POST['ficha'];
    $usuarioObj->contra = $_POST['contraseña']; // El método ya lo hashea

    $resultado = $usuarioObj->actualizar();

    if ($resultado) {
        header("Location: tablaestu.php");
        exit;
    } else {
        echo "Error al actualizar.";
    }
}

ob_end_flush(); // Envía el contenido del búfer de salida

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> 
    <title>TECNO-SENA</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="admin.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="centro de ayuda.html">Centro de ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<form method="POST" action="actuadmin.php" method="POST" class="container">
    <input type="hidden" name="id" value="<?= $usuarioData['Idusu'] ?>">
    <h2 class="titulo text-center"> <strong>Actualizar Usuario</strong></h2>
    <div class="row">
        <div class="container mt-5 col-md-6 form1 form-group">
        <label for="nombre" class="mr-2">Nombre(s):</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuarioData['Nombreusu'] ?>" required>

        <label for="apellido" class="mr-2">Apellidos:</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $usuarioData['Apellidousu'] ?>" required>

        <label>Identificación:</label>
        <select type="text" class="form-control" id="identi" name="identi" value="<?= $usuarioData['Identificacionusu'] ?>" required>
                <option value="C.C">C.C</option>
                <option value="T.I">T.I</option>
                <option value="C.E">C.E</option>
                <option value="P.P.T">P.P.T
            </option>
        </select>

        <label for="documento" class="mr-2">Numero de documento:</label>
        <input type="text"class="form-control" id="documento" name="documento" value="<?= $usuarioData['Documentousu'] ?>" required>

        <label for="telefono" class="mr-2">Telefono:</label>
        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $usuarioData['Telefonousu'] ?>" required>
    </div>

    <div class="container mt-5 col-md-6 form1 form-group">

        <label for="correo" class="mr-2">Correo electronico:</label>
        <input type="email" class="form-control" id="correo" name="correo" value="<?= $usuarioData['Emailusu'] ?>" required>

        <label for="ficha" class="mr-2">Ficha:</label>
        <input type="text" class="form-control" id="ficha" name="ficha" value="<?= $usuarioData['Fichausu'] ?>" required>

        <label>Usuario:</label>
        <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $usuarioData['Usuario'] ?>" required>

      
    </div>
    <div class="text-center mt-4">
        <button class="btn btnn btn-successs customm-button btninicio" type="submit">Actualizar</button>
    </div>
    <div class="row text-center mt-3 d-flex justify-content-center links-container">
        <div class="formtxt col-12 col-md-4 mb-2">
            <a href="#" class="links d-inline-block text-center">Términos y condiciones</a>
        </div>
    </div>
    </div>

        
</form>

<footer class="mt-5 border-top">
        <style>
            footer {
                background-color: #5EA617;
                color: white;
            }
            footer a {
                color: white;
            }
            footer p, footer h2, footer strong {
                color: white !important;
            }
            .links {
    display: block;
    margin-top: 10px;
    color: #68aa26;
    text-decoration: none;
}
.links:hover {
    background-color: #ddebcf;
    color: #4b8413;
    border-radius: 20px;
    text-decoration: none;
}
            
        </style>
        <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
            <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
            <h2>Tecno-Sena</h2>
            <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
        </div>
        <div class="container d-flex justify-content-around py-3">
            <div class="iconos dire col-md-2">
                <p>
                    <strong>Dirección:</strong>  
                    <br> 
                    #31-42 Calle 15, Bogotá
                </p>
            </div>
            <div class="iconos tel col-md-2">
                <p> 
                    <strong>Telefono:</strong> 
                    <br> 
                    +573012845024
                </p>
            </div>
            <div class="iconos ema col-md-2">
                <p>
                    <strong>Correo:</strong>
                    <br>
                    soportecenigraf2025@gmail.com
                </p>
            </div>
            </div>
            <div class="iconos ema col-md-2">
    </div>
    </footer>
       

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
