<?php
require_once __DIR__ . "/../../controlador/descatalogado-controller.php";
require_once __DIR__ . "/../../modelo/usuario.php";

session_start();

$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;


$pagina = $_GET['pagina'] ?? 1;
$pagina = max(1, (int)$pagina);

$porPagina = 10;

$offset = ($pagina - 1) * $porPagina;
$totalLibros = countDescatalogado();
$totalPaginas = ceil($totalLibros / $porPagina);

if (!$admin) {
    header("Location: /vista/tablas/libros.php");
    exit;
}

$descatalogados = getDescatalogados($porPagina, $offset);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Libros descatalogados</title>
    <link rel="stylesheet" href="/estilo.css">
</head>

<body>

    <div class="layout">

        <aside class="sidebar">
            <h1>Menú</h1>

            <a href="/vista/tablas/historial.php">Historial</a>
            <a href="/vista/tablas/libros.php">Libros</a>
            <?php if ($admin): ?>
                <a href="/vista/tablas/descatalogado.php">Descatalogados</a>
                <a href="/vista/tablas/usuarios.php">Usuarios</a>
            <?php endif; ?>
            <a href="/vista/fichas/usuario.php">Mi usuario</a>


        </aside>

        <main class="content">

            <div class="card">

                <h1>Libros descatalogados</h1>

                <table>

                    <thead>
                        <tr>
                            <th> </th>
                            <th>ID</th>
                            <th>ISBN</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Fecha publicación</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($descatalogados)): ?>

                            <?php foreach ($descatalogados as $d): ?>

                                <tr>

                                    <td>

                                        <div class="acciones">

                                            <form action="/intermedio/catalogar.php" method="POST">

                                                <input type="hidden"
                                                    name="id"
                                                    value="<?= $d->id ?>">

                                                <button type="submit"
                                                    class="delete-button">
                                                    ×
                                                </button>
                                            </form>

                                        </div>

                                    </td>

                                    <td>
                                        <span class="badge">
                                            <?= $d->idLibro->id ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= $d->idLibro->isbn ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= $d->idLibro->titulo ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= $d->idLibro->autor ?>
                                    </td>

                                    <td>
                                        <?= $d->idLibro->fechaDePublicacion instanceof DateTime
                                            ? $d->idLibro->fechaDePublicacion->format('d-m-Y')
                                            : $d->idLibro->fechaDePublicacion ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6" class="empty">
                                    No hay libros descatalogados
                                </td>
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