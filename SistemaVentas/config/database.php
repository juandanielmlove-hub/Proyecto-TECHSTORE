
<?php

class Database {

    private $host = "localhost";
    private $dbname = "bd_ventas";
    private $user = "root";
    private $pass = "";

    public function conectar() {
        try {
            $conexion = new PDO(
                "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4",
                $this->user,
                $this->pass
            );

            $conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            $conexion->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            $conexion->setAttribute(
                PDO::ATTR_EMULATE_PREPARES,
                false
            );

            return $conexion;

        } catch (PDOException $e) {
            error_log($e->getMessage());
            die("No se pudo conectar con la base de datos.");
        }
    }
}
