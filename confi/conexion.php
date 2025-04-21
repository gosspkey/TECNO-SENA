<?php
// Crear clase
class Database {
    // Atributos
    private $host = "tecnosena.mysql.database.azure.com";
    private $db_name = "proyecto";
    private $user_name = "karen";
    private $password = "12345678K&";
    private $ssl_cert = __DIR__ ."confi/DigiCertGlobalRootCA.crt.pem"; //ruta certificado

    // Objeto de conexión
    public $conn;

    // Función para obtener la conexión
    public function getConnection() {
    
    $options = [
        PDO::MYSQL_ATTR_SSL_CA=>$this->ssl_cert, //AGREGA CERTIFICADO
        PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=>false, //EVITA VERIFICAR
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //MANEJAR ERRORES
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC //MODO OBTENCION DE DATOS
    ];
        try {

            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8", 
            $this->user_name, 
            $this->password, 
            $options // Cambiado de $this->options a $options
        );

            if($this->conn) {
            }
        } catch(PDOException $e) {
            echo "<br>";
            echo "Error en la conexión: " . $e->getMessage();
            echo "<br>";
        }

        return $this->conn;
    }
}
?>