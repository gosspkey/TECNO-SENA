<?php
class Tabletas {
    private $conn;
    private $table = "Tabletas";
    public $codTableta; // Nueva referencia en lugar de id
    public $placa;
    public $descripcion;
    public $tableta;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar si la tableta ya existe en la base de datos
    private function validartbl() {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE Placa = :placa";
        $consulta = $this->conn->prepare($query);
        $consulta->bindParam(':placa', $this->placa);
        $consulta->execute();
        
        return $consulta->fetchColumn() > 0;
    }

    // Método para registrar una nueva tableta
    public function creartableta() {
        // Verificar si ya existe la tableta
        if ($this->validartbl()) {
            echo "Error: La tableta con la placa {$this->placa} ya existe.";
            return false;
        }

        // Preparar la consulta SQL
        $query = "INSERT INTO " . $this->table . " (CodTableta, Placa, Descripcion, Tableta) 
                  VALUES (:codTableta, :placa, :descripcion, :tableta)";
        
        $res = $this->conn->prepare($query);

        // Sanitizar los valores
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->tableta = htmlspecialchars(strip_tags($this->tableta));

        // Vincular parámetros
        $res->bindParam(':codTableta', $this->codTableta);
        $res->bindParam(':placa', $this->placa);
        $res->bindParam(':descripcion', $this->descripcion);
        $res->bindParam(':tableta', $this->tableta);

        if ($res->execute()) {
            echo "Tableta registrada exitosamente.";
            return true;
        } else {
            echo "Error al registrar la tableta: " . implode(" - ", $res->errorInfo());
            return false;
        }
    }

    // Método para listar todas las tabletas registradas
    public function listartbl() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    // Método para eliminar una tableta por su código
    public function eliminarEquipo($codigoTableta) {
        $query = "DELETE FROM Tabletas WHERE CodTableta = :codigoTableta";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoTableta', $codigoTableta, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>