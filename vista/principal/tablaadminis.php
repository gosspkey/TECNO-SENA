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
require_once('../../modelo/administrador.php'); // Verifica que el archivo existe y está bien escrito
require_once('../../confi/conexion.php');

// Crear conexión
$database = new Database();
$db = $database->getConnection();

// ⚠️ Verifica que la clase se llame exactamente así en administrador.php
$Administrador = new Administrador($db); // Usa "Administrador" si esa es la clase (singular)
$adm = $Administrador->listaradmin(); // Corrige nombre de variable

if (!$adm || $adm->rowCount() == 0){
    echo "<br>";
    echo "<div class='alert alert-warning'>No hay administradores registrados. </div>";
} else {
    echo "<h1>Administradores</h1>";
    echo "<link rel='stylesheet' href='../css/style.css'>";
    echo "<table class='custom-table'>";
    echo "<thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo de identificación</th>
                <th>Documento</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
        </thead>";
    
    while ($f = $adm->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$f["Idad"]}</td>
                <td>{$f["Nombread"]}</td>
                <td>{$f["Apellidoad"]}</td>
                <td>{$f["Identificacionad"]}</td>
                <td>{$f["Documentoad"]}</td>
                <td>{$f["Emailad"]}</td>
                <td>{$f["Usuario"]}</td>
                <td data-label='Contraseña'>" . 
                (strlen($f["Contraseña"]) > 10 
                    ? substr($f["Contraseña"], 0, 10) . "..." 
                    : $f["Contraseña"]) . 
                "</td>
                <td>
                    <a href='actualadadmin.php?id={$f["Idad"]}' class='btn btnn btn-successs customm-button btninicio'>Actualizar</a>
                    <br>
                    <a href='borraradmin.php?id={$f["Idad"]}' class='btn btnn btn-successs customm-button btninicio'>Borrar</a>
                </td>
            </tr>";
    }

    echo "</table>";
}
?>


<footer class="mt-5 border-top">
        <style>
            footer {
                background-color: #5EA617;
                color: white;
            }
            footer a, footer p, footer h2, footer strong {
                color: white !important;
            }
            .btninicio {
            background-color: #5EA617;
            border: none;
            color: white;
            margin-top: 10px;
            font-size: 14px;
        }
            nav, footer {
                margin: 0;
                padding: 0;
                height: 100%;
            } 
            h1 {
            color:rgb(78, 137, 20); /* Verde */
            font-weight: bold; /* Opcional: para hacerlo más destacado */
            text-align: center; /* Opcional: para centrar el título */
         }
            @media (max-width: 400px) {
                .button-center {
                    display: flex;
                    flex-direction: column; /* Apila los botones verticalmente */
                    align-items: center; /* Centra los botones horizontalmente */
                }
                .btninicio {
                    width: 200px; /* Establece un ancho uniforme para todos los botones */
                    height: 50px; /* Establece una altura uniforme */
                    text-align: center; /* Centra el texto dentro del botón */
                    display: flex; /* Asegura que el contenido esté centrado */
                    justify-content: center; /* Centra horizontalmente */
                    align-items: center; /* Centra verticalmente */
                }
                .img-fluid-1 {
                    max-width: 250px; /* Ajusta la imagen al 100% del contenedor */
                }
                nav, footer {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                }
                .titulo {
                    margin-left: 5px;
                    margin-right: 5px;
                    text-align: center;
                    margin-top: -15px;
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

