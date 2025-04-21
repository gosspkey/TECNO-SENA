<?php
ob_start(); // Inicia el búfer de salida

require_once(__DIR__ . '/../confi/conexion.php');

class Usuario {
    private $conn;
    private $table = "Usuario";
    public $id;
    public $nombre;
    public $apellido;
    public $identi;
    public $documento;
    public $telefono;
    public $email;
    public $ficha;
    public $usuario;
    public $contra;


    public function __construct($db) {
        $this->conn = $db;
    }
public function listarusu() {
    $query = "SELECT * FROM Usuario"; // Consulta para obtener todos los usuarios
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt; // Devuelve el objeto PDOStatement
}

        // Función para actualizar un usuario
        public function actualizar() {
            $query = "UPDATE " . $this->table . " SET 
                Nombreusu = :nombre,
                Apellidousu = :apellido,
                Identificacionusu = :identi,
                Documentousu = :documento,
                Telefonousu = :telefono,
                Emailusu = :email,
                Fichausu = :ficha,
                Fichausu = :usuario,
                Contraseña = :contra
                WHERE Idusu = :id";
    
            $stmt = $this->conn->prepare($query);
    
            // Encriptar los datos
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->apellido = htmlspecialchars(strip_tags($this->apellido));
            $this->identi = htmlspecialchars(strip_tags($this->identi));
            $this->documento = htmlspecialchars(strip_tags($this->documento));
            $this->telefono = htmlspecialchars(strip_tags($this->telefono));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->ficha = htmlspecialchars(strip_tags($this->ficha));
            $this->usuario = htmlspecialchars(strip_tags($this->usuario));
            $this->contra = password_hash($this->contra, PASSWORD_BCRYPT);
            $this->id = htmlspecialchars(strip_tags($this->id));
    
            // Vincular parámetros
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
            $stmt->bindParam(':identi', $this->identi);
            $stmt->bindParam(':documento', $this->documento);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':ficha', $this->ficha);
            $stmt->bindParam(':usuario', $this->usuario);
            $stmt->bindParam(':contra', $this->contra);
            $stmt->bindParam(':id', $this->id);
    
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                // Manejo de errores
                $errorInfo = $stmt->errorInfo();
                echo "Error al actualizar la consulta: " . $errorInfo[2];
                return false;
            }
        }
        public function actualizarapr() {
            $query = "UPDATE " . $this->table . " SET 
                Nombreusu = :nombre,
                Apellidousu = :apellido,
                Telefonousu = :telefono,
                Emailusu = :email,
                Usuario = :usuario
                WHERE Idusu = :id";
        
            $stmt = $this->conn->prepare($query);
        
        
            // Vincular parámetros
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellido', $this->apellido);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':usuario', $this->usuario);
            $stmt->bindParam(':id', $this->id);
        
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Error al ejecutar la consulta: " . $errorInfo[2];
                return false;
            }
        }

        // Función para obtener un solo usuario por ID
        public function Usuuno() {
            $query = "SELECT * FROM " . $this->table . " WHERE Idusu = :id LIMIT 1";
            $stmt = $this->conn->prepare($query);

            // Vincular el parámetro id
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt;
}

    public function registrar($nombre, $apellido, $identi, $documento, $telefono, $correo, $ficha, $usuario, $contraseña) {
        // Verifica si ya existe un usuario con los mismos datos
        $sql = "SELECT * FROM Usuario WHERE Usuario = ? OR Documentousu = ? OR Emailusu = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario, $documento, $correo]);

        if ($stmt->rowCount() > 0) {
            return "El usuario ya existe";
        }

      

        // Si no existe, inserta el nuevo usuario
        $sql = "INSERT INTO Usuario (Nombreusu, Apellidousu, Identificacionusu, Documentousu, Telefonousu, Emailusu, Fichausu, usuario, Contraseña) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute([$nombre, $apellido, $identi, $documento, $telefono, $correo, $ficha, $usuario, $contraseña])) {
            return "Usuario registrado correctamente";
        } else {
            $errorInfo = $stmt->errorInfo();
            return "Error al registrar el usuario: " . $errorInfo[2];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    $usuarioObj = new Usuario($conn);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $identi = $_POST['identi'];
    $documento = $_POST['documento'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $ficha = $_POST['ficha'];
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT);

    $resultado = $usuarioObj->registrar($nombre, $apellido, $identi, $documento, $telefono, $correo, $ficha, $usuario, $contraseña);
    if ($resultado === "Usuario registrado correctamente") {
        if (headers_sent()) {
            echo "Error: Los encabezados ya se enviaron. No se puede redirigir.";
            exit();
        }
        header("Location: /vista/iniciosesion.html");
        exit();
    } else {
        echo $resultado;
    }
}

ob_end_flush(); // Envía el contenido del búfer de salida
?>