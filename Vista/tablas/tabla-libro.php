<?php
require_once __DIR__ . "/../../Controlador/libro-controller.php";
require_once __DIR__ . "/../../Modelo/usuario.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

if ($admin) {
    $libros = getLibros();
} else {
    $libros = getLibrosDisponibles();
}

if (isset($_GET['deleted'])) {
    echo "<script>alert('Se ha borrado correctamente');</script>";
    header("Location: /Vista/tablas/tabla-libro.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de libros</title>

    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: #f6f7fb;
            color: #1f2937;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

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
            transition: 0.2s;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .content {
            flex: 1;
            padding: 30px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }

        thead {
            background: #4f46e5;
            color: white;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            font-size: 14px;
        }

        tbody tr {
            border-bottom: 1px solid #eee;
            transition: background 0.2s ease;
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

        .add-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .add-button {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 45px;
            height: 45px;

            background: #4f46e5;
            color: white;

            font-size: 26px;
            font-weight: bold;
            text-decoration: none;

            border-radius: 50%;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);

            transition: all 0.2s ease;
            user-select: none;
        }

        .add-button:hover {
            background: #3730a3;
            transform: scale(1.1);
        }

        .add-button:active {
            transform: scale(0.95);
        }

        .add-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 15px;
        }

        .delete-button {
            display: flex;
            justify-content: center;
            align-items: center;

            width: 22px;
            height: 22px;

            background: #ef4444;
            color: white;

            font-size: 24px;
            font-weight: bold;
            text-decoration: none;

            border-radius: 50%;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);

            transition: all 0.2s ease;
            user-select: none;
        }

        .delete-button:hover {
            background: #b91c1c;
            transform: scale(1.1);
        }

        .delete-button:active {
            transform: scale(0.95);
        }

        .acciones {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>

</head>

<body>

    <div class="layout">

        <aside class="sidebar">
            <h1>Menú</h1>

            <a href="/Vista/tablas/tabla-historial.php">Historial</a>
            <a href="/Vista/tablas/tabla-libro.php">Libros</a>
            <a href="/Vista/fichas/ficha-usuario.php">Mi usuario</a>
            <?php if ($admin) {
                echo "<a href=\"/Vista/tablas/tabla-usuario.php\">Usuarios</a>";
            } ?>
        </aside>

        <div class="container">

            <h1>Listado de libros</h1>
            <?php
            if ($admin) {
                echo "<div class=\"add-container\">
                <a href=\"/Vista/formularios/crear-libro.php\" class=\"add-button\">
                    +
                </a>
            </div>";
            } ?>

            <table>
                <thead>
                    <tr>
                        <th> </th>
                        <th>ID</th>
                        <th>ISBN</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Fecha de publicación</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($libros)): ?>
                        <?php foreach ($libros as $libro): ?>
                            <tr>
                                <td>
                                    <div class="acciones">
                                        <?php

                                        if ($admin) {
                                            echo "<a class=\"delete-button\" href=\"/intermedio/deleted.php?id=$libro->id\">×</a>";
                                        }
                                        ?>
                                        <a class="loan-button" href="/intermedio/lend.php?id=<?= $libro->id ?>&usuario=<?=$usuario->id ?>">📖</a>
                                    </div>
                                </td>

                                <td>
                                    <a href="/Vista/fichas/ficha-libro.php?id=<?= urlencode($libro->id) ?>" style="text-decoration:none;">
                                        <span class="badge"><?= $libro->id ?></span>
                                    </a>
                                </td>
                                <td><?= $libro->isbn ?></td>
                                <td><strong><?= $libro->titulo ?></strong></td>
                                <td><?= $libro->autor ?></td>
                                <td>
                                    <?= $libro->fechaDePublicacion instanceof DateTime
                                        ? $libro->fechaDePublicacion->format('d-m-Y')
                                        : $libro->fechaDePublicacion
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty">No hay libros disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>