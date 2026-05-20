<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../Modelo/usuario.php";



function getUsuarios(): array
{
    $usuarios = [];
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return [];
    }

    $sql = "SELECT id, dni, nombre, telefono, domicilio, email, usuario, contraseña, 
                   fechanacimiento, tipousuario as tipoUsuario 
            FROM usuario";

    $stmt = $PDO->query($sql);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {

        $fechaNacimiento = !empty($row['fechanacimiento'])
            ? new DateTime($row['fechanacimiento'])
            : null;

        $contacto = new contacto(
            $row['telefono'],
            $row['domicilio'],
            $row['email']
        );

        $usuarios[] = new usuario(
            (int)$row['id'],
            $row['dni'],
            $row['nombre'],
            $contacto,
            $row['usuario'],
            $row['contraseña'],
            $fechaNacimiento,
            (int)$row['tipoUsuario']
        );
    }

    return $usuarios;
}

function getUsuariobyId($post): ?usuario
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return null;
    }

    $sql = "SELECT 
                id,
                dni,
                nombre,
                telefono,
                domicilio,
                email,
                usuario,
                contraseña,
                tipousuario AS tipoUsuario,
                fechanacimiento
            FROM usuario
            WHERE id = ?";

    $stmt = $PDO->prepare($sql);
    $stmt->execute([$post['id']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    $contacto = new contacto(
        $row['telefono'],
        $row['domicilio'],
        $row['email']
    );

    $fechaNacimiento = !empty($row['fechanacimiento'])
        ? new DateTime($row['fechanacimiento'])
        : null;

    $usuario = new usuario(
        $row['id'],
        $row['dni'],
        $row['nombre'],
        $contacto,
        $row['usuario'],
        $row['contraseña'],
        $fechaNacimiento,
        $row['tipoUsuario']
    );

    return $usuario;
}

function getLogin($post): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return false;
    }

    $sql = "SELECT id
            FROM usuario
            WHERE usuario = ? AND contraseña = ?";

    $stmt = $PDO->prepare($sql);

    $stmt->execute([
        $post['usuario'],
        $post['password']
    ]);

    return $stmt->fetch() !== false;
}

function getUsuarioByLogin($post): ?usuario
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        return null;
    }

    $sql = "SELECT id, dni, nombre, telefono, domicilio, email, usuario, contraseña, fechanacimiento,tipousuario as tipoUsuario 
            FROM usuario 
            WHERE usuario = ? AND contraseña = ? 
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->execute([$post['usuario'], $post['password']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    $fechaNacimiento = !empty($row['fechanacimiento'])
        ? new DateTime($row['fechanacimiento'])
        : null;


    $u = new usuario(
        (int)$row['id'],
        $row['dni'],
        $row['nombre'],
        new contacto(
            $row['telefono'],
            $row['domicilio'],
            $row['email']
        ),
        $row['usuario'],
        $row['contraseña'],
        $fechaNacimiento,
        (int)$row['tipoUsuario']
    );

    return $u;
}

function setUsuario($post): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        $sql = "INSERT INTO usuario (dni, nombre, telefono, usuario, contraseña, tipoUsuario
                ) VALUES (
                \"{$post['dni']}\", \"{$post['nombre']}\", \"{$post['telefono']}\", \"{$post['usuario']}\",
                \"" . $post['contrasena'] . "\", \"" . $post['fechaNacimiento'] . "\",0)";

        $stmt = $PDO->prepare($sql);

        return $stmt->execute([]);
    }

    echo "<script>alert('Error al conectarse con la base de datos');</script>";
    return false;
}

function deleteUsuario(int $id): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        $sql = "Update usuario set dni = '', nombre = '', telefono = '', domicilio = '', email = '', 
        usuario = '', contraseña = '' where id = " . $id;

        $stmt = $PDO->prepare($sql);

        return $stmt->execute([]);
    }

    echo "<script>alert('Error al conectarse con la base de datos');</script>";
    return false;
}

function updateUsuario($post): bool
{
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (is_null($PDO)) {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
        return false;
    }

    $sql = "
        UPDATE usuario
        SET
            dni = ?,
            nombre = ?,
            telefono = ?,
            domicilio = ?,
            email = ?,
            usuario = ?,
            contraseña = ?,
            fechanacimiento = ?,
            tipousuario = ?
        WHERE id = ?
    ";

    $stmt = $PDO->prepare($sql);

    $ok = $stmt->execute([
        $post["dni"],
        $post["nombre"],
        $post["telefono"],     // contacto
        $post["domicilio"],    // contacto
        $post["email"],        // contacto
        $post["usuario"],
        $post["contrasena"],
        $post["fechaNacimiento"],
        $post["tipoUsuario"] ?? 0,
        $post["id"]
    ]);

    return $ok;
}
