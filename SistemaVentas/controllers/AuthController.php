
<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/sesion.php';

class AuthController {

    private $usuario;

    public function __construct() {
        $this->usuario = new Usuario();
    }

    public function login($correo, $password) {

        $correo = trim($correo);

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)
            || $password === '') {
            return "Ingresa un correo y contraseña válidos.";
        }

        $usuario = $this->usuario->buscarCorreo($correo);

        if ($usuario && password_verify(
            $password,
            $usuario['password']
        )) {

            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['correo'] = $usuario['correo'];

            header("Location: index.php?ruta=catalogo");
            exit;
        }

        return "Correo o contraseña incorrectos.";
    }

    public function registro($nombre, $correo, $password) {

        $nombre = trim($nombre);
        $correo = trim($correo);

        if (strlen($nombre) < 3) {
            return "El nombre debe tener al menos 3 caracteres.";
        }

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return "Ingresa un correo electrónico válido.";
        }

        if (strlen($password) < 8) {
            return "La contraseña debe tener al menos 8 caracteres.";
        }

        if ($this->usuario->buscarCorreo($correo)) {
            return "El correo ya está registrado.";
        }

        $this->usuario->registrar(
            $nombre,
            $correo,
            $password
        );

        return "Usuario registrado correctamente.";
    }
}
