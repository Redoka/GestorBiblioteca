<?php

require_once __DIR__ . "/../../Controlador/usuario-controller.php";
require_once __DIR__ . "/../../Modelo/usuario.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

$usuario = null;
$editar = $_POST['editar'] ?? false;
if ($editar) {
    $editado = $_POST['editado'] ?? false;
    if ($editado) {
        if (updateUsuario($_POST)) {
            echo "<script>alert('Se ha editado el usuario');</script>";
        } else {
            echo "<script>alert('Error al editar el usuario');</script>";
        }
    }

    $usuario = getUsuariobyId($_POST);
    if ($editado) {
        if ($admin) {
            header("Location: /Vista/fichas/ficha-usuario.php?id=" . urlencode($usuario->id));
            exit;
        } else {
            header("Location: /Vista/fichas/ficha-usuario.php");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="/estilo.css">
</head>

<body>

    <div class="container">


        <?php
        if ($editar) {
            echo "<h2>Editar Usuario</h2>";
            echo "<form action='/Vista/formularios/crear-usuario.php' method='POST'>";
        } else {
            echo "<h2>Registrar Usuario</h2>";
            echo "<form action='/Vista/login.php' method='POST'>";
        }
        ?>
        <input type="hidden" name="id" value="<?= $usuario->id ?? '' ?>">

        <input type="text" name="dni"
            placeholder="Nº Identificación"
            value="<?= $usuario->dni ?? '' ?>"
            required>

        <input type="text" name="nombre"
            placeholder="Nombre completo"
            value="<?= $usuario->nombre ?? '' ?>"
            required>

        <input type="text" name="telefono"
            placeholder="Teléfono o contacto"
            value="<?= $usuario->contacto->telefono ?? '' ?>"
            required>

        <input
            type="text"
            name="domicilio"
            placeholder="Domicilio"
            value="<?= $usuario->contacto?->domicilio ?? '' ?>"
            required>

        <input
            type="email"
            name="email"
            placeholder="Correo electrónico"
            value="<?= $usuario->contacto?->email ?? '' ?>"
            required>

        <input type="text" name="usuario"
            placeholder="Usuario"
            value="<?= $usuario->usuario ?? '' ?>"
            required>

        <input type="text" name="contrasena"
            placeholder="Contraseña"
            value="<?= $usuario->contraseña ?? '' ?>"
            required>

        <input
            type="date"
            name="fechaNacimiento"
            value="<?= isset($usuario->fechaNacimiento) && $usuario->fechaNacimiento instanceof DateTime
                        ? $usuario->fechaNacimiento->format('Y-m-d')
                        : '' ?>">

        <?php
        if ($editar) {
            echo "<input type='hidden' name='id' value='{$usuario->id}'>
                  <input type='hidden' name='editar' value='true'>
                  <input type='hidden' name='editado' value='true'>";
        } else {
            echo "<input type='hidden' name='registrar' value='true'>";
        }
        ?>


        <button type="submit">
            <?= isset($usuario) ? 'Guardar cambios' : 'Registrar' ?>
        </button>

        </form>

        <?php
        if (!$editar) {
            echo "<div class='login-link'>
                        <a href='/Vista/login.php'>Ya tengo cuenta</a>
                     </div>";
        }
        ?>


    </div>

</body>

</html>