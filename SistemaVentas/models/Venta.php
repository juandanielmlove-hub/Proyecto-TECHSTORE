
<?php

require_once __DIR__ . '/../config/database.php';

class Venta {

    private $db;

    public function __construct() {
        $conexion = new Database();
        $this->db = $conexion->conectar();
    }

    // Registrar venta con transacción PDO
    public function registrar($usuario_id, $carrito) {

        if (empty($carrito)) {
            return [
                'exito' => false,
                'mensaje' => 'El carrito está vacío.'
            ];
        }

        try {
            $this->db->beginTransaction();

            $productos = [];
            $total = 0;

            // Comprobar precios y stock en MySQL
            foreach ($carrito as $id => $item) {

                $cantidad = filter_var(
                    $item['cantidad'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if ($cantidad === false || $cantidad < 1) {
                    throw new Exception(
                        'Cantidad de producto incorrecta.'
                    );
                }

                $sql = "SELECT * FROM productos
                        WHERE id = ?
                        FOR UPDATE";

                $stmt = $this->db->prepare($sql);
                $stmt->execute([$id]);

                $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$producto) {
                    throw new Exception(
                        'Uno de los productos ya no existe.'
                    );
                }

                if ($cantidad > $producto['stock']) {
                    throw new Exception(
                        'Stock insuficiente para: ' .
                        $producto['nombre']
                    );
                }

                $precio = (float) $producto['precio'];
                $subtotal = round($precio * $cantidad, 2);

                $productos[] = [
                    'id' => $producto['id'],
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                    'subtotal' => $subtotal
                ];

                $total = round($total + $subtotal, 2);
            }

            // Registrar cabecera de venta
            $sql = "INSERT INTO ventas
                    (usuario_id, total)
                    VALUES (?, ?)";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$usuario_id, $total]);

            $venta_id = $this->db->lastInsertId();

            // Registrar detalles y actualizar stock
            foreach ($productos as $producto) {

                $sql = "INSERT INTO detalle_venta
                        (venta_id, producto_id,
                         cantidad, precio, subtotal)
                        VALUES (?, ?, ?, ?, ?)";

                $stmt = $this->db->prepare($sql);

                $stmt->execute([
                    $venta_id,
                    $producto['id'],
                    $producto['cantidad'],
                    $producto['precio'],
                    $producto['subtotal']
                ]);

                $sql = "UPDATE productos
                        SET stock = stock - ?
                        WHERE id = ?";

                $stmt = $this->db->prepare($sql);

                $stmt->execute([
                    $producto['cantidad'],
                    $producto['id']
                ]);
            }

            $this->db->commit();

            return [
                'exito' => true,
                'mensaje' => 'Compra realizada correctamente.',
                'venta_id' => $venta_id,
                'total' => $total
            ];

        } catch (Throwable $e) {

            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            return [
                'exito' => false,
                'mensaje' => $e instanceof PDOException
                    ? 'No se pudo registrar la compra.'
                    : $e->getMessage()
            ];
        }
    }

    // Historial de compras del usuario
    public function historial($usuario_id) {

        $sql = "SELECT *
                FROM ventas
                WHERE usuario_id = ?
                ORDER BY fecha DESC, id DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$usuario_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Consultar detalles de una venta propia
    public function detalle($venta_id, $usuario_id) {

        $sql = "SELECT
                    v.id AS venta_id,
                    v.fecha,
                    v.total,
                    p.nombre,
                    dv.cantidad,
                    dv.precio,
                    dv.subtotal
                FROM ventas v
                INNER JOIN detalle_venta dv
                    ON v.id = dv.venta_id
                INNER JOIN productos p
                    ON dv.producto_id = p.id
                WHERE v.id = ?
                  AND v.usuario_id = ?";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            $venta_id,
            $usuario_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
