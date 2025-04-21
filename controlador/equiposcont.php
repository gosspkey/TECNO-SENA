<?php
ob_start();
require_once('../confi/conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $database = new Database();
    $db = $database->getConnection();

    // Verificar que los datos requeridos están presentes
    if (isset($_POST['placa'], $_POST['descripcion'], $_POST['tipoEquipo'])) {
        $placa = $_POST['placa'];
        $descripcion = $_POST['descripcion'];
        $tipoEquipo = $_POST['tipoEquipo']; 
        
        // Identificar el modelo del equipo según el tipo enviado
        $equipo = $_POST[$tipoEquipo] ?? null;  

        if (!$equipo) {
            echo "Error: No se recibió el modelo del equipo.";
            exit;
        }

        // Asignar la tabla correcta según el equipo
        $tablasDisponibles = [
            'tableta' => ['nombre' => 'Tabletas', 'campo' => 'Tableta'],
            'portatil' => ['nombre' => 'Portatil', 'campo' => 'Portatil'],
            'camaras' => ['nombre' => 'Camaras', 'campo' => 'Camaras'],
            'luces' => ['nombre' => 'luces', 'campo' => 'luces'],
            'proyectores' => ['nombre' => 'proyectores', 'campo' => 'proyectores'],
            'tripodes' => ['nombre' => 'tripodes', 'campo' => 'tripodes'],
            'sonido' => ['nombre' => 'sonido', 'campo' => 'sonido'],

        ];

        $tablaConfig = $tablasDisponibles[$tipoEquipo] ?? null;

        if (!$tablaConfig) {
            echo "Error: Tipo de equipo no válido.";
            exit;
        }

        $tabla = $tablaConfig['nombre'];
        $campoEquipo = $tablaConfig['campo'];

        // Inserción en la base de datos con el campo correcto
        $query = "INSERT INTO $tabla (Placa, Descripcion, $campoEquipo) VALUES (:placa, :descripcion, :equipo)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':placa', $placa);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':equipo', $equipo);

        if ($stmt->execute()) {
            header("Location: admin/../../vista/principal/admin.html?mensaje=$tipoEquipo registrado correctamente");
            exit;
        } else {
            echo "Error al registrar el equipo: " . implode(" - ", $stmt->errorInfo());
        }
    } else {
        echo "Faltan datos en el formulario.";
    }
}

ob_end_flush();
?>