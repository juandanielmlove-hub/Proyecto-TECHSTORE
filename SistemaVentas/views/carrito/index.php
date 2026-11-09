
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi carrito | TECHSTORE</title>
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
                <a href="index.php?ruta=catalogo">
                    Productos
                </a>

                <a href="index.php?ruta=carrito" class="activo">
                    Mi carrito
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

    <main class="contenedor pagina-carrito">

        <section class="pagina-encabezado">
            <span class="etiqueta">TU SELECCIÓN</span>
            <h1>Mi carrito de compras</h1>
            <p>Revisa tus productos antes de confirmar tu pedido.</p>
        </section>

        <?php if (!empty($_SESSION['mensaje'])): ?>
            <div class="alerta">
                <?= htmlspecialchars($_SESSION['mensaje']) ?>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (empty($_SESSION['carrito'])): ?>

            <section class="estado-vacio carrito-vacio">

                <div class="icono-vacio">◇</div>

                <h2>Tu carrito está vacío</h2>

                <p>
                    Todavía no has agregado productos.
                    Explora nuestro catálogo y encuentra
                    algo que te guste.
                </p>

                <a href="index.php?ruta=catalogo"
                   class="btn btn-primario">
                    Explorar productos
                </a>

            </section>

        <?php else: ?>

            <div class="carrito-layout">

                <section class="carrito-productos">

                    <div class="carrito-tabla-contenedor">

                        <table class="tabla-carrito">

                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach (
                                    $_SESSION['carrito'] as $id => $item
                                ): ?>

                                    <tr>

                                        <td class="nombre-producto">
                                            <?= htmlspecialchars(
                                                $item['nombre']
                                            ) ?>
                                        </td>

                                        <td>
                                            S/ <?= number_format(
                                                $item['precio'], 2
                                            ) ?>
                                        </td>

                                        <td>

                                            <!-- Modificar cantidad -->
                                            <form method="POST"
                                                  action="index.php?ruta=actualizar"
                                                  class="formulario-cantidad">

                                                <input type="hidden"
                                                       name="producto_id"
                                                       value="<?= (int)$id ?>">

                                                <input
                                                    type="number"
                                                    name="cantidad"
                                                    value="<?= (int)$item['cantidad'] ?>"
                                                    min="1"
                                                    required>

                                                <button type="submit"
                                                        class="btn-actualizar">
                                                    Actualizar
                                                </button>

                                            </form>

                                        </td>

                                        <td class="subtotal">
                                            S/ <?= number_format(
                                                $item['precio'] *
                                                $item['cantidad'], 2
                                            ) ?>
                                        </td>

                                        <td>

                                            <form method="POST"
                                                  action="index.php?ruta=eliminar"
                                                  class="formulario-eliminar">

                                                <input type="hidden"
                                                       name="producto_id"
                                                       value="<?= (int)$id ?>">

                                                <button type="submit"
                                                        class="btn-eliminar">
                                                    Eliminar
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <div class="carrito-acciones">

                        <a href="index.php?ruta=catalogo"
                           class="btn btn-secundario">
                            Seguir comprando
                        </a>

                        <form method="POST"
                              action="index.php?ruta=vaciar"
                              class="formulario-vaciar">

                            <button type="submit"
                                    class="btn btn-peligro">
                                Vaciar carrito
                            </button>

                        </form>

                    </div>

                </section>

                <aside class="resumen-compra">

                    <span class="etiqueta">TU PEDIDO</span>
                    <h2>Resumen de compra</h2>

                    <div class="resumen-fila">
                        <span>Productos</span>

                        <strong>
                            <?= array_sum(array_column(
                                $_SESSION['carrito'],
                                'cantidad'
                            )) ?>
                        </strong>
                    </div>

                    <div class="resumen-fila">
                        <span>Subtotal</span>

                        <strong>
                            S/ <?= number_format($total, 2) ?>
                        </strong>
                    </div>

                    <div class="resumen-separador"></div>

                    <div class="resumen-total">
                        <span>Total a pagar</span>

                        <strong>
                            S/ <?= number_format($total, 2) ?>
                        </strong>
                    </div>

                    <a href="index.php?ruta=confirmar"
                       class="btn btn-primario btn-comprar">
                        Confirmar compra
                    </a>

                    <p class="resumen-nota">
                        El stock y los precios se verificarán
                        antes de registrar la compra.
                    </p>

                </aside>

            </div>

        <?php endif; ?>

    </main>

    <footer class="pie-pagina">
        <div class="contenedor">
            <p>TECHSTORE © <?= date('Y') ?> | Compra con confianza</p>
        </div>
    </footer>

</body>
</html>
