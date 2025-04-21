<?php
session_start();
if (!isset($_SESSION['Idins'])) {
    echo "No has iniciado sesión. Por favor, ingresa.";
    exit;
}
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
                        <a class="nav-link px-3" href="../principal/equipos.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form action="procesarcontins.php" method="POST" class="container">
    <h2 class="titulo text-center mb-4"> <strong>Cambiar Contraseña</strong></h2>
        <div class="row">
            
            <div class="container mt-5 col-md-6 form1 form-group">
                    <label for="usuario" class="mb-2">Contraseña Actual:</label>
                    <input type="password" class="form-control" id="contraactual" name="contraactual" required>
    
                    <label for="contraseña" class="mb-2 mt-3">Contraseña nueva:</label>
                    <input type="password" class="form-control" id="contranueva" name="contranueva" required>

                    <label for="contraseña" class="mb-2 mt-3">Confirma contraseña nueva:</label>
                    <input type="password" class="form-control" id="confirmarcontra" name="confirmarcontra" required>

                    <div class="text-center mt-4">
                        <button  class="btn btnn btn-successs customm-button btninicio" type="submit" style="width: 50%;">Cambiar contraseña</button>
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