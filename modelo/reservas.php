<?php
class Reservas {
    private $conn;
    private $table = "Reservas";

    public $IDReserva;
    public $IDUsuario;
    public $CodEquipo; // Ahora reflejará cualquier equipo
    public $fichausu;
    public $FechaReserva;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para crear una reserva según el tipo de equipo
    public function crearReserva($tipoEquipo, $CodEquipo) {
        $columnaEquipo = null;

        switch ($tipoEquipo) {
            case 'tableta':
                $columnaEquipo = 'CodTableta';
                break;
            case 'portatil':
                $columnaEquipo = 'CodPortatil';
                break;
            case 'camaras':
                $columnaEquipo = 'CodCamara';
                break;
            case 'luces':
                $columnaEquipo = 'CodLuces';
                break;
            case 'proyector':
                $columnaEquipo = 'CodProyector';
                break;
            case 'tripode':
                $columnaEquipo = 'CodTripode';
                break;
            case 'sonido':
                $columnaEquipo = 'CodSonido';
                break;
            default:
                echo "Tipo de equipo no válido.";
                return false;
        }

        $query = "INSERT INTO " . $this->table . " (IDUsuario, $columnaEquipo, Fichausu, FechaReserva)
                  VALUES (:IDUsuario, :CodEquipo, :fichausu, :FechaReserva)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':IDUsuario', $this->IDUsuario);
        $stmt->bindParam(':CodEquipo', $CodEquipo);
        $stmt->bindParam(':fichausu', $this->fichausu);
        $stmt->bindParam(':FechaReserva', $this->FechaReserva);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al crear la reserva: " . implode(" - ", $stmt->errorInfo());
            return false;
        }
    }

    // Método para listar todas las reservas y reflejar cualquier tipo de equipo reservado
    public function listaresv() {
        $query = "SELECT IDReserva, IDUsuario, 
          COALESCE(CodTableta, CodPortatil, CodCamara, CodLuces, CodProyector, CodTripode, CodSonido) AS CodEquipo, 
          CASE 
            WHEN CodTableta IS NOT NULL THEN 'tableta'
            WHEN CodPortatil IS NOT NULL THEN 'portatil'
            WHEN CodCamara IS NOT NULL THEN 'camaras'
            WHEN CodLuces IS NOT NULL THEN 'luces'
            WHEN CodProyector IS NOT NULL THEN 'proyector'
            WHEN CodTripode IS NOT NULL THEN 'tripode'
            WHEN CodSonido IS NOT NULL THEN 'sonido'
          END AS tipoEquipo,
          Fichausu, FechaReserva 
          FROM Reservas ORDER BY IDReserva DESC";

        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }

    // Método para eliminar una reserva
    public function eliminarReserva($idReserva) {
        $query = "DELETE FROM " . $this->table . " WHERE IDReserva = :idReserva";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idReserva', $idReserva, PDO::PARAM_INT);
        
        
        return $stmt->execute();
    }
}

?>