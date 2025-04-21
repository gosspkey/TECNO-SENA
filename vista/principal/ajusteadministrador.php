<?php
    ob_start(); // Inicia el búfer de salida

    require_once '../../confi/conexion.php';
    require_once '../../modelo/administrador.php';
    
    $database = new Database();
    $conn = $database->getConnection();
    $adminObj = new Administrador($conn);
    
    // Verificar si hay un ID para editar
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        // Obtener los datos del administrador
        $stmt = $adminObj->listaradmin();
        $adminData = null;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['Idad'] == $id) {
                $adminData = $row;
                break;
            }
        }
    
        if (!$adminData) {
            echo "Administrador no encontrado.";
            exit();
        }
    }
    
    // Si se envía el formulario, actualizar el administrador
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $adminObj->id = $_POST['id'];
        $adminObj->nombre = $_POST['nombre'];
        $adminObj->apellido = $_POST['apellido'];
        $adminObj->identi = $_POST['identi'];
        $adminObj->documento = $_POST['documento'];
        $adminObj->email = $_POST['correo'];
        $adminObj->usuario = $_POST['usuario'];
    
        $resultado = $adminObj->actualizar();
    
        if ($resultado) {
            header("Location: /vista/principal/perfiladm.php");
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
    <title>Actualizar Administrador - TECNO-SENA</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" class="img-fluid d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/equipos.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/centro_de_ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form method="POST" action="ajusteadministrador.php" class="container">
        <input type="hidden" name="id" value="<?= $adminData['Idad'] ?>">
        <h2 class="titulo text-center"><strong>Actualizar Administrador</strong></h2>
        <div class="row">
            <div class="container mt-5 col-md-6 form-group">
                <label for="nombre" class="mr-2">Nombre(s):</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($adminData['Nombread']) ?>" required>

                <label for="apellido" class="mr-2">Apellidos:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= htmlspecialchars($adminData['Apellidoad']) ?>" required>

                <label for="identi">Identificación:</label>
                <select class="form-control" id="identi" name="identi" required>
                    <option value="C.C" <?= $adminData['Identificacionad'] == "C.C" ? "selected" : "" ?>>C.C</option>
                    <option value="T.I" <?= $adminData['Identificacionad'] == "T.I" ? "selected" : "" ?>>T.I</option>
                    <option value="C.E" <?= $adminData['Identificacionad'] == "C.E" ? "selected" : "" ?>>C.E</option>
                    <option value="P.P.T" <?= $adminData['Identificacionad'] == "P.P.T" ? "selected" : "" ?>>P.P.T</option>
                </select>

                <label for="documento">Número de documento:</label>
                <input type="text" class="form-control" id="documento" name="documento" value="<?= htmlspecialchars($adminData['Documentoad']) ?>" required>

            <div class="container mt-5 col-md-6 form-group">
                <label for="correo">Correo electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($adminData['Emailad']) ?>" required>

                <label for="usuario">Usuario:</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="<?= htmlspecialchars($adminData['Usuario']) ?>" required>

                
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-success custom-button" type="submit">Guardar cambios</button>
        </div>
    </form>

    <footer class="mt-5 border-top">
        <style>
            footer { background-color: #5EA617; color: white; }
            footer a, footer p, footer h2, footer strong { color: white !important; }
        </style>
        <div class="container text-center py-4 col-md-2 footer-container">
            <img class="footer-logo" src="../img/tecno_sena_logo_blanco.PNG" alt="Logo">
            <h2>Tecno-Sena</h2>
            <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php

ob_start(); // Inicia el búfer de salida

require_once('../../modelo/administrador.php');
require_once('../../confi/conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $admin = new Administrador($db);

    $admin->id = $_POST['Idad'];
    $admin->nombre = $_POST['nombre'];
    $admin->apellido = $_POST['apellido'];
    $admin->identi = $_POST['identi'];
    $admin->documento = $_POST['documento'];
    $admin->email = $_POST['correo'];
    $admin->usuario = $_POST['usuario'];

    // Solo encriptamos la contraseña si ha sido cambiada
    if (!empty($_POST['contraseña'])) {
        $admin->contra = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);
    } else {
        // Mantenemos la contraseña existente si no se ha cambiado
        $data = $admin->adminuno();
        $fila = $data->fetch(PDO::FETCH_ASSOC);
        $admin->contra = $fila['Contraseña'];
    }

    if ($admin->actualizar()) {
        echo "Administrador actualizado correctamente.";
    } else {
        echo "Error al actualizar el administrador.";
    }
}

ob_end_flush(); // Envía el contenido del búfer de salida

?>