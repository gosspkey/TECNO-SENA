<?php
require_once('../confi/conexion.php');

// Verificar si se recibieron los parámetros necesarios
if (isset($_GET['codigo']) && isset($_GET['tipoEquipo'])) {
    $codigoEquipo = $_GET['codigo'];
    $tipoEquipo = $_GET['tipoEquipo'];

    // Conexión a la base de datos
    $database = new Database();
    $db = $database->getConnection();

    // Determinar la tabla correcta según el tipo de equipo
    $tabla = "";
    switch ($tipoEquipo) {
        case 'tableta':
            $tabla = "Tabletas";
            break;
        case 'portatil':
            $tabla = "Portatil";
            break;
        case 'camaras':
            $tabla = "Camaras";
            break;
        case 'luces':
            $tabla = "Luces";
            break;
        case 'proyector':
            $tabla = "Proyectores";
            break;
        case 'tripode':
            $tabla = "Tripodes";
            break;
        case 'sonido':
            $tabla = "Sonido";
            break;
        default:
            header("Location: ../vista/principal/tablareserv.php?mensaje=Error: Tipo de equipo no válido");
            exit;
    }

    // Verificar si la tabla fue asignada correctamente
    if ($tabla === "") {
        header("Location: ../vista/principal/tablareserv.php?mensaje=Error interno: No se pudo asignar la tabla");
        exit;
    }

    // Crear la consulta para eliminar el equipo de la tabla correcta
    $query = "DELETE FROM $tabla WHERE CodEquipo = :codigoEquipo";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_INT);

    // Ejecutar la consulta y redirigir con mensajes según el resultado
    if ($stmt->execute()) {
        header("Location: ../vista/principal/tablareserv.php?mensaje=Equipo eliminado correctamente");
    } else {
        header("Location: ../vista/principal/tablareserv.php?mensaje=Error al eliminar el equipo");
    }
} else {
    // Redirigir si no se recibieron los parámetros correctos
    header("Location: ../vista/principal/tablareserv.php?mensaje=Error: Código o tipo de equipo no proporcionado");
}
?>