<?php
ob_start(); // Inicia el búfer de salida

require_once(__DIR__ . '/../confi/conexion.php');

class Administrador {
    private $conn;
    private $table = "Administradores";
    public $id;
    public $nombre;
    public $apellido;
    public $identi;
    public $documento;
    public $email;
    public $usuario;
    public $contra;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Listar todos los administradores
    public function listaradmin() {
        $query = "SELECT * FROM " . $this->table;
        $consulta = $this->conn->prepare($query);
        $consulta->execute();
        return $consulta;
    }


    public function actualizar() {
        $query = "UPDATE " . $this->table . " SET 
            Nombread = :nombre,
            Apellidoad = :apellido,
            Identificacionad = :identi,
            Documentoad = :documento,
            Emailad = :email,
            Usuario = :usuario,
            Contraseña = :contra
            WHERE Idad = :id";

        $stmt = $this->conn->prepare($query);

        // Limpiar datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->apellido = htmlspecialchars(strip_tags($this->apellido));
        $this->identi = htmlspecialchars(strip_tags($this->identi));
        $this->documento = htmlspecialchars(strip_tags($this->documento));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $this->contra = password_hash($this->contra, PASSWORD_BCRYPT);
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Enlazar parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':identi', $this->identi);
        $stmt->bindParam(':documento', $this->documento);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':contra', $this->contra);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = $stmt->errorInfo();
            echo "Error al actualizar administrador: " . $error[2];
            return false;
        }
    }
    // Obtener un administrador por ID
    public function adminuno() {
        $query = "SELECT * FROM " . $this->table . " WHERE Idad = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Registrar un nuevo administrador
    public function registrar($nombre, $apellido, $identi, $documento, $correo, $usuario, $contraseña) {
        $sql = "SELECT * FROM Administradores WHERE Usuario = ? OR Documentoad = ? OR Emailad = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario, $documento, $correo]);

        if ($stmt->rowCount() > 0) {
            return "El administrador ya existe.";
        }

        $sql = "INSERT INTO Administradores (Nombread, Apellidoad, Identificacionad, Documentoad, Emailad, Usuario, Contraseña) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nombre, $apellido, $identi, $documento, $correo, $usuario, $contraseña]);

        return "Administrador registrado correctamente.";
    }

    

    // Actualizar un administrador
    
}

// Registro desde formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    $adminObj = new Administrador($conn);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $identi = $_POST['identi'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);

    $resultado = $adminObj->registrar($nombre, $apellido, $identi, $documento, $correo, $usuario, $contraseña);

    if ($resultado === "Administrador registrado correctamente.") {
        header("Location: ../vista/principal/admin.html");
        exit();
    } else {
        echo $resultado;
    }
}

ob_end_flush(); // Envía el contenido del búfer de salida

?>
