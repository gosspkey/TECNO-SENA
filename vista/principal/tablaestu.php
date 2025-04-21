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
                <img src="../img/SENA-TECNO.png  " alt="Logo" width="400px" style="position: relative; left: -20px;" class="img-fluid d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/admin.html">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a action="cierre.php" class="nav-link px-3" href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br>

<?php
require_once('../../modelo/usuario.php');
require_once('../../confi/conexion.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

$usu = $usuario->listarusu(); // Devuelve el objeto PDOStatement
$usuarios = $usu->fetchAll(PDO::FETCH_ASSOC); // Obtiene todos los registros como un arreglo asociativo

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($usuarios)) {
    echo "<br>";
    echo "<div class='alert alert-warning'>No hay usuarios registrados</div>";
} else {
    echo "<h1 style >Estudiantes</h1>";
    echo "<link rel='stylesheet' href='../css/style.css'>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-responsive table-bordered table-hover table-striped custom-table'>";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo de identificación</th>
                <th>Documento</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Ficha</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
        </thead>";
    echo "<tbody>";
    foreach ($usuarios as $f) {
        echo "<tr>
                <td data-label='ID'>" . $f["Idusu"] . "</td>
                <td data-label='Nombre'>" . $f["Nombreusu"] . "</td>
                <td data-label='Apellido'>" . $f["Apellidousu"] . "</td>
                <td data-label='Tipo de identificación'>" . $f["Identificacionusu"] . "</td>
                <td data-label='Documento'>" . $f["Documentousu"] . "</td>
                <td data-label='Teléfono'>" . $f["Telefonousu"] . "</td>
                <td data-label='Email'>" . $f["Emailusu"] . "</td>
                <td data-label='Ficha'>" . $f["Fichausu"] . "</td>
                <td data-label='Usuario'>" . $f["Usuario"] . "</td>
                <td data-label='Contraseña'>" . 
                (strlen($f["Contraseña"]) > 10 
                    ? substr($f["Contraseña"], 0, 10) . "..." 
                    : $f["Contraseña"]) . 
                "</td>
                <td>
                    <a class='btn btnn btn-successs customm-button btninicio' href='actuadmin.php?id=" . $f["Idusu"] . "' class='custom-button'>Actualizar</a>
                    <a class='btn btnn btn-successs customm-button btninicio' href='borrarusu.php?id=" . $f["Idusu"] . "' class='custom-button'>Borrar</a>
                </td>
            </tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
}
?>
<footer class="mt-5 border-top">
    <style>
        h1 {
            color: #5EA617; /* Verde */
            font-weight: bold; /* Opcional: para hacerlo más destacado */
            text-align: center; /* Opcional: para centrar el título */
        }
        footer {
            background-color: #5EA617;
            color: white;
            margin-bottom: -50px;
        }
        footer a {
            color: white;
        }
        footer p, footer h2, footer strong {
            color: white !important;
        }
        .btninicio {
            background-color: #5EA617;
            border: none;
            color: white;
            margin-top: 10px;
            font-size: 14px;
        }
        .table-responsive {
            overflow-x: auto; /* Habilita el desplazamiento horizontal */
            -webkit-overflow-scrolling: touch; /* Mejora la experiencia en dispositivos táctiles */
        }
        .custom-table {
            width: 100%; /* Asegura que la tabla ocupe el ancho del contenedor */
            table-layout: auto; /* Permite que las columnas se ajusten automáticamente */
        }
        .custom-table th, .custom-table td {
            white-space: nowrap; /* Evita que el texto se divida en varias líneas */
            overflow: hidden; /* Oculta el contenido que exceda el ancho */
            text-overflow: ellipsis; /* Agrega "..." al contenido truncado */
        }
        @media (min-width: 1200px) {
            .custom-table {
                font-size: 1.2rem; /* Aumenta el tamaño del texto en pantallas grandes */
            }
        }
        @media (max-width: 768px) {
            .custom-table {
                font-size: 0.8rem; /* Disminuye el tamaño del texto en pantallas pequeñas */
            }
        }
    </style>
    <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
            <img class="footer-logo"  src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
            <h2>Tecno-Sena</h2>
            <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

