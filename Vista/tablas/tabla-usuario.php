<?php
require_once __DIR__ . "/../../Controlador/usuario-controller.php";
require_once __DIR__ . "/../../Modelo/usuario.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

if (!$admin) {
    header("Location: /Vista/fichas/ficha-usuario.php");
    exit;
}

$usuarios = getUsuarios();
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
                                        <a href="/Vista/fichas/ficha-usuario.php?id=<?= urlencode($usuario->id) ?>" style="text-decoration:none;">
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
            </div>
        </main>
    </div>
</body>

</html>