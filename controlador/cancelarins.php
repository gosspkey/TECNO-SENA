<?php

ob_start(); // Inicia el búfer de salida
require_once('../confi/conexion.php');

// Verificar que el ID de la reserva se ha recibido correctamente
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: /vista/principal/equiposins.html?mensaje=Error: ID de reserva no proporcionado.");
    exit();
}

$idReserva = intval($_GET['id']); // Asegurar que el ID sea un número entero válido

// Iniciar sesión y verificar que el instructor esté autenticado
session_start();
if (!isset($_SESSION['Idins'])) {
    header("Location: /vista/principal/equiposins.html?mensaje=No has iniciado sesión.");
    exit();
}

$idInstructor = intval($_SESSION['Idins']); // Asegurar que el ID del instructor sea válido
var_dump($idReserva, $idInstructor); // Depuración

// Conexión a la base de datos
$database = new Database();
$db = $database->getConnection();

// Verificar que la reserva pertenece al instructor actual
$query = "SELECT * FROM Reservasins WHERE IDReserva = :idReserva AND Idins = :idInstructor";
$stmt = $db->prepare($query);
$stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
$stmt->bindParam(':idInstructor', $idInstructor, PDO::PARAM_INT);
$stmt->execute();

// Depuración: Verificar si el instructor tiene acceso a cancelar la reserva
if ($stmt->rowCount() === 0) {
    header("Location: /vista/principal/equiposins.html?mensaje=No tienes permiso para cancelar esta reserva.");
    exit();
}

// Si la reserva pertenece al instructor, proceder con la eliminación
$queryDelete = "DELETE FROM Reservasins WHERE IDReserva = :idReserva";
$stmtDelete = $db->prepare($queryDelete);
$stmtDelete->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);

if ($stmtDelete->execute()) {
    header("Location: /vista/principal/equiposins.html?mensaje=Reserva cancelada correctamente.");
} else {
    header("Location: /vista/principal/equiposins.html?mensaje=Error al cancelar la reserva.");
}

ob_end_flush(); // Envía el contenido del búfer de salida
?>