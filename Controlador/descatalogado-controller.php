<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../Modelo/descatalogado.php";


function getDescatalogados(): array
{
    $descatalogados = [];
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT d.id, l.id as idLibro, l.isbn, l.titulo, l.autor, l.fechapublicacion  
                    FROM descatalogado d
            Inner Join libro l On l.id = d.idlibro";

    $stmt = $PDO->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {


        $libro = new libro($row['idLibro'], $row['isbn'], $row['titulo'], $row['autor'], new DateTime($row['fechapublicacion']), "");

        $descatalogado = new descatalogado($row['id'], $libro);

        $descatalogados[] = $descatalogado;
    }

    return $descatalogados;
}


function deleteDescatalogado(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    $sql = "Delete From descatalogado where id = ?";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([
        $id
    ]);

    return $ok;
}
