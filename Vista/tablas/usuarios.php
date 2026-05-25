<?php
require_once __DIR__ . "/../../controlador/usuario-controller.php";
require_once __DIR__ . "/../../modelo/usuario.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

$pagina = $_GET['pagina'] ?? 1;
$pagina = max(1, (int)$pagina);

$porPagina = 10;

$offset = ($pagina - 1) * $porPagina;
$totalUsuarios = countUsuarios();
$totalPaginas = ceil($totalUsuarios / $porPagina);


if (!$admin) {
    header("Location: /vista/fichas/usuario.php");
    exit;
}

$usuarios = getUsuarios($porPagina, $offset);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de usuarios</title>
    <link rel="stylesheet" href="/estilo.css">
</head>

<body>
    <div class="layout">
        <aside class="sidebar">
            <h1>Menú</h1>
            <a href="historial.php">Historial</a>
            <a href="libros.php">Libros</a>
            <?php
            echo "<a href='descatalogado.php'>Descatalogados</a>";
            echo "<a href='usuarios.php'>Usuarios</a>";
            ?>
            <a href="/vista/fichas/usuario.php">Mi usuario</a>
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

                            <th>fecha de Nacimiento</th>
                            <th>direccion</th>
                            <th>email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td>
                                        <a href="/vista/fichas/usuario.php?id=<?= urlencode($usuario->id) ?>" style="text-decoration:none;">
                                            <span class="badge"><?= $usuario->id ?></span>
                                        </a>
                                    </td>
                                    <td><?= $usuario->dni ?></td>
                                    <td><?= $usuario->nombre ?></td>
                                    <td><?= $usuario->usuario ?></td>
                                    <td><?= $usuario->fechaNacimiento instanceof DateTime
                                            ? $usuario->fechaNacimiento->format('d-m-Y')
                                            : $usuario->fechaNacimiento ?></td>
                                    <td><?= $usuario->contacto->domicilio ?></td>
                                    <td><?= $usuario->contacto->email ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty">No hay usuarios disponibles</td>
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