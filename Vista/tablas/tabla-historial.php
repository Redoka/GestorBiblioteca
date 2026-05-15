<?php
require_once __DIR__ . "/../../Controlador/historial-controller.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$historial = array();
$admin = $usuario->tipoUsuario == 1;
if ($admin) {
    $historial = getHistorial();
} else {
    $historial = getHistorialByIdUsuario($usuario->id);
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de préstamos</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, Arial, sans-serif;
            background: #f6f7fb;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #1f2937;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar h1 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* CONTENIDO */
        .content {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        thead {
            background: #4f46e5;
            color: white;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f3f4f6;
        }

        tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 12px;
        }

        .return-button {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 20px;
            height: 20px;

            background: #10b981;
            /* verde devolución */
            color: white;

            font-size: 18px;
            font-weight: bold;
            text-decoration: none;

            border-radius: 50%;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);

            transition: all 0.2s ease;
            user-select: none;
        }

        .return-button:hover {
            background: #059669;
            transform: scale(1.1);
        }

        .return-button:active {
            transform: scale(0.95);
        }
    </style>

</head>

<body>

    <div class="layout">

        <aside class="sidebar">
            <h1>Menú</h1>

            <a href="tabla-historial.php">Historial</a>
            <a href="tabla-libro.php">Libros</a>
            <a href="/Vista/fichas/ficha-usuario.php">Mi usuario</a>
            <?php if ($admin) {
                echo "<a href=\"/Vista/tablas/tabla-usuario.php\">Usuarios</a>";
            } ?>
        </aside>

        <main class="content">

            <div class="card">

                <h1>Préstamos</h1>

                <table>

                    <thead>
                        <tr>
                            <th> </th>
                            <th>ID Libro</th>
                            <th>Nombre Libro</th>
                            <th>ID Usuario</th>
                            <th>Nombre Usuario</th>
                            <th>Fecha Préstamo</th>
                            <th>Fecha Entrega</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $h): ?>
                                <tr>
                                    <td>
                                        <?php if ($h->fechaEntrega === null): ?>
                                            <a class="return-button" href="/intermedio/return.php?id=<?= $h->id ?>">
                                                ↩
                                            </a>
                                        <?php
                                        endif; ?>
                                    </td>

                                    <td>
                                        <a href="/Vista/fichas/ficha-libro.php?id=<?= urlencode($h->idLibro->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $h->idLibro->id ?></span>
                                        </a>
                                    </td>

                                    <td><?= htmlspecialchars($h->idLibro->titulo) ?></td>

                                    <td>
                                        <a href="/Vista/fichas/ficha-usuario.php?id=<?= urlencode($h->idUsuario->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $h->idUsuario->id ?></span>
                                        </a>
                                    </td>

                                    <td><?= $h->idUsuario->nombre ?></td>

                                    <td>
                                        <?= $h->fechaPrestamo instanceof DateTime
                                            ? $h->fechaPrestamo->format('Y-m-d')
                                            : $h->fechaPrestamo
                                        ?>
                                    </td>

                                    <td>
                                        <?= $h->fechaEntrega instanceof DateTime
                                            ? $h->fechaEntrega->format('Y-m-d')
                                            : $h->fechaEntrega
                                        ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="empty">No hay historial disponible</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>

        </main>

    </div>

</body>

</html>