
<?php

require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/Venta.php';

class VentaController {

    private $venta;

    public function __construct() {
        $this->venta = new Venta();
    }

    // Confirmar compra - Módulo 7
    public function confirmar() {

        verificarSesion();

        if (empty($_SESSION['carrito'])) {
            return [
                'exito' => false,
                'mensaje' => 'Tu carrito está vacío.'
            ];
        }

        $usuario_id = $_SESSION['usuario_id'];
        $carrito = $_SESSION['carrito'];

        $resultado = $this->venta->registrar(
            $usuario_id,
            $carrito
        );

        // Vaciar únicamente después de compra exitosa
        if ($resultado['exito']) {

            $_SESSION['carrito'] = [];

            $_SESSION['ultima_venta'] =
                $resultado['venta_id'];
        }

        return $resultado;
    }

    // Historial de compras - Módulo 8
    public function historial() {

        verificarSesion();

        $usuario_id = $_SESSION['usuario_id'];

        return $this->venta->historial($usuario_id);
    }

    // Detalles de una compra
    public function detalle($venta_id) {

        verificarSesion();

        $venta_id = filter_var(
            $venta_id,
            FILTER_VALIDATE_INT
        );

        if (!$venta_id || $venta_id < 1) {
            return [];
        }

        $usuario_id = $_SESSION['usuario_id'];

        return $this->venta->detalle(
            $venta_id,
            $usuario_id
        );
    }
}
