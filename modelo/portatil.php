<?php
class Portatil {
    private $conn;
    private $table = "Portatil";
    public $id;
    public $placa;
    public $descripcion;
    public $portatil;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para validar si el portatil ya existe
    private function validarpor() {
        $query = "SELECT * FROM " . $this->table . " WHERE Placa = :placa";
        $consulta = $this->conn->prepare($query);
        $consulta->bindParam(':placa', $this->placa);
        $consulta->execute();
    
        echo "Validando existencia: ";
        echo "Número de filas encontradas: " . $consulta->rowCount();
    
        return $consulta->rowCount() > 0;
    }
    
    

    public function crearportatil() {
        // Imprimir datos recibidos
        echo "Datos recibidos:";
        var_dump($this->placa, $this->descripcion, $this->portatil);
    
        // Verificar si ya existe
        if ($this->validarpor()) {
            echo "Error: El portatil con la placa {$this->placa} ya existe.";
            return false;
        }
    
        // Preparar la consulta SQL
        $query = "INSERT INTO " . $this->table . " (Placa, Descripcion, Portatil) 
                  VALUES (:placa, :descripcion, :portatil)";
        $res = $this->conn->prepare($query);
    
        $this->placa = htmlspecialchars(strip_tags($this->placa));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->portatil = htmlspecialchars(strip_tags($this->portatil));
    
        // Vincular parámetros
        $res->bindParam(':placa', $this->placa);
        $res->bindParam(':descripcion', $this->descripcion);
        $res->bindParam(':portatil', $this->portatil);
    
        // Imprimir consulta y parámetros
        echo "Consulta preparada: $query";
        echo "Parámetros vinculados: ";
        var_dump($this->placa, $this->descripcion, $this->portatil);
    
        // Ejecutar la consulta y manejar errores
        if ($res->execute()) {
            echo "Portatil registrado exitosamente.";
            return true;
        } else {
            $errorInfo = $res->errorInfo();
            echo "Error al ejecutar la consulta: " . $errorInfo[2];
            return false;
        }
    }
    
    

    // Función para listar los usuarios registrados
    public function listarpor() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarEquipo($codigoEquipo) {
        $query = "DELETE FROM Portatil WHERE CodEquipo = :codigoEquipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_STR);
    
        return $stmt->execute();
    }
    
    
}
?>