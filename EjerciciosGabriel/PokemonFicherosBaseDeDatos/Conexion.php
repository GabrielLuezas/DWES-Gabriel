<?php

require_once "config.php";

class CConexion {

    function ConexionBD() {


        $connString = "pgsql:host=" . DB_HOST . ";
                       dbname=" . DB_NAME . ";
                       sslmode=require;
                       channel_binding=require";

        $username = DB_USER;
        $password = DB_PASS;

        try {
            $conn = new PDO($connString, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            $conn = null;
        }

        return $conn;
    }

}

?>
