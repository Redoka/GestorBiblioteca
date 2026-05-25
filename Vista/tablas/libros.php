<?php
require_once __DIR__ . "/../../controlador/libro-controller.php";
require_once __DIR__ . "/../../modelo/usuario.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

$pagina = $_GET['pagina'] ?? 1;
$pagina = max(1, (int)$pagina);

$porPagina = 10;

$offset = ($pagina - 1) * $porPagina;

$totalLibros = 0;
$totalPaginas = 0;

if ($admin) {
    $totalLibros = countLibros();
    $libros =  getLibros($porPagina, $offset);
    $totalPaginas = ceil($totalLibros / $porPagina);
} else {
    $totalLibros = countLibrosUsuario();
    $totalPaginas = ceil($totalLibros / $porPagina);
    $libros = getLibrosDisponibles($porPagina, $offset);
}

if (isset($_GET['deleted'])) {
    echo "<script>alert('Se ha borrado correctamente');</script>";
    header("Location: /vista/tablas/libros.php");
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

            <a href="/vista/tablas/historial.php">Historial</a>
            <a href="/vista/tablas/libros.php">Libros</a>
            <?php
            if ($admin) {
                echo "<a href='/vista/tablas/descatalogado.php'>Descatalogados</a>";
                echo "<a href='/vista/tablas/usuarios.php'>Usuarios</a>";
            }
            ?>
            <a href="/vista/fichas/usuario.php">Mi usuario</a>
        </aside>
        <main class="content">
            <div class="card">

                <h1>Listado de libros</h1>
                <?php
                if ($admin) {
                    echo "<div class=\"add-container\">
                <a href=\"/vista/formularios/libro.php\" class=\"add-button\">
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
                                                echo "<a class=\"delete-button\" href=\"/intermedio/descatalogar.php?id=$libro->id\">×</a>";
                                                echo "<form action='/vista/formularios/libro.php' method='POST' style='display:flex;'>
                                                            <input type='hidden' name='id' value='{$libro->id}'>
                                                             <input type='hidden' name='editar' value='true'>
                                                            <button type='submit' class='edit-button'>✎</button>
                                                        </form>";
                                            }
                                            ?>
                                            <a class="loan-button" href="/intermedio/prestar.php?id=<?= $libro->id ?>&usuario=<?= $usuario->id ?>">📖</a>
                                        </div>
                                    </td>

                                    <td>
                                        <a href="/vista/fichas/libro.php?id=<?= urlencode($libro->id) ?>" style="text-decoration:none;">
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

                <div class="pagination">

                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?= $pagina - 1 ?>">←</a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>

                        <a href="?pagina=<?= $i ?>"
                            class="<?= $i == $pagina ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>

                    <?php endfor; ?>

                    <?php if ($pagina < $totalPaginas): ?>
                        <a href="?pagina=<?= $pagina + 1 ?>">→</a>
                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>

</body>

</html>