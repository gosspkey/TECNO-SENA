<?php
ob_start(); // Inicia el búfer de salida

require_once(__DIR__ . '/../confi/conexion.php');

class Instructores {
    private $conn;
    private $table = "Instructores";
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

    // Listar instructores
    public function listarins() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un instructor por ID
    public function idisns() {
        $query = "SELECT * FROM instructores WHERE Idins = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt;
    }

    // Actualizar instructor desde formulario actuainst.php
    public function actualizarins() {
        $query = "UPDATE " . $this->table . " SET 
            Nombreins = :nombre,
            Apellidoins = :apellido,
            Identificacionins = :identi,
            Documentoins = :documento,
            Emailins = :email,
            Usuario = :usuario,
            Contraseña = :contra
            WHERE Idins = :id";

        $stmt = $this->conn->prepare($query);

        // Hashear la contraseña
        $contraHash = password_hash($this->contra, PASSWORD_BCRYPT);

        // Enlazar parámetros
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellido', $this->apellido);
        $stmt->bindParam(':identi', $this->identi);
        $stmt->bindParam(':documento', $this->documento);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':contra', $contraHash);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Método original para registrar instructor
    public function registrar($nombre, $apellido, $identificacion, $documento, $email, $usuario, $contraseña) {
        // Verificar duplicados
        $sql = "SELECT * FROM Instructores WHERE Usuario = ? OR Documentoins = ? OR Emailins = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario, $documento, $email]);

        if ($stmt->rowCount() > 0) {
            return "Ya existe un instructor con el mismo nombre de usuario, documento o correo.";
        }

        // Insertar nuevo instructor
        $sql = "INSERT INTO Instructores (Nombreins, Apellidoins, Identificacionins, Documentoins, Emailins, Usuario, Contraseña)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nombre, $apellido, $identificacion, $documento, $email, $usuario, $contraseña]);

        return "Instructor registrado con éxito.";
    }
}

// Procesamiento del formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    $instructorObj = new Instructores($conn);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $identi = $_POST['identi'];
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);

    $resultado = $instructorObj->registrar($nombre, $apellido, $identi, $documento, $correo, $usuario, $contraseña);

    if ($resultado === "Instructor registrado con éxito.") {
        header("Location: ../vista/principal/admin.html");
        exit();
    } else {
        echo $resultado;
    }
}
ob_end_flush(); // Envía el contenido del búfer de salida
?>

