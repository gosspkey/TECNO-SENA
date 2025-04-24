<?php
ob_start();
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');
require_once('../modelo/tabletas.php');
require_once('../modelo/portatil.php');
require_once('../modelo/camaras.php');
require_once('../modelo/luces.php');
require_once('../modelo/proyectores.php');
require_once('../modelo/tripodes.php');
require_once('../modelo/sonido.php');

session_start(); // Iniciar la sesión

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar si el instructor ha iniciado sesión
if (!isset($_SESSION['Idins'])) {
    echo "Error: No se ha iniciado sesión o el ID del instructor no está disponible.";
    exit;
}

$Idins = $_SESSION['Idins']; // ID del instructor desde la sesión

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST); // Depuración para ver los datos enviados
    echo "</pre>";

    $tipoEquipo = $_POST['tipoEquipo'] ?? null;
    $FechaReserva = $_POST['FechaReserva'] ?? null;
    $CodEquipo = null;
    $columnaEquipo = null;

    if (!$Idins || !$FechaReserva || !$tipoEquipo) {
        echo "Faltan datos para realizar la reserva.";
        exit;
    }

    // Verificación por tipo de equipo
    if ($tipoEquipo === 'tableta') {
        $CodEquipo = $_POST['CodTableta'] ?? null;
        $columnaEquipo = 'CodTableta';
    } elseif ($tipoEquipo === 'portatil') {
        $CodEquipo = $_POST['CodPortatil'] ?? null;
        $columnaEquipo = 'CodPortatil';
    } elseif ($tipoEquipo === 'camaras') {
        $CodEquipo = $_POST['CodCamara'] ?? null;
        $columnaEquipo = 'CodCamara';
    } elseif ($tipoEquipo === 'luces') {
        $CodEquipo = $_POST['CodLuces'] ?? null;
        $columnaEquipo = 'CodLuces';
    } elseif ($tipoEquipo === 'proyector') {
        $CodEquipo = $_POST['CodProyector'] ?? null;
        $columnaEquipo = 'CodProyector';
    } elseif ($tipoEquipo === 'tripode') {
        $CodEquipo = $_POST['CodTripode'] ?? null;
        $columnaEquipo = 'CodTripode';
    } elseif ($tipoEquipo === 'sonido') {
        $CodEquipo = $_POST['CodSonido'] ?? null;
        $columnaEquipo = 'CodSonido';
    } else {
        echo "Error: Tipo de equipo no válido.";
        exit;
    }

    // Validar `CodEquipo`
    $CodEquipo = !empty($CodEquipo) ? intval($CodEquipo) : null;
    if ($CodEquipo === null) {
        echo "Error: No se recibió un código válido de equipo.";
        exit;
    }

    // Crear la consulta SQL específica para `Reservas_Instructores`
    $query = "INSERT INTO Reservasins (Idins, " . $columnaEquipo . ", FechaReserva)  
              VALUES (:Idins, :CodEquipo, :FechaReserva)";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':Idins', $Idins);
    $stmt->bindParam(':CodEquipo', $CodEquipo);
    $stmt->bindParam(':FechaReserva', $FechaReserva);

    // Ejecutar la consulta y verificar errores
    if ($stmt->execute()) {
        $idReserva = $db->lastInsertId();
        header("Location: ../vista/principal/reservaexitins.php?id=" . $idReserva);
        exit;
    } else {
        echo "Error al registrar la reserva: " . implode(" - ", $stmt->errorInfo());
    }
    exit;
} else {
    echo "Método no permitido.";
}

ob_end_flush();
?>