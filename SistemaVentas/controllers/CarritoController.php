
<?php

require_once __DIR__ . '/../config/sesion.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {

    private $producto;

    public function __construct() {

        $this->producto = new Producto();

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    // Agregar producto al carrito
    public function agregar($id, $cantidad) {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $cantidad = filter_var(
            $cantidad,
            FILTER_VALIDATE_INT
        );

        if (!$id || !$cantidad || $cantidad < 1) {
            return "Datos del producto incorrectos.";
        }

        $producto = $this->producto->buscarPorId($id);

        if (!$producto) {
            return "El producto no existe.";
        }

        $cantidadActual =
            $_SESSION['carrito'][$id]['cantidad'] ?? 0;

        $nuevaCantidad = $cantidadActual + $cantidad;

        if ($nuevaCantidad > $producto['stock']) {
            return "No hay suficiente stock disponible.";
        }

        $_SESSION['carrito'][$id] = [
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'cantidad' => $nuevaCantidad
        ];

        return "Producto agregado correctamente.";
    }

    // Actualizar cantidad - Módulo 6
    public function actualizarCantidad($id, $cantidad) {

        $id = filter_var($id, FILTER_VALIDATE_INT);
        $cantidad = filter_var(
            $cantidad,
            FILTER_VALIDATE_INT
        );

        if (!$id || !$cantidad || $cantidad < 1) {
            return "La cantidad debe ser mayor que cero.";
        }

        if (!isset($_SESSION['carrito'][$id])) {
            return "El producto no está en el carrito.";
        }

        $producto = $this->producto->buscarPorId($id);

        if (!$producto) {
            return "El producto ya no existe.";
        }

        if ($cantidad > $producto['stock']) {
            return "Stock insuficiente. Disponible: " .
                   $producto['stock'];
        }

        $_SESSION['carrito'][$id]['cantidad'] = $cantidad;
        $_SESSION['carrito'][$id]['precio'] =
            $producto['precio'];

        return "Cantidad actualizada correctamente.";
    }

    // Eliminar producto
    public function eliminar($id) {

        $id = filter_var($id, FILTER_VALIDATE_INT);

        if ($id) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    // Vaciar carrito
    public function vaciar() {
        $_SESSION['carrito'] = [];
    }

    // Calcular total
    public function calcularTotal() {

        $total = 0;

        foreach ($_SESSION['carrito'] as $item) {

            $total +=
                $item['precio'] * $item['cantidad'];
        }

        return round($total, 2);
    }

    // Contar productos del carrito
    public function contarProductos() {

        $cantidad = 0;

        foreach ($_SESSION['carrito'] as $item) {
            $cantidad += $item['cantidad'];
        }

        return $cantidad;
    }
}
