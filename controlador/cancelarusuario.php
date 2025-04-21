<?php

ob_start(); // Inicia el búfer de salida
require_once('../confi/conexion.php');

// Verificar que el ID de la reserva se ha recibido correctamente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: /vista/principal/equipos.html?mensaje=Error: ID de reserva no proporcionado.");
    exit();
}

$idReserva = intval($_GET['id']); // Asegurar que el ID sea un número entero válido

// Iniciar sesión y verificar que el usuario esté autenticado
session_start();
if (!isset($_SESSION['Idusu'])) {
    header("Location: /vista/principal/equipos.html?mensaje=No has iniciado sesión.");
    exit();
}
var_dump($idReserva, $_SESSION['Idusu']);
$idUsuario = intval($_SESSION['Idusu']); // Asegurar que el ID de usuario sea un número entero válido

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar que la reserva pertenece al usuario actual
$query = "SELECT * FROM Reservas WHERE IDReserva = :idReserva AND IDUsuario = :idUsuario";
$stmt = $db->prepare($query);
$stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
$stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
$stmt->execute();

// Depuración: Verificar que la consulta trae resultados
if ($stmt->rowCount() === 0) {
    header("Location: /vista/principal/equipos.html?mensaje=No tienes permiso para cancelar esta reserva.");
    exit();
}

// Si la reserva pertenece al usuario, proceder con la eliminación
$queryDelete = "DELETE FROM Reservas WHERE IDReserva = :idReserva";
$stmtDelete = $db->prepare($queryDelete);
$stmtDelete->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);

if ($stmtDelete->execute()) {
    header("Location: /vista/principal/equipos.html?mensaje=Reserva cancelada correctamente.");
} else {
    header("Location: /vista/principal/equipos.html?mensaje=Error al cancelar la reserva.");
}


ob_end_flush(); // Envía el contenido del búfer de salida
?>