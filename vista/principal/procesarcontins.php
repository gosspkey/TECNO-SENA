<?php
session_start();
if (!isset($_SESSION['Idins'])) {
    echo "No has iniciado sesión. Por favor, ingresa.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contraactual = $_POST['contraactual'];
    $contranueva = $_POST['contranueva'];
    $confirmarcontra = $_POST['confirmarcontra'];

    if ($contranueva !== $confirmarcontra) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Conexión a la base de datos
    $host = "tecnosena.mysql.database.azure.com";
    $db_name = "proyecto";
    $user_name = "karen";
    $password = "12345678K&";
    $ssl_cert = "/home/site/wwwroot/confi/DigiCertGlobalRootCA.crt.pem";

    if (!file_exists($ssl_cert)) {
        die("El certificado SSL no se encontró en: $ssl_cert");
    }
    

    try {
        $conn = new PDO(
            "mysql:host=$host;dbname=$db_name;charset=utf8",
            $user_name,
            $password,
            [
                PDO::MYSQL_ATTR_SSL_CA => $ssl_cert,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ]
        );
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }

    $id_instructor = $_SESSION['Idins'];

    // Obtener contraseña actual de la base de datos
    $stmt = $conn->prepare("SELECT Contraseña FROM Instructores WHERE Idins = :id");
    $stmt->bindParam(':id', $id_instructor, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user || !password_verify($contraactual, $user['Contraseña'])) {
        echo "La contraseña actual es incorrecta.";
        exit;
    }

    // Actualizar contraseña
    $nueva_hash = password_hash($contranueva, PASSWORD_DEFAULT);
    $update_stmt = $conn->prepare("UPDATE Instructores SET Contraseña = :contranueva WHERE Idins = :id");
    $update_stmt->bindParam(':contranueva', $nueva_hash, PDO::PARAM_STR);
    $update_stmt->bindParam(':id', $id_instructor, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        header("Location: /vista/principal/perfilins.php");
        exit;
    } else {
        echo "Error al actualizar la contraseña.";
    }
}
?>
