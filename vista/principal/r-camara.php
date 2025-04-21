<?php
require_once('../../confi/conexion.php');
date_default_timezone_set('America/Bogota');

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Consultar las tabletas disponibles
$query = "SELECT CodEquipo, Camaras FROM Camaras";
$stmt = $db->prepare($query);
$stmt->execute();

$camaras = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        <a class="nav-link px-3" href="../principal/perfil.php">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <form action="../../controlador/reservacont.php" method="POST" class="container">
        <h2 class="titulo text-center"><strong>Reserva de Camaras</strong></h2>
        <div class="row">
            <div class="col-md-6">
            <img src="../img/clcamarita.png" class="img-fluid-1 img-fluid" alt="">
            </div>
            <div class="container mt-5 col-md-6 form1 form-group">

                <label for="FechaReserva">Fecha y Hora de Reserva:</label>
                <input type="datetime-local" class="form-control" name="FechaReserva" id="FechaReserva" 
                value="<?php echo date('Y-m-d\TH:i'); ?>" readonly required>

                <label for="fichausu" class="mr-2">Número de Ficha:</label>
                <input type="text" class="form-control" name="fichausu" id="fichausu" placeholder="Ingrese el número de ficha" required>

                <input type="hidden" name="tipoEquipo" value="camaras">

                <label for="CodEquipo" class="mr-2">¿Qué camara deseas reservar?</label>
                <select name="CodCamara" id="CodCamara" class="form-control" required>
                    <option value="">Seleccione una opción</option>
                    <?php foreach ($camaras as $camaras): ?>
                        <option value="<?php echo $camaras['CodEquipo']; ?>">
                            <?php echo $camaras['Camaras']; ?>
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
                flex-direction: column;
                align-items: center;
            }
            .img-fluid-1 {
                max-width: 300px;
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
        <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
        <h2>Tecno-Sena</h2>
        <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</html>