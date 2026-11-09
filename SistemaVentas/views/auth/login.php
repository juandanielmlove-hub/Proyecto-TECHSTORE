
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión | SistemaVentas</title>
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
                <span class="etiqueta">BIENVENIDO</span>
                <h2>Iniciar sesión</h2>
                <p>Accede a tu cuenta y descubre nuestra tecnología.</p>
            </div>

            <?php if (!empty($mensaje)): ?>
                <div class="alerta">
                    <?= htmlspecialchars($mensaje) ?>
                </div>
            <?php endif; ?>

            <form method="POST"
                  action="index.php?ruta=login"
                  class="formulario-auth">

                <div class="campo">
                    <label for="correo">Correo electrónico</label>
                    <input
                        type="email"
                        id="correo"
                        name="correo"
                        placeholder="ejemplo@correo.com"
                        autocomplete="email"
                        required>
                </div>

                <div class="campo">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        autocomplete="current-password"
                        required>
                </div>

                <button type="submit" class="btn btn-primario">
                    Ingresar a mi cuenta
                </button>

            </form>

            <p class="auth-enlace">
                ¿Todavía no tienes cuenta?
                <a href="index.php?ruta=registro">
                    Regístrate aquí
                </a>
            </p>

        </section>

        <p class="auth-pie">
            TECHSTORE © <?= date('Y') ?> | Tu tienda tecnológica
        </p>
    </main>

</body>
</html>
