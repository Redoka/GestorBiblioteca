<?php
require_once __DIR__ . "/../../Controlador/usuario-controller.php";
$usuarios = getUsuarios();
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de usuarios</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #111827;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar h1 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.08);
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        /* CONTENIDO */
        .content {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .title {
            font-size: 28px;
            margin-bottom: 20px;
        }

        /* TABLA */
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 12px;
        }

        thead {
            background: #111827;
            color: white;
        }

        th {
            padding: 14px;
            text-align: left;
            font-size: 14px;
        }

        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            background: white;
        }

        tr:hover td {
            background: #f9fafb;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: #e0e7ff;
            color: #3730a3;
            font-size: 12px;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
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
            <a href="tabla-usuario.php">Usuarios</a>
        </aside>
        <main class="content">
            <div class="card">
                <div class="title">Usuarios</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td>
                                        <a href="/Vista/fichas/ficha-usuario.php?id=<?= urlencode($usuario->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $usuario->id ?></span>
                                        </a>
                                    </td>                                                                                       
                                    <td><?= $usuario->dni ?></td>
                                    <td><?= $usuario->nombre ?></td>
                                    <td><?= $usuario->usuario ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty">No hay usuarios disponibles</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>

</html>