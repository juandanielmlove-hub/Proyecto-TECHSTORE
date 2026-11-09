
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis compras | TECHSTORE</title>
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
            <a href="index.php?ruta=historial" class="activo">
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
        <span class="etiqueta">MIS PEDIDOS</span>
        <h1>Historial de compras</h1>
        <p>Consulta todas tus compras realizadas.</p>
    </section>

    <?php if (empty($ventas)): ?>

        <section class="estado-vacio carrito-vacio">
            <div class="icono-vacio">◇</div>
            <h2>Aún no tienes compras</h2>
            <p>Tu historial aparecerá aquí cuando compres.</p>

            <a href="index.php?ruta=catalogo"
               class="btn btn-primario">
                Ir al catálogo
            </a>
        </section>

    <?php else: ?>

        <?php foreach ($ventas as $venta): ?>

            <article class="resumen-compra historial-venta">

                <div class="seccion-encabezado">
                    <div>
                        <span class="etiqueta">PEDIDO REGISTRADO</span>

                        <h2>
                            Compra #<?= (int)$venta['id'] ?>
                        </h2>

                        <p>
                            Fecha:
                            <?= htmlspecialchars($venta['fecha']) ?>
                        </p>
                    </div>

                    <strong class="precio">
                        S/ <?= number_format($venta['total'], 2) ?>
                    </strong>
                </div>

                <?php
                    $detalles = $controller->detalle(
                        $venta['id']
                    );
                ?>

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
                            <?php foreach ($detalles as $item): ?>
                                <tr>
                                    <td>
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
                                        <?= (int)$item['cantidad'] ?>
                                    </td>

                                    <td>
                                        S/ <?= number_format(
                                            $item['subtotal'], 2
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="resumen-total">
                    <span>Total de la compra</span>
                    <strong>
                        S/ <?= number_format($venta['total'], 2) ?>
                    </strong>
                </div>

            </article>

        <?php endforeach; ?>

    <?php endif; ?>

</main>

<footer class="pie-pagina">
    <div class="contenedor">
        <p>TECHSTORE © <?= date('Y') ?></p>
    </div>
</footer>

</body>
</html>
