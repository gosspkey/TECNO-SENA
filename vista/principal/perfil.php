<?php
session_start(); // Reanuda la sesión

// Si el usuario no ha iniciado sesión, muestra una página completa con estilos
if (!isset($_SESSION['Idusu'])) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css"> 
        <title>TECNO-SENA - Iniciar Sesión</title>
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
            .btn-perfil {
                margin: 10px;
                padding: 8px 16px;
                background-color: #5EA617;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            .btn-perfil:hover {
                background-color: #4a8512;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="../img/SENA-TECNO.png" alt="Logo" width="400px" style="position: relative; left: -20px;" class="img-fluid d-inline-block align-top">
                </a>
            </div>
        </nav>

        <div class="container text-center mt-5">
            <div class="alert alert-danger">No has iniciado sesión. Por favor, ingresa.</div>
            <a href="../iniciosesion.html" class="btn btn-perfil">Iniciar Sesión</a>
        </div>

        <footer class="mt-5 border-top">
            <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
                <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
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
    exit();
}

// Conexión a la base de datos
include_once '../../modelo/usuario.php';
$host = "tecnosena.mysql.database.azure.com";
$db_name = "proyecto";
$user_name = "karen";
$password = "12345678K&";
$ssl_cert = __DIR__. "/confi/DigiCertGlobalRootCA.crt.pem"; // Ruta del certificado

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$db_name;charset=utf8",
        $user_name,
        $password,
        [
            PDO::MYSQL_ATTR_SSL_CA => $ssl_cert, // Ruta al certificado SSL
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, // Opcional: desactiva la verificación del certificado del servidor
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Modo de errores
        ]
    );
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Crear la instancia de la clase Usuario
$usuario = new Usuario($conn);
$usuario->id = $_SESSION['Idusu']; // Obtener el ID desde la sesión

// Obtener los detalles del usuario
$stmt = $usuario->Usuuno();

if ($stmt !== false && $stmt->rowCount() > 0) { // Verificar resultados
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
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
        .btn-perfil {
            margin: 10px;
            padding: 8px 16px;
            background-color: #5EA617;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-perfil:hover {
            background-color: #4a8512;
        }
        .custom-button {
            margin: 10px;
            display: inline-block;
        }
        .btn1{
            margin: 10px;
            border: solid 1px #5EA617;
        }
        
        /* Estilos para mejorar la visualización en pantallas pequeñas */
        .info-perfil {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 100%;
            margin: 0 auto;
        }

        .col-eq {
            width: 100%;
            padding: 10px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }
        .col-eq p {
            margin: 10px;
        }
        
        .colperfil {
                margin: 0;
        }
        
        @media (max-width: 576px) {
            .info-perfil {
                padding: 10px;
            }
            .collapse {
            margin-top: 0.5rem !important; /* Reducir el margen superior */
            }
            .colperfil {
                margin: 0;
                padding: 15px;
            }
            
            .col-eq p {
                font-size: 14px;
                margin-bottom: 8px;
                overflow-wrap: break-word;
            }

            .info-perfil:empty, .colperfil:empty, .col-eq:empty {
            display: none;
            }
            .colperfil {
                padding: 10px;
            }
            
            .colperfil h2 {
                font-size: 20px;
                margin-bottom: 15px;
            }
            
            /* Organizar en formato vertical en móviles */
            .col-eq {
                display: flex;
                flex-direction: column;
            }
        }
    </style>
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

    <div class="container text-center mt-5 d-flex align-items-center justify-content-center">   
        <img src="../img/perfil.png" alt="Perfil" class="img-perfil img-fluid">
        <h1 class="titulo-perfil"> Hola <?php echo htmlspecialchars($data['Nombreusu']) . " " . htmlspecialchars($data['Apellidousu']); ?>!</h1>
    </div>
    <div class="container text-center mt-3">
        <button class="btn btn-perfil" type="button" data-toggle="collapse" data-target="#infoUsuario" aria-expanded="false" aria-controls="infoUsuario">
            Aquí tu información
        </button>
        <div class="collapse mt-3 info-perfil" id="infoUsuario">
            <div class="colperfil text-center justify-content-center">
                <h2>Información del usuario</h2>
                <div class="col-eq justify-content-center">
                    <?php
                    echo "<p>Identificación: " . htmlspecialchars($data['Identificacionusu']) . " " . htmlspecialchars($data['Documentousu']) . "</p>";
                    echo "<p>Teléfono: " . htmlspecialchars($data['Telefonousu']) . "</p>";
                    echo "<p>Correo: " . htmlspecialchars($data['Emailusu']) . "</p>";
                    echo "<p>Ficha: " . htmlspecialchars($data['Fichausu']) . "</p>";
                    echo "<p>Usuario: " . htmlspecialchars($data['Usuario']) . "</p>";
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center mt-3">
        <a href='ajustes.php?id=<?php echo htmlspecialchars($_SESSION['Idusu']); ?>' class='btn btn1'>Actualiza tus datos</a>
        <a href='actuacontrase.php?id=<?php echo htmlspecialchars($_SESSION['Idusu']); ?>' class='btn btn1'>Cambia tu contraseña</a>
        <br>
        <form method="post" action="cierre.php" style="display: inline-block; margin: 10px; border: none; background-color: transparent; box-shadow: none; padding: 0;">
            <button class="btn btnn btn-successs customm-button btninicio" type="submit">Cerrar Sesión</button>
        </form>
    </div>
    
<?php
} else {
    echo "<div class='container text-center mt-5'>";
    echo "<div class='alert alert-warning'>No se encontró información del usuario.</div>";
    echo "</div>";
}
?>
    <footer class="mt-5 border-top">
        <div class="container text-center py-4 col-md-2 footer-container" style="margin-top: 2px;">
            <img class="footer-logo" src="../img/LOGO SENA-TECCNO.png" alt="Logo" width="600px">
            <h2>Tecno-Sena</h2>
            <p>Atención al cliente:<br>Lunes a viernes de 8:00am a 5:00pm</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>