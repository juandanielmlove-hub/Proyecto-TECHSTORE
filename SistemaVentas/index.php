
<?php

require_once 'config/sesion.php';

$ruta = $_GET['ruta'] ?? 'login';

switch ($ruta) {

    // INICIAR SESIÓN
    case 'login':

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            require_once 'controllers/AuthController.php';

            $auth = new AuthController();

            $mensaje = $auth->login(
                $_POST['correo'] ?? '',
                $_POST['password'] ?? ''
            );
        }

        if (isset($_SESSION['usuario_id'])) {
            header("Location: index.php?ruta=catalogo");
            exit;
        }

        require 'views/auth/login.php';
        break;

    // REGISTRAR USUARIO
    case 'registro':

        require_once 'controllers/AuthController.php';

        $auth = new AuthController();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $mensaje = $auth->registro(
                trim($_POST['nombre'] ?? ''),
                trim($_POST['correo'] ?? ''),
                $_POST['password'] ?? ''
            );
        }

        require 'views/auth/registro.php';
        break;

    // CATÁLOGO Y BUSCADOR
    case 'catalogo':

        verificarSesion();

        require_once 'controllers/ProductoController.php';

        $controller = new ProductoController();

        $busqueda = $_GET['buscar'] ?? '';

        if (!is_string($busqueda)) {
            $busqueda = '';
        }

        $productos = $controller->catalogo($busqueda);

        require 'views/productos/catalogo.php';
        break;

    // AGREGAR AL CARRITO
    case 'agregar':

        verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=catalogo");
            exit;
        }

        require_once 'controllers/CarritoController.php';

        $carrito = new CarritoController();

        $_SESSION['mensaje'] = $carrito->agregar(
            $_POST['producto_id'] ?? 0,
            $_POST['cantidad'] ?? 0
        );

        header("Location: index.php?ruta=carrito");
        exit;

    // MOSTRAR CARRITO
    case 'carrito':

        verificarSesion();

        require_once 'controllers/CarritoController.php';

        $carrito = new CarritoController();

        $total = $carrito->calcularTotal();

        require 'views/carrito/index.php';
        break;

    // ACTUALIZAR CANTIDADES
    case 'actualizar':

        verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=carrito");
            exit;
        }

        require_once 'controllers/CarritoController.php';

        $carrito = new CarritoController();

        $_SESSION['mensaje'] = $carrito->actualizarCantidad(
            $_POST['producto_id'] ?? 0,
            $_POST['cantidad'] ?? 0
        );

        header("Location: index.php?ruta=carrito");
        exit;

    // ELIMINAR PRODUCTO
    case 'eliminar':

        verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=carrito");
            exit;
        }

        require_once 'controllers/CarritoController.php';

        $carrito = new CarritoController();

        $carrito->eliminar(
            $_POST['producto_id'] ?? 0
        );

        $_SESSION['mensaje'] = "Producto eliminado.";

        header("Location: index.php?ruta=carrito");
        exit;

    // VACIAR CARRITO
    case 'vaciar':

        verificarSesion();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?ruta=carrito");
            exit;
        }

        require_once 'controllers/CarritoController.php';

        $carrito = new CarritoController();

        $carrito->vaciar();

        $_SESSION['mensaje'] = "Carrito vaciado.";

        header("Location: index.php?ruta=carrito");
        exit;

    // CONFIRMAR COMPRA
    case 'confirmar':

        verificarSesion();

        require_once 'controllers/VentaController.php';
        require_once 'controllers/CarritoController.php';

        $controller = new VentaController();

        $carrito = new CarritoController();

        $total = $carrito->calcularTotal();

        $resultado = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $resultado = $controller->confirmar();
        }

        require 'views/ventas/confirmar.php';
        break;

    // HISTORIAL DE COMPRAS
    case 'historial':

        verificarSesion();

        require_once 'controllers/VentaController.php';

        $controller = new VentaController();

        $ventas = $controller->historial();

        require 'views/ventas/historial.php';
        break;

    // RUTA NO ENCONTRADA
    default:

        http_response_code(404);

        echo "Página no encontrada.";
        break;
}
