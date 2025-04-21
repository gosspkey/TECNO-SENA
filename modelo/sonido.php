<?php
class Sonido {
    private $conn;
    private $table = "Sonido";
    public $id;
    public $placa;
    public $descripcion;
    public $nombre;

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

    public function crearSonido() {
        if ($this->validarExistencia()) {
            echo "Error: El equipo de sonido con la placa {$this->placa} ya existe.";
            return false;
        }

        $query = "INSERT INTO " . $this->table . " (Placa, Descripcion, Nombre) VALUES (:placa, :descripcion, :nombre)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':placa', $this->placa);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':nombre', $this->nombre);

        return $stmt->execute();
    }

    public function listarSonido() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    public function eliminarSonido($codigoEquipo) {
        $query = "DELETE FROM " . $this->table . " WHERE CodEquipo = :codigoEquipo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigoEquipo', $codigoEquipo, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>