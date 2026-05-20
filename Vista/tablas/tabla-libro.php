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
    <link rel="stylesheet" href="/estilo.css">

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
        <main class="content">
            <div class="card">

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
                                                echo "<form action='/Vista/formularios/crear-libro.php' method='POST' style='display:flex;'>
                                                            <input type='hidden' name='id' value='{$libro->id}'>
                                                             <input type='hidden' name='editar' value='true'>
                                                            <button type='submit' class='edit-button'>✎</button>
                                                        </form>";
                                            }
                                            ?>
                                            <a class="loan-button" href="/intermedio/lend.php?id=<?= $libro->id ?>&usuario=<?= $usuario->id ?>">📖</a>
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
        </main>
    </div>

</body>

</html>