<?php
// Crear clase
class Database {
    // Atributos
    private $host = "localhost";
    private $db_name = "proyecto";
    private $user_name = "root";
    private $password = "";

    // Objeto de conexión
    public $conn;

    // Función para obtener la conexión
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->user_name, $this->password);
            $this->conn->exec("set names utf8");

            if($this->conn) {
                echo "<br>";
                $this->db_name;
                echo "<br>";
            }
        } catch(PDOException $exception) {
            echo "<br>";
            echo "Error en la conexión: " . $exception->getMessage();
            echo "<br>";
        }

        return $this->conn;
    }
}
?>

