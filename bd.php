<?php
class CConexion {
    function conexionBD() {
        $host = "localhost";
        $dbname = "dbphp";
        $username = "postgres";
        $password = "edward67";

        try {
            $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
            
            // Configurar atributos de PDO
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

           
            return $conn;
        } catch (PDOException $exp) {
            // Registrar información detallada sobre el error
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            return null;
        }
    }
}
?>