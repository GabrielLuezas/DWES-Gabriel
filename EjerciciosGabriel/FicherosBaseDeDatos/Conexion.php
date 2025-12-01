<?php

class CConexion {

    function ConexionBD() {

        $connString = "pgsql:host=ep-steep-shadow-ag3gkbv3-pooler.c-2.eu-central-1.aws.neon.tech;
                       dbname=spotify;
                       sslmode=require;
                       channel_binding=require";

        $username = "neondb_owner";
        $password = "npg_GeK4OE9XcSDQ";

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
