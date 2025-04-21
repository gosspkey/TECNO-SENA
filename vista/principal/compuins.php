<?php
require_once('../../confi/conexion.php');
date_default_timezone_set('America/Bogota');

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar si el instructor ha iniciado sesión
session_start();
if (!isset($_SESSION['Idins'])) {
    echo "Error: No se ha iniciado sesión o el ID del instructor no está disponible.";
    exit;
}

$Idins = $_SESSION['Idins']; // ID del instructor desde la sesión

// Consultar los portátiles disponibles
$query = "SELECT CodEquipo, Portatil FROM Portatil";
$stmt = $db->prepare($query);
$stmt->execute();
$portatiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" class="img-fluid">
            </a>
        </div>
    </nav>

    <form action="../../controlador/reservacontins.php" method="POST" class="container">
        <h2 class="titulo text-center"><strong>Reserva de Portátil (Instructores)</strong></h2>
        <div class="row">
            <div class="col-md-6">
                <img src="../img/computadorPro.png" class="img-fluid" alt="">
            </div>
            <div class="container mt-5 col-md-6 form1 form-group">
                <input type="hidden" name="Idins" value="<?php echo $Idins; ?>">

                <label for="FechaReserva">Fecha y Hora de Reserva:</label>
                <input type="datetime-local" class="form-control" name="FechaReserva" id="FechaReserva"
                value="<?php echo date('Y-m-d\TH:i'); ?>" readonly required>

                <input type="hidden" name="tipoEquipo" value="portatil">

                <label for="CodPortatil">¿Qué portátil deseas reservar?</label>
                <select name="CodPortatil" id="CodPortatil" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($portatiles as $portatil): ?>
                        <option value="<?php echo $portatil['CodEquipo']; ?>">
                            <?php echo $portatil['Portatil']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </div>    
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-center button-center">

            <div class="button mb-2 mb-md-0">
                <button class="bbtnn btn-successs btninicio btn-perfil" type="submit" onclick="return showAlert()">Reservar</button>
            </div>
            <div class="button">
                <a href="../principal/equipos.html">
                    <button class="btnn btn-successs btninicio" type="button">Cancelar</button>
                </a>
            </div>
        </div>
        <br>
    </form>
</body>

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
                nav, footer {
                    margin: 0;
                    padding: 0;
                    height: 100%;
                }
                @media (max-width: 400px) {
                    .button-center {
                        display: flex;
                        flex-direction: column; /* Apila los botones verticalmente */
                        align-items: center; /* Centra los botones horizontalmente */
                    }
                    .img-fluid-1 {
                        max-width: 300px; /* Ajusta la imagen al 100% del contenedor */
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
                    }
                }
                .btninicio {
                    background-color: #5EA617;
                    border: none;
                    color: white;
                    margin-top: 10px;
                    margin: 5px;
                    padding: 10px 20px;
                    border-radius: 10px;
                }
                .img-fluid-1 {
                    width: 350px;
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
</html>

</html>
