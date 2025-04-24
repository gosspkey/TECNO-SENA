<?php
session_start();
if (!isset($_SESSION['Idad'])) {
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
    $host = "localhost";
    $dbname = "proyecto";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar la contraseña actual
        $stmt = $conn->prepare("SELECT Contraseña FROM Administradores WHERE Idad = :id");
        $stmt->bindParam(':id', $_SESSION['Idad'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($contraactual, $user['Contraseña'])) {
            echo "La contraseña actual es incorrecta.";
            exit;
        }

        // Actualizar la contraseña
        $hashed_password = password_hash($contranueva, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE Administradores SET Contraseña = :contranueva WHERE Idad = :id");
        $update_stmt->bindParam(':contranueva', $hashed_password, PDO::PARAM_STR);
        $update_stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            echo "Contraseña actualizada correctamente.";
            header("Location: perfiladm.php");
        } else {
            echo "Error al actualizar la contraseña.";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
}
?>