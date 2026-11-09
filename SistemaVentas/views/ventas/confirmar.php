
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar compra | TECHSTORE</title>
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
            <a href="index.php?ruta=catalogo">Productos</a>
            <a href="index.php?ruta=carrito">Mi carrito</a>
            <a href="index.php?ruta=historial">Mis compras</a>
            <a href="logout.php" class="btn-salir">Cerrar sesión</a>
        </div>
    </nav>
</header>

<main class="contenedor pagina-carrito">

    <section class="pagina-encabezado">
        <span class="etiqueta">FINALIZAR PEDIDO</span>
        <h1>Confirmar compra</h1>
        <p>Revisa tu pedido antes de completar la compra.</p>
    </section>

    <?php if (!empty($resultado)): ?>

        <?php if ($resultado['exito']): ?>

            <section class="estado-vacio carrito-vacio">
                <div class="icono-vacio">✓</div>

                <h2>¡Compra realizada correctamente!</h2>

                <p>
                    Tu pedido ha sido registrado exitosamente.
                </p>

                <h3>
                    Número de venta:
                    #<?= (int)$resultado['venta_id'] ?>
                </h3>

                <h2 class="precio">
                    Total: S/
                    <?= number_format($resultado['total'], 2) ?>
                </h2>

                <a href="index.php?ruta=historial"
                   class="btn btn-primario">
                    Ver mis compras
                </a>

                <a href="index.php?ruta=catalogo"
                   class="btn btn-secundario">
                    Seguir comprando
                </a>
            </section>

        <?php else: ?>

            <div class="alerta">
                <?= htmlspecialchars($resultado['mensaje']) ?>
            </div>

            <a href="index.php?ruta=carrito"
               class="btn btn-secundario">
                Regresar al carrito
            </a>

        <?php endif; ?>

    <?php elseif (empty($_SESSION['carrito'])): ?>

        <section class="estado-vacio">
            <h2>No tienes productos para comprar</h2>
            <a href="index.php?ruta=catalogo"
               class="btn btn-primario">
                Explorar productos
            </a>
        </section>

    <?php else: ?>

        <div class="carrito-layout">

            <section class="carrito-productos">
                <h2>Productos seleccionados</h2>

                <div class="carrito-tabla-contenedor">
                    <table class="tabla-carrito">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach (
                                $_SESSION['carrito'] as $item
                            ): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($item['nombre']) ?>
                                    </td>

                                    <td>
                                        S/ <?= number_format(
                                            $item['precio'], 2
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int)$item['cantidad'] ?>
                                    </td>

                                    <td>
                                        S/ <?= number_format(
                                            $item['precio'] *
                                            $item['cantidad'], 2
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="resumen-compra">
                <span class="etiqueta">RESUMEN FINAL</span>
                <h2>Tu pedido</h2>

                <div class="resumen-fila">
                    <span>Cliente</span>
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['nombre'] ?? ''
                        ) ?>
                    </strong>
                </div>

                <div class="resumen-separador"></div>

                <div class="resumen-total">
                    <span>Total estimado</span>
                    <strong>
                        S/ <?= number_format($total, 2) ?>
                    </strong>
                </div>

                <form method="POST"
                      action="index.php?ruta=confirmar">

                    <button type="submit"
                            class="btn btn-primario btn-comprar">
                        Realizar compra
                    </button>
                </form>

                <a href="index.php?ruta=carrito"
                   class="btn btn-secundario">
                    Volver al carrito
                </a>

                <p class="resumen-nota">
                    El precio y el stock se comprobarán
                    nuevamente en MySQL antes de registrar
                    la venta.
                </p>
            </aside>

        </div>

    <?php endif; ?>

</main>

<footer class="pie-pagina">
    <div class="contenedor">
        <p>TECHSTORE © <?= date('Y') ?></p>
    </div>
</footer>

</body>
</html>
