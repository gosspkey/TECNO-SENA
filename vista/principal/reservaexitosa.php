<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>TECNO-SENA</title>
    <style>
        footer {
            background-color: #5EA617;
            color: white;
            margin-bottom: 0 !important;
        }
        footer a {
            color: white;
        }
        footer p, footer h2, footer strong {
            color: white !important;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .content {
            background-color: transparent !important;
        }
        .container1 {
            background-color: transparent !important;
        }
        form {
            background-color: transparent !important;
            box-shadow:none !important;
            border-radius: 0;
            text-align: center;
            margin: 0 auto;
        }
        h1{
            color: #4b8413;
        }
        .coont1 {
            color:rgb(39, 70, 8);
            font-size: 17px;
        }
        .cont-btn {
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
    <script>
        // Contador regresivo
        let tiempoInicial = 600; // 10 minutos en segundos
        let tiempoRestante = localStorage.getItem('reservaActual') === "<?php echo $_GET['id'] ?? ''; ?>" 
            ? parseInt(localStorage.getItem('tiempoRestante')) 
            : tiempoInicial; 

        localStorage.setItem('reservaActual', "<?php echo $_GET['id'] ?? ''; ?>"); // Guardar ID de reserva

        function iniciarContador() {
            const contador = document.getElementById('contador');

            const intervalo = setInterval(() => {
                if (tiempoRestante <= 0) {
                    clearInterval(intervalo);
                    contador.innerHTML = "El tiempo ha terminado.";
                    localStorage.removeItem('tiempoRestante');
                } else {
                    let minutos = Math.floor(tiempoRestante / 60);
                    let segundos = tiempoRestante % 60;
                    contador.innerHTML = `Tiempo restante: ${minutos} min ${segundos} seg`;

                    tiempoRestante--;  
                    localStorage.setItem('tiempoRestante', tiempoRestante);
                }
            }, 1000);
        }

        window.onload = iniciarContador;
    </script>
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/SENA-TECNO.png" alt="Logo" width="300px" style="position: relative; left: -20px;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/equipos.html">inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="../principal/centro de ayuda.html">Ayuda</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
try {
    require_once('../../confi/conexion.php');
   
    // Verificar si se recibió el ID de la reserva
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "<div class='alert alert-danger'>Error: ID de reserva inválido o no proporcionado.</div>";
        exit();
    }
    $idReserva = intval($_GET['id']);

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Error en la conexión: " . $e->getMessage() . "</div>";
    $idReserva = "";
}
?>
<div class="content">
    <div class="container1 text-center mt-5">
        <h1>Reserva realizada</h1>
        <p>Tu reserva ha sido registrada correctamente, acercate a la area de audiovisuales para retirar tu equipo.</p>
        <p id="contador" class="coont1 font-weight-bold"></p>
        <form action="../../controlador/cancelarusuario.php" method="GET">
            <input type="hidden" name="id" value="<?php echo isset($idReserva) ? $idReserva : ''; ?>">
            <button type="submit" class="btn cont-btn btn-danger mt-3">Cancelar Reserva</button>
        </form>
    </div>
</div>

<footer class="mt-5 border-top">
    <div class="container text-center py-4">
        <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
        <h2>Tecno-Sena</h2>
        <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
    </div>
    <div class="container d-flex justify-content-around py-3">
        <div class="iconos dire col-md-3">
            <p>
                <strong>Dirección:</strong>  
                <br>
                #31-42 Calle 15, Bogotá
            </p>
        </div>
        <div class="iconos tel col-md-3">
            <p>
                <strong>Telefono:</strong>
                <br>
                +573012845024
            </p>
        </div>
        <div class="iconos ema col-md-3">
            <p>
                <strong>Correo:</strong>
                <br>
                soportecenigraf2025@gmail.com
            </p>
        </div>
    </div>
</footer>

<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
