<?php
require_once("baseDatos.php");
require_once("categoria-controller.php");
require_once __DIR__ . "/../modelo/libro.php";

function getLibros(int $limit, int $offset): array
{
    $libros = [];

    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT l.id, l.isbn, l.titulo, l.autor, l.fechapublicacion
        FROM libro l
        LEFT JOIN descatalogado d ON d.idlibro = l.id
        WHERE d.idlibro IS NULL
        LIMIT ? OFFSET ?";

    $stmt = $PDO->prepare($sql);

    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $libro = new libro(
            $row['id'],
            $row['isbn'],
            $row['titulo'],
            $row['autor'],
            new DateTime($row['fechapublicacion']),
            ""
        );

        $libros[] = $libro;
    }

    return $libros;
}

function getLibrosDisponibles(int $limit, int $offset): array
{
    $libros = [];

    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT DISTINCT l.id, l.isbn, l.titulo, l.autor, l.fechapublicacion
        FROM libro l
        LEFT JOIN descatalogado d ON d.idlibro = l.id
        LEFT JOIN historiallibro h ON h.idlibro = l.id AND h.fechaentrega IS NULL
        WHERE d.idlibro IS NULL
          AND h.idlibro IS NULL
        LIMIT ? OFFSET ?";

    $stmt = $PDO->prepare($sql);

    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->bindValue(2, $offset, PDO::PARAM_INT);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $libro = new libro(
            $row['id'],
            $row['isbn'],
            $row['titulo'],
            $row['autor'],
            new DateTime($row['fechapublicacion']),
            ""
        );

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

    $sql = "SELECT id, isbn, titulo, autor, fechapublicacion, descripcion
            FROM libro
            WHERE id = ?";

    $stmt = $PDO->prepare($sql);

    $stmt->execute([
        $post['id']
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $libro = new libro($row['id'], $row['isbn'], $row['titulo'], $row['autor'], new DateTime($row['fechapublicacion']), $row['descripcion']);

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

    $sql = "INSERT INTO libro (isbn, titulo, autor, fechapublicacion, descripcion)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([
        $post["isbn"],
        $post["titulo"],
        $post["autor"],
        $post["fechaDePublicacion"] instanceof DateTime
            ? $post["fechaDePublicacion"]->format('Y-m-d')
            : $post["fechaDePublicacion"],
        $post["descripcion"]
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

function descatalogarLibro(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }
    $sql = "INSERT INTO descatalogado(idlibro) VALUES (?)";
    $stmt = $PDO->prepare($sql);
    $ok = $stmt->execute([$id]);
    return $ok;
}

function updateLibro($post): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    try {
        $PDO->beginTransaction();
        $sql = "
            UPDATE libro
            SET
                isbn = ?,
                titulo = ?,
                autor = ?,
                fechapublicacion = ?,
                descripcion = ?
            WHERE id = ?
        ";

        $stmt = $PDO->prepare($sql);

        $stmt->execute([
            $post["isbn"],
            $post["titulo"],
            $post["autor"],
            $post["fechaDePublicacion"] instanceof DateTime
                ? $post["fechaDePublicacion"]->format('Y-m-d')
                : $post["fechaDePublicacion"],
            $post["descripcion"],
            $post["id"]
        ]);

        $PDO->commit();
        return true;
    } catch (Exception $e) {
        $PDO->rollBack();
        return false;
    }
}

function countLibros(): int
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return 0;
    }

    $sql = "SELECT COUNT(l.id) FROM libro l 
            LEFT JOIN descatalogado d ON d.idlibro = l.id
            WHERE d.idlibro IS NULL";

    return (int)$PDO->query($sql)->fetchColumn();
}

function countLibrosUsuario(): int
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return 0;
    }

    $sql = "SELECT COUNT(DISTINCT l.id)
            FROM libro l
            LEFT JOIN descatalogado d ON d.idlibro = l.id
            LEFT JOIN historiallibro h ON h.idlibro = l.id AND h.fechaentrega IS NULL
            WHERE d.idlibro IS NULL
            AND h.idlibro IS NULL";

    return (int)$PDO->query($sql)->fetchColumn();
}
