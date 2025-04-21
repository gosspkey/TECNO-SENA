<?php
class Camara {
    private $conn;
    private $table = "Camaras"; // Nombre de la tabla en la base de datos
    public $id;
    public $placa;
    public $descripcion;
    public $camara;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar si la cámara ya existe
    private function validarCamara() {
        $query = "SELECT * FROM " . $this->table . " WHERE Placa = :placa";
        $consulta = $this->conn->prepare($query);
        $consulta->bindParam(':placa', $this->placa);
        $consulta->execute();

        echo "Validando existencia: ";
        echo "Número de filas encontradas: " . $consulta->rowCount();

        return $consulta->rowCount() > 0;
    }

    // Método para registrar una nueva cámara
    public function crearCamara() {
        // Imprimir datos recibidos
        echo "Datos recibidos:";
        var_dump($this->placa, $this->descripcion, $this->camara);

        // Verificar si ya existe
        if ($this->validarCamara()) {
            echo "Error: La cámara con la placa {$this->placa} ya existe.";
            return false;
        }

        // Preparar la consulta SQL
        $query = "INSERT INTO " . $this->table . " (Placa, Descripcion, Camaras) 
                  VALUES (:placa, :descripcion, :camara)";
        $res = $this->conn->prepare($query);

        // Sanitizar los datos
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->camara = htmlspecialchars(strip_tags($this->camara));

        // Vincular parámetros
        $res->bindParam(':placa', $this->placa);
        $res->bindParam(':descripcion', $this->descripcion);
        $res->bindParam(':camara', $this->camara);

        // Imprimir consulta y parámetros
        echo "Consulta preparada: $query";
        echo "Parámetros vinculados: ";
        var_dump($this->placa, $this->descripcion, $this->camara);

        // Ejecutar la consulta y manejar errores
        if ($res->execute()) {
            echo "Cámara registrada exitosamente.";
            return true;
        } else {
            $errorInfo = $res->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }

    // Función para listar las cámaras registradas
    public function listarCamaras() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    // Método para eliminar una cámara por su código
    public function eliminarEquipo($codigoEquipo) {
        $query = "DELETE FROM Camaras WHERE CodCamara = :codigoEquipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>