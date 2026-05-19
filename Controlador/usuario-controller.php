<?php
require_once("baseDatos.php");
require_once __DIR__ . "/../Modelo/usuario.php";



function getUsuarios(): array
{
    $usuarios = array();
    $bdd = "biblioteca";
    $PDO = conectarDB($bdd);

    if (!is_null($PDO)) {

        $sql = "select id, dni, nombre, telefono, domicilio, email, usuario, contraseña, tipousuario as tipoUsuario 
                from usuario";
        $usuarios = $PDO->query($sql)->fetchAll(PDO::FETCH_CLASS, usuario::class);
    } else {
        echo "<script>alert('Error al conectarse con la base de datos');</script>";
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
                tipousuario AS tipoUsuario
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

    $usuario = new usuario();

    $usuario->id = $row['id'];
    $usuario->dni = $row['dni'];
    $usuario->nombre = $row['nombre'];
    $usuario->contacto = $contacto;
    $usuario->usuario = $row['usuario'];
    $usuario->contraseña = $row['contraseña'];
    $usuario->tipoUsuario = $row['tipoUsuario'];

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

    $sql = "SELECT id, dni, nombre, telefono, domicilio, email, usuario, contraseña, tipousuario as tipoUsuario 
            FROM usuario 
            WHERE usuario = ? AND contraseña = ? 
            LIMIT 1";

    $stmt = $PDO->prepare($sql);
    $stmt->execute([$post['usuario'], $post['password']]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

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
                \"" . $post['contrasena'] . "\",0)";

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
        usuario = '', contraseña = '', tipousuario = 0 where id = " . $id;

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
        $post["tipoUsuario"] ?? 0,
        $post["id"]
    ]);

    return $ok;
}
