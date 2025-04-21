<?php
require_once('../confi/conexion.php');
require_once('../modelo/reservas.php');

// Verificar si se recibió el ID de la reserva
if (isset($_GET['id'])) {
    $idReserva = $_GET['id'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Crear una instancia del modelo Reservas
    $Reservas = new Reservas($db);

    // Llamar al método para eliminar la reserva
    if ($Reservas->eliminarReserva($idReserva)) {
        // Redirigir con un mensaje de éxito
        header("Location: ../vista/principal/tablareserv.php");
    } else {
        // Redirigir con un mensaje de error
        header("Location: ../vista/principal/tablareserv.php");
    }
} else {
    // Redirigir si no se recibió el ID
    header("Location: ../vista/principal/tablareserv.php");
}
?>