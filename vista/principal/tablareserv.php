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
require_once('../../modelo/reservas.php');
require_once('../../confi/conexion.php');
$database = new Database();
$db = $database->getConnection();
$Reservas= new Reservas($db);
$Reservas = $Reservas->listaresv();

if (!$Reservas || $Reservas->rowCount()==0){
    echo "<br>";
    echo "<div class='alert alert-warning'>No hay reservas registradas </div>";
}else
{
        echo "<h1>Reservas</h1>";
        echo "<link rel='stylesheet' href='../css/style.css'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover table-striped custom-table'>";
        echo "<thead>
                <tr>
                    <th>ID</th>
                    <th>IDUsuario</th>
                    <th>CodEquipo</th>
                    <th>fichausu</th>
                    <th>FechaReserva</th>
                    <th>Acciones</th>

                </tr>
            </thead>";
        echo "<tbody>";
             while($f = $Reservas->fetch(PDO::FETCH_ASSOC)){

               echo "<tr>
                    <td data-label='ID'>".$f["IDReserva"]. "</td>
                    <td data-label='IDUsuario'>".$f["IDUsuario"]. "</td>
                    <td data-label='CodEquipo'>".$f["CodEquipo"]. "</td>
                    <td data-label='fichausu'>".$f["Fichausu"]. "</td>
                    <td data-label='FechaReserva'>".$f["FechaReserva"]. "
                    
                    <td>
            <a href='../../controlador/cancelarreser.php?id=".$f["IDReserva"]."' class='btnn btn-successs btninicio'>Cancelar</a>
            <a href='../../controlador/eliminarequipo.php?codigo=".$f['CodEquipo']."&tipoEquipo=".$f['tipoEquipo']."' class=\"btnn btn-successs btninicio\">Eliminar Equipo</a>
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
            footer a, footer p, footer h2, footer strong {
                color: white !important;
            }
            .btninicio {
                background-color: #5EA617;
                border: none;
                color: white;
                margin-top: 10px;
                margin: 5px;
                padding: 10px 20px;
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

