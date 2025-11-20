<?php

class CConexion {

    function ConexionBD() {

        $connString = "pgsql:host=ep-holy-glade-abymyepe-pooler.eu-west-2.aws.neon.tech;
                       dbname=neondb;
                       sslmode=require";

        $username = "neondb_owner";
        $password = "npg_U7SXuJqbMe1F";

        try {
            $conn = new PDO($connString, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            echo "Se conectó correctamente a la Base de Datos";
        }
        catch (PDOException $exp) {
            echo "No se pudo conectar a la base de datos: " . $exp->getMessage();
            $conn = null;
        }

        return $conn;
    }

}

?>
