<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../Modelo/libro.php";

function getLibros(): array
{
    $libros = [];
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT id, isbn, titulo, autor, fechapublicacion
            FROM libro";

    $stmt = $PDO->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $libro = new libro();

        $libro->id = (int) $row['id'];
        $libro->isbn = $row['isbn'];
        $libro->titulo = $row['titulo'];
        $libro->autor = $row['autor'];

        $libro->fechaDePublicacion = new DateTime($row['fechapublicacion']);

        $libros[] = $libro;
    }

    return $libros;
}

function getLibrosDisponibles(): array
{
    $libros = [];
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT id, isbn, titulo, autor, fechapublicacion
            FROM  libro 
            WHERE id not in ( SELECT idlibro From historiallibro where fechaentrega is null)";

    $stmt = $PDO->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $libro = new libro();

        $libro->id = (int) $row['id'];
        $libro->isbn = $row['isbn'];
        $libro->titulo = $row['titulo'];
        $libro->autor = $row['autor'];

        $libro->fechaDePublicacion = new DateTime($row['fechapublicacion']);

        $libros[] = $libro;
    }

    return $libros;
}

function getLibrobyId($post): libro
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        die();
    }

    $sql = "SELECT id, isbn, titulo, autor, fechapublicacion
            FROM libro
            WHERE id = ?";

    $stmt = $PDO->prepare($sql);

    $stmt->execute([
        $post['id']
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $libro = new libro();

    $libro->id = (int) $row['id'];
    $libro->isbn = $row['isbn'];
    $libro->titulo = $row['titulo'];
    $libro->autor = $row['autor'];
    $libro->fechaDePublicacion = new DateTime($row['fechapublicacion']);

    return $libro;
}


function setLibros($post): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    $sql = "INSERT INTO libro (isbn, titulo, autor, fechapublicacion)
            VALUES (?, ?, ?, ?)";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([
        $post["isbn"],
        $post["titulo"],
        $post["autor"],
        $post["fechaDePublicacion"] instanceof DateTime
            ? $post["fechaDePublicacion"]->format('Y-m-d')
            : $post["fechaDePublicacion"]
    ]);

    return $ok;
}

function deleteLibro(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    $sql = "Delete From libro where id = ?";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([
        $id
    ]);

    return $ok;
}

// ToDo: implementar update en un futuro
