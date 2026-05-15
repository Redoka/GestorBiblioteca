<?php
require_once("contacto.php");
class usuario
{
    public int $id;
    public string $dni;
    public string $nombre;
    public contacto $contacto;
    public string $usuario;
    public string $contraseña;
    public int $tipoUsuario;

    public function __contruct(int $id, string $dni, string $nombre, contacto $contacto, string $usuario, string $contraseña, int $tipoUsuario)
    {

        $this->id = $id;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->tipoUsuario = $tipoUsuario;
    }

    public static function crear(int $id, string $dni, string $nombre, contacto $contacto, string $usuario, string $contraseña, int $tipoUsuario): Usuario
    {
        return new Usuario(
            $id,
            $dni,
            $nombre,
            $contacto,
            $usuario,
            $contraseña,
            $tipoUsuario
        );
    }
}
