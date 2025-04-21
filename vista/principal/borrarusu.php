<?php
include ('../../confi/conexion.php'); 
$database = new Database();
$conexion = $database->getConnection(); 


$id_a_borrar = $_GET['id'];


if (filter_var($id_a_borrar, FILTER_VALIDATE_INT)) {
    try {
        
        $query = "DELETE FROM Usuario WHERE Idusu = :id";
        

        $stmt = $conexion->prepare($query);
        
        
        $stmt->bindParam(':id', $id_a_borrar);

        
        if ($stmt->execute()) {
     
            if ($stmt->rowCount() > 0) {
                header("Location: tablaestu.php");
        exit;
    } else {
        echo "Error al borrar.";
    }
}
    } catch (PDOException $e) {
        
        echo "<p>Error al ejecutar la consulta: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>ID no válido.</p>";
}
?>