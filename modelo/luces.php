<?php
class Luces {
    private $conn;
    private $table = "Luces";
    public $id;
    public $placa;
    public $descripcion;
    public $nombre;

    // Constructor para inicializar la conexión
    public function __construct($db) {
        $this->conn = $db;
    }

    private function validarExistencia() {
        $query = "SELECT * FROM " . $this->table . " WHERE Placa = :placa";
        $consulta = $this->conn->prepare($query);
        $consulta->bindParam(':placa', $this->placa);
        $consulta->execute();
        return $consulta->rowCount() > 0;
    }

    public function crearLuces() {
        if ($this->validarExistencia()) {
            echo "Error: Las luces con la placa {$this->placa} ya existen.";
            return false;
        }

        $query = "INSERT INTO " . $this->table . " (Placa, Descripcion, Nombre) VALUES (:placa, :descripcion, :nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':nombre', $this->nombre);

        return $stmt->execute();
    }

    public function listarLuces() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarLuces($codigoEquipo) {
        $query = "DELETE FROM " . $this->table . " WHERE CodEquipo = :codigoEquipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>