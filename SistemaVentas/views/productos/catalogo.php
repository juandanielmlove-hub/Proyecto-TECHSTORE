
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | TECHSTORE</title>
    <link rel="stylesheet" href="public/css/estilos.css">
</head>
<body>

    <header class="cabecera">
        <nav class="navegacion contenedor">

            <a href="index.php?ruta=catalogo" class="marca">
                <span class="logo-icono">◆</span>
                TECH<span>STORE</span>
            </a>

            <div class="nav-enlaces">
                <a href="index.php?ruta=catalogo" class="activo">
                    Productos
                </a>

                <a href="index.php?ruta=carrito">
                    Mi carrito
                    <span class="contador">
                        <?= array_sum(array_column(
                            $_SESSION['carrito'] ?? [],
                            'cantidad'
                        )) ?>
                    </span>
                </a>

                <a href="index.php?ruta=historial">
                    Mis compras
                </a>

                <a href="logout.php" class="btn-salir">
                    Cerrar sesión
                </a>
            </div>

        </nav>
    </header>

    <main class="contenedor">

        <section class="hero">
            <div class="hero-contenido">

                <span class="etiqueta">TECNOLOGÍA PARA TI</span>

                <h1>
                    Descubre tu próxima
                    <span>experiencia tecnológica.</span>
                </h1>

                <p>
                    Explora nuestra selección de accesorios
                    y dispositivos al mejor precio.
                </p>

                <div class="bienvenida">
                    Bienvenido,
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['nombre'] ?? 'Usuario'
                        ) ?>
                    </strong>
                </div>

            </div>
        </section>

        <section class="seccion-productos">

            <div class="seccion-encabezado">
                <div>
                    <span class="etiqueta">NUESTRO CATÁLOGO</span>
                    <h2>Productos disponibles</h2>
                    <p>Encuentra lo que necesitas.</p>
                </div>

                <span class="total-productos">
                    <?= count($productos) ?> productos
                </span>
            </div>

            <!-- Buscador: funcionalidad adicional -->
            <form method="GET"
                  action="index.php"
                  class="formulario-busqueda">

                <input type="hidden"
                       name="ruta"
                       value="catalogo">

                <input
                    type="search"
                    name="buscar"
                    placeholder="Buscar productos por nombre..."
                    value="<?= htmlspecialchars(
                        $_GET['buscar'] ?? ''
                    ) ?>">

                <button type="submit" class="btn btn-primario">
                    Buscar
                </button>

                <?php if (!empty($_GET['buscar'])): ?>
                    <a href="index.php?ruta=catalogo"
                       class="btn btn-secundario">
                        Limpiar
                    </a>
                <?php endif; ?>

            </form>

            <?php if (!empty($_SESSION['mensaje'])): ?>
                <div class="alerta">
                    <?= htmlspecialchars($_SESSION['mensaje']) ?>
                </div>
                <?php unset($_SESSION['mensaje']); ?>
            <?php endif; ?>

            <div class="productos">

                <?php if (empty($productos)): ?>

                    <div class="estado-vacio">
                        <h3>No encontramos productos</h3>
                        <p>Prueba con otro nombre.</p>
                        <a href="index.php?ruta=catalogo"
                           class="btn btn-primario">
                            Ver todos los productos
                        </a>
                    </div>

                <?php else: ?>

                    <?php foreach ($productos as $p): ?>

                        <article class="producto">

                            <div class="producto-imagen">

                                <?php if (!empty($p['imagen'])): ?>
                                    <img
                                        src="<?= htmlspecialchars(
                                            $p['imagen']
                                        ) ?>"
                                        alt="<?= htmlspecialchars(
                                            $p['nombre']
                                        ) ?>"
                                        loading="lazy">
                                <?php else: ?>
                                    <div class="imagen-placeholder">
                                        <span>◆</span>
                                        <small>TECHSTORE</small>
                                    </div>
                                <?php endif; ?>

                                <span class="producto-etiqueta">
                                    <?= $p['stock'] > 0
                                        ? 'Disponible'
                                        : 'Agotado' ?>
                                </span>

                            </div>

                            <div class="producto-info">

                                <h3>
                                    <?= htmlspecialchars($p['nombre']) ?>
                                </h3>

                                <p class="producto-descripcion">
                                    <?= htmlspecialchars(
                                        $p['descripcion'] ?? ''
                                    ) ?>
                                </p>

                                <div class="producto-datos">

                                    <strong class="precio">
                                        S/ <?= number_format(
                                            $p['precio'], 2
                                        ) ?>
                                    </strong>

                                    <span class="stock">
                                        Stock: <?= (int)$p['stock'] ?>
                                    </span>

                                </div>

                                <?php if ($p['stock'] > 0): ?>

                                    <form method="POST"
                                          action="index.php?ruta=agregar"
                                          class="formulario-producto">

                                        <input type="hidden"
                                               name="producto_id"
                                               value="<?= (int)$p['id'] ?>">

                                        <div class="cantidad-control">
                                            <label>Cantidad</label>

                                            <input
                                                type="number"
                                                name="cantidad"
                                                value="1"
                                                min="1"
                                                max="<?= (int)$p['stock'] ?>"
                                                required>
                                        </div>

                                        <button type="submit"
                                                class="btn btn-primario">
                                            Agregar al carrito
                                        </button>

                                    </form>

                                <?php else: ?>

                                    <button class="btn btn-agotado" disabled>
                                        Sin stock
                                    </button>

                                <?php endif; ?>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <footer class="pie-pagina">
        <div class="contenedor">
            <p>TECHSTORE © <?= date('Y') ?> | Tecnología a tu alcance</p>
        </div>
    </footer>

</body>
</html>
