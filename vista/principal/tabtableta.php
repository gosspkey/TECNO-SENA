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
require_once('../../modelo/tabletas.php');
require_once('../../confi/conexion.php');
$database = new Database();
$db = $database->getConnection();
$tableta= new Tabletas($db);
$tableta = $tableta->listartbl();

if (!$tableta || $tableta->rowCount()==0){
    echo "<br>";
    echo "<div class='alert alert-warning'>No hay equipos registrados </div>";
}else
{


        echo "<h1>Tabletas</h1>";
        echo "<link rel='stylesheet' href='../css/style.css'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover table-striped custom-table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>Placa</th>
                    <th>Descripcion</th>
                    <th>Tableta</th>

                </tr>
            </thead>";
        echo "<tbody>";
             while($f = $tableta->fetch(PDO::FETCH_ASSOC)){

               echo "<tr>
                    <td data-label='ID'>".$f["CodEquipo"]. "</td>
                    <td data-label='Placa'>".$f["Placa"]. "</td>
                    <td data-label='Descripcion'>".$f["Descripcion"]. "</td>
                    <td data-label='Tableta'>".$f["Tableta"]. "</td>
                    </td>


            </tr>";

             }
        echo "</tbody>";
            echo "</table>";
}
        
?>

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
        h1 {
            color:rgb(78, 137, 20); /* Verde */
            font-weight: bold; /* Opcional: para hacerlo más destacado */
            text-align: center; /* Opcional: para centrar el título */
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

