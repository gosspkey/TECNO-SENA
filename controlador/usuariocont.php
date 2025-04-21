<?php
ob_start(); // Inicia el bufe de salida

require_once __DIR__ . '/../confi/conexion.php';
session_start(); // Iniciar sesión

// Validar que los datos del formulario estén presentes
if (empty($_POST['usuario']) || empty($_POST['contraseña'])) {
    echo "Usuario o contraseña no proporcionados.";
    exit();
}

// Obtener datos del formulario
$usuario = trim($_POST['usuario']);
$contra = trim($_POST['contraseña']);

// Obtener la conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo "Error al conectar a la base de datos.";
    exit();
}

// Función para verificar usuario en una tabla específica
function verificarUsuario($db, $tabla, $usuario, $contra) {
    $sql = "SELECT * FROM $tabla WHERE Usuario = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$usuario]);
    $datos = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$datos) {
        return false;
    }

    if (password_verify($contra, $datos['Contraseña'])) {
        return $datos;
    }

    return false;
}

// Verificar en la tabla Usuario
$datos = verificarUsuario($db, 'Usuario', $usuario, $contra);
if ($datos) {
    $_SESSION['rol'] = 'aprendiz';
    $_SESSION['Idusu'] = $datos['Idusu'];
    header("Location: aprendiz/../../vista/principal/equipos.html");
    exit();
}

// Verificar en la tabla Instructores
$datos = verificarUsuario($db, 'Instructores', $usuario, $contra);
if ($datos) {
    $_SESSION['rol'] = 'instructor';
    $_SESSION['Idins'] = $datos['Idins'];
    header("Location: instructor/../../vista/principal/equiposins.html");
    exit();
}

// Verificar en la tabla Administradores
$datos = verificarUsuario($db, 'Administradores', $usuario, $contra);
if ($datos) {
    $_SESSION['rol'] = 'admin';
    $_SESSION['Idad'] = $datos['Idad'];
    header("Location: admin/../../vista/principal/admin.html");
    exit();
}

// Si no se encuentra el usuario
echo "Usuario o contraseña incorrectos.";
exit();

ob_end_flush(); // Envía el contenido del búfer de salida
?>