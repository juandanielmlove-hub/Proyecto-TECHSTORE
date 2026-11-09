
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta | SistemaVentas</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body class="pagina-auth">

    <main class="auth-contenedor">
        <section class="auth-tarjeta">

            <div class="auth-logo">
                <span class="logo-icono">◆</span>
                <h1>TECH<span>STORE</span></h1>
            </div>

            <div class="auth-encabezado">
                <span class="etiqueta">ÚNETE A NOSOTROS</span>
                <h2>Crear cuenta</h2>
                <p>Regístrate y comienza a comprar tus productos favoritos.</p>
            </div>

            <?php if (!empty($mensaje)): ?>
                <div class="alerta">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <form method="POST"
                  action="index.php?ruta=registro"
                  class="formulario-auth">

                <div class="campo">
                    <label for="nombre">Nombre completo</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        placeholder="Ingresa tu nombre"
                        minlength="3"
                        maxlength="100"
                        value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                        required>
                </div>

                <div class="campo">
                    <label for="correo">Correo electrónico</label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        placeholder="ejemplo@correo.com"
                        maxlength="100"
                        value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>"
                        required>
                </div>

                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        minlength="8"
                        autocomplete="new-password"
                        required>
                    <small>Utiliza una contraseña segura.</small>
                </div>

                <button type="submit" class="btn btn-primario">
                    Crear mi cuenta
                </button>

            </form>

            <p class="auth-enlace">
                ¿Ya tienes una cuenta?
                <a href="index.php?ruta=login">
                    Inicia sesión
                </a>
            </p>

        </section>

        <p class="auth-pie">
            TECHSTORE © <?= date('Y') ?> | Tu tienda tecnológica
        </p>
    </main>

</body>
</html>
