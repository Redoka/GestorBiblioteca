<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../modelo/categoria.php";



function getCategorias(): array
{
    $categorias = [];
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT id, descripcion
            FROM categoria";

    $stmt = $PDO->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {


        $categoria = new Categoria($row['id'], $row['descripcion']);
        $categorias[] = $categoria;
    }

    return $categorias;
}


function setCategoria(int $idLibro, int $idCategoria): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    $sql = "INSERT INTO libro_categoria (idlibro, idcategoria)
            VALUES (?, ?)";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([$idLibro, $idCategoria]);

    return $ok;
}
