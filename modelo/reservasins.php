<?php
class ReservasInstructores {
    private $conn;
    private $table = "Reservasins"; 
    public $IDReserva;
    public $Idins; 
    public $CodEquipo; 
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

        $query = "INSERT INTO " . $this->table . " (Idins, $columnaEquipo, FechaReserva)
                  VALUES (:Idins, :CodEquipo, :FechaReserva)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Idins', $this->Idins); // Cambio de IDUsuario a Idins
        $stmt->bindParam(':CodEquipo', $CodEquipo);
        $stmt->bindParam(':FechaReserva', $this->FechaReserva);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al crear la reserva: " . implode(" - ", $stmt->errorInfo());
            return false;
        }
    }

    // Método para listar todas las reservas y reflejar cualquier tipo de equipo reservado
    public function listarReservas() {
        $query = "SELECT IDReserva, Idins,  
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
          FechaReserva  
          FROM " . $this->table . " ORDER BY IDReserva DESC";

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