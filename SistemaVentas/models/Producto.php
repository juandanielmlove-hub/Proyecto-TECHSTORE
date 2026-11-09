
<?php

require_once __DIR__ . '/../config/database.php';

class Producto {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar();
    }

    public function listar() {

        $sql = "SELECT * FROM productos ORDER BY nombre";

        return $this->db->query($sql)->fetchAll(
            PDO::FETCH_ASSOC
        );
    }

    public function buscarPorId($id) {

        $sql = "SELECT * FROM productos WHERE id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Funcionalidad adicional: buscador
    public function buscarPorNombre($nombre) {

        $sql = "SELECT * FROM productos
                WHERE nombre LIKE ?
                ORDER BY nombre";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%$nombre%"]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
