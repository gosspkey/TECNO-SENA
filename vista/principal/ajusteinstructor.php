<?php
ob_start(); // Inicia el búfer de salida

require_once '../../confi/conexion.php';
require_once '../../modelo/instructor.php';

$database = new Database();
$conn = $database->getConnection();
$instructorObj = new Instructores($conn);

// Verificar si hay un ID para editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del instructor
    $stmt = $instructorObj->listarins();
    $instructorData = null;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['Idins'] == $id) {
            $instructorData = $row;
            break;
        }
    }

    if (!$instructorData) {
        echo "Instructor no encontrado.";
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
    
    if ($resultado) {
        header("Location: perfilins.php");
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
                <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" style="position: relative; left: -20px;" class="img-fluid d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/equiposins.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form method="POST" action="ajusteinstructor.php" class="container">
        <input type="hidden" name="id" value="<?= $instructorData['Idins'] ?>">
        <h2 class="titulo text-center"> <strong>Actualizar Instructor</strong></h2>
        <div class="row">
            <div class="container mt-5 col-md-6 form1 form-group">
                <label for="nombre" class="mr-2">Nombre(s):</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $instructorData['Nombreins'] ?>" required>

                <label for="apellido" class="mr-2">Apellidos:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $instructorData['Apellidoins'] ?>" required>

                <label>Identificación:</label>
                <select type="text" class="form-control" id="identi" name="identi" required>
                    <option value="C.C" <?= ($instructorData['Identificacionins'] == 'C.C') ? 'selected' : '' ?>>C.C</option>
                    <option value="C.E" <?= ($instructorData['Identificacionins'] == 'C.E') ? 'selected' : '' ?>>C.E</option>
                    <option value="P.P.T" <?= ($instructorData['Identificacionins'] == 'P.P.T') ? 'selected' : '' ?>>P.P.T</option>
                </select>

                <label for="documento" class="mr-2">Número de documento:</label>
                <input type="text" class="form-control" id="documento" name="documento" value="<?= $instructorData['Documentoins'] ?>" required>

                <label for="correo" class="mr-2">Correo electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?= $instructorData['Emailins'] ?>" required>

                <label>Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?= $instructorData['Usuario'] ?>" required>
            </div> 
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-success custom-button" type="submit">Guardar cambios</button>
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
        </style>
       <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
            <img class="footer-logo" src="../img/tecno sena logo blanco.PNG" alt="Logo">
            <h2>Tecno-Sena</h2>
            <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
ob_start(); // Inicia el búfer de salida

require_once('../../modelo/instructor.php'); 
require_once('../../confi/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $instructor = new Instructores($db);

    // Validación del ID antes de continuar
    if (!isset($_POST['Idins']) || empty($_POST['Idins'])) {
        echo "Error: ID del instructor no proporcionado.";
        exit();
    }

    $instructor->id = $_POST['Idins']; // Cambio de IDUsuario a Idins
    $instructor->nombre = $_POST['nombre'];
    $instructor->apellido = $_POST['apellido'];
    $instructor->identi = $_POST['identi'];
    $instructor->documento = $_POST['documento'];
    $instructor->email = $_POST['correo'];
    $instructor->usuario = $_POST['usuario'];

    // Solo encriptamos la contraseña si ha sido cambiada
    if (!empty($_POST['contraseña'])) {
        $instructor->contra = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    } else {
        // Mantenemos la contraseña existente si no se ha cambiado
        $data = $instructor->idisns();
        $fila = $data->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            $instructor->contra = $fila['Contraseña'];
        } else {
            echo "Error: No se pudo obtener la contraseña actual.";
            exit();
        }
    }

    if ($instructor->actualizarins()) {
        echo "Instructor actualizado correctamente.";
    } else {
        echo "Error al actualizar el instructor: " . implode(" - ", $db->errorInfo());
    }
}

ob_end_flush(); // Envía el contenido del búfer de salida
?>