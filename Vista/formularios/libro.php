<?php

require_once __DIR__ . "/../../controlador/libro-controller.php";
require_once __DIR__ . "/../../controlador/categoria-controller.php";
require_once __DIR__ . "/../../modelo/usuario.php";
require_once __DIR__ . "/../../modelo/categoria.php";

session_start();
$usuario = unserialize($_SESSION['usuario']);
$admin = $usuario->tipoUsuario == 1;

if (!$admin) {
    header("Location: /vista/tablas/libros.php");
    exit;
}

$categorias = getCategorias();

$libro = "";
$editar = $_POST['editar'] ?? false;
$editando = false;
if ($editar) {

    $editado = $_POST['editado'] ?? false;
    if ($editado) {
        if (updateLibro($_POST)) {
            echo "<script>alert('Se ha editado el libro');</script>";
        } else {
            echo "<script>alert('Error al editar el libro');</script>";
        }
    }

    $id = $_POST['id'] ?? null;

    if (!$id) {
        die("ID no proporcionado");
    }

    $libro = getLibrobyId($_POST);
    $editando = isset($libro);

    if ($editado) {
        header("Location: /vista/fichas/libro.php?id=" . urlencode($libro->id));
        exit;
    }
} else {
    if (isset($_POST["isbn"])) {
        $b = true;
        for ($i = 0; $i < $_POST["cantidad"]; $i++) {
            $b = setLibros($_POST);
            if (!$b) {
                break;
            }
        }
        if ($b) {
            echo "<script>alert('Se ha añadido el libro');</script>";
        } else {
            echo "<script>alert('Error al añadir el libro');</script>";
        }

        $_POST = [];
    }
}
?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Libro</title>
    <link rel="stylesheet" href="/estilo.css">
</head>

<body>

    <div class="container">

        <h2><?= $editando ? "Editar Libro" : "Crear Libro" ?></h2>

        <form action="/vista/formularios/libro.php" method="POST">

            <?php if ($editando): ?>
                <input type="hidden" name="id" value="<?= $libro->id ?>">
            <?php endif; ?>

            <input type="text" name="isbn" placeholder="ISBN"
                value="<?= $libro->isbn ?? '' ?>" required>

            <input type="text" name="titulo" placeholder="Título"
                value="<?= $libro->titulo ?? '' ?>" required>

            <input type="text" name="autor" placeholder="Autor"
                value="<?= $libro->autor ?? '' ?>" required>

            <input type="text" name="descripcion" placeholder="Descripcion"
                value="<?= $libro->descripcion ?? '' ?>">

            <input type="date" name="fechaDePublicacion"
                value="<?= isset($libro->fechaDePublicacion) && $libro->fechaDePublicacion instanceof DateTime
                            ? $libro->fechaDePublicacion->format('Y-m-d')
                            : '' ?>" required>

            <input type="number" name="cantidad" min="1"
                value="<?= $libro->cantidad ?? 1 ?>" required>

            <?php
            if ($editar) {
                echo "<input type='hidden' name='editar' value='true'>";
                echo "<input type='hidden' name='editado' value='true'>";
            }
            ?>

            <button type="submit">
                <?= $editando ? "Actualizar libro" : "Guardar libro" ?>
            </button>

        </form>

        <a href="/vista/tablas/libros.php">Volver</a>

    </div>

</body>

</html>