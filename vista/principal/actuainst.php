<?php
ob_start(); // Inicia el búfer de salida

require_once '../../confi/conexion.php';
require_once '../../modelo/instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructorObj = new Instructores($conn);
$instructorData = null;

// Verificar si hay un ID para editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del usuario
    $stmt = $instructorObj->listarins();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Idins'] == $id) {
            $instructorData = $row;
            break;
        }
    }

    if (!$instructorData) {
        echo "Usuario no encontrado.";
        exit();
    }
}

// Si se envía el formulario, actualizar el instructor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instructorObj->id = $_POST['id'];
    $instructorObj->nombre = $_POST['nombre'];
    $instructorObj->apellido = $_POST['apellido'];
    $instructorObj->identi = $_POST['identi'];
    $instructorObj->documento = $_POST['documento'];
    $instructorObj->email = $_POST['correo'];
    $instructorObj->usuario = $_POST['usuario'];

    $resultado = $instructorObj->actualizarins();

    if ($resultado === true) {
        if (headers_sent()) {
            echo "Error: Los encabezados ya se enviaron. No se puede redirigir.";
            exit();
        }
        header("Location: tablainstu.php");
        exit();
    } else {
        echo $resultado; // Muestra el mensaje de error
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

<form method="POST" action="actuainst.php?id=<?= $instructorData['Idins'] ?>" class="container">
    <input type="hidden" name="id" value="<?= $instructorData['Idins'] ?>">
    <h2 class="titulo text-center"> <strong>Actualizar instructor</strong></h2>

    <div class="row">
        <div class="container mt-5 col-md-6 form1 form-group">
            <label for="nombre" class="mr-2">Nombre(s):</label>
            <input type="text" class="form-control" name="nombre" value="<?= $instructorData['Nombreins'] ?>" required>

            <label for="apellido" class="mr-2">Apellidos:</label>
            <input type="text" class="form-control" name="apellido" value="<?= $instructorData['Apellidoins'] ?>" required>
            
            <label for="identificacion" class="mr-2">Tipo de documento:</label>
            <select name="identi" class="form-control" name="identi" id="identi" value="<?= $instructorData['Identificacionins'] ?>" required>
                <option value="C.C">C.C</option>
                <option value="T.I">T.I</option>
                <option value="C.E">C.E</option>
                <option value="P.P.T">P.P.T</option>
            </select>

            <label for="documento" class="mr-2">Numero de documento:</label>
            <input type="text" class="form-control" name="documento" id="documento" value="<?= $instructorData['Documentoins'] ?>" required>
        </div>

        <div class="container mt-5 col-md-6 form1 form-group">
            <label for="email" class="mr-2">Correo electronico:</label>
            <input type="email" class="form-control" name="correo" id="correo" value="<?= $instructorData['Emailins'] ?>" required>

            <label for="usuario" class="mr-2">Nombre de usuario:</label>
            <input type="text" class="form-control" name="usuario" id="usuario" value="<?= $instructorData['Usuario'] ?>" required>

            </script>
        </div>
    </div>
    <div class="text-center mt-4">
        <button class="btn btnn btn-successs customm-button btninicio" type="submit">Actualizar</button>
    </div>
</form>
</body>
</html>