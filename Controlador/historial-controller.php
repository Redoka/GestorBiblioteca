
<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../Modelo/historialLibro.php";

function getHistorial(): array
{
    $historial = array();
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        $sql = "SELECT hl.id AS id,
                       hl.idlibro AS idLibro,
                       l.titulo AS titulo,
                       hl.idusuario AS idUsuario,
                       u.nombre AS nombreUsuario,
                       hl.fechaprestamo AS fechaPrestamo,
                       hl.fechaentrega AS fechaEntrega
                FROM `libro` l 
                Inner join historiallibro hl ON hl.idlibro = l.id
                INNER JOIN usuario u ON u.id = hl.idusuario";
        $stmt = $PDO->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $historial = [];

        foreach ($data as $row) {
            $historial[] = mapHistorial($row);
        }
    } else {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
    }

    return $historial;
}

function getHistorialByIdUsuario(int $id): array
{
    $historial = array();
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        $sql = "SELECT  hl.id AS id,
                        hl.idlibro AS idLibro,
                        l.titulo AS titulo,
                        hl.idusuario AS idUsuario,
                        u.nombre AS nombreUsuario,
                        hl.fechaprestamo AS fechaPrestamo,
                        hl.fechaentrega AS fechaEntrega 
                FROM `libro` l 
                Inner join historiallibro hl ON hl.idlibro = l.id
                INNER JOIN usuario u ON u.id = hl.idusuario
                where hl.idusuario = {$id}";
        $stmt = $PDO->query($sql);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $historial = [];

        foreach ($data as $row) {
            $historial[] = mapHistorial($row);
        }
    } else {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
    }

    return $historial;
}



function setHistorial(int $idLibro, int $idUser): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        if (estaPrestado($idLibro)) {
            echo "<script>alert('Ese libro ya esta prestado');</script>";
            return false;
        }
        $sql = "INSERT INTO historiallibro (idlibro, idusuario, fechaprestamo, fechaentrega)
                VALUES (?,?,now(), null)";

        $stmt = $PDO->prepare($sql);
        $b = $stmt->execute([$idLibro, $idUser]);
        if ($b) {
            echo "<script>alert('Se ha reservado');</script>";
            return true;
        }
    }

    echo "<script>alert('Error al conectarse con la base de datos');</script>";
    return false;
}

function deleteRegistro(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return false;
    }

    $sql = "Delete From historiallibro where id = ?";
    $stmt = $PDO->prepare($sql);
    $stmt->execute([
        $id
    ]);

    return $stmt->fetch() !== false;
}

function devolver(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return false;
    }

    $sql = "UPDATE historiallibro set fechaentrega = now() where id = ?";

    $stmt = $PDO->prepare($sql);

    $stmt->execute([
        $id
    ]);

    return $stmt->fetch() !== false;
}

function estaPrestado(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return false;
    }

    $sql = "Select 1 From historiallibro where idlibro = ? and fechaentrega is null";

    $stmt = $PDO->prepare($sql);

    $stmt->execute([
        $id
    ]);

    return $stmt->fetch() !== false;
}

function mapHistorial(array $row): historialLibro
{
    $id = $row['id'];
    // crear libro
    $libro = new libro();
    $libro->id = $row['idLibro'];
    $libro->titulo = $row['titulo'];

    // crear usuario
    $usuario = new usuario();
    $usuario->id = $row['idUsuario'];
    $usuario->nombre = $row['nombreUsuario'];

    // fechas
    $fechaPrestamo = new DateTime($row['fechaPrestamo']);
    $fechaEntrega = $row['fechaEntrega'] !== null ? new DateTime($row['fechaEntrega']) : null;

    // AHORA sí: constructor completo
    return new historialLibro(
        $id,
        $libro,
        $usuario,
        $fechaPrestamo,
        $fechaEntrega
    );
}
?>
