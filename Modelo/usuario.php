<?php
require_once("contacto.php");
class usuario
{
    public int $id;
    public string $dni;
    public string $nombre;
    public ?contacto $contacto = null;
    public string $usuario;
    public string $contraseña;
    public ?DateTime $fechaNacimiento;
    public int $tipoUsuario;

    public function __construct(
        int $id = 0,
        string $dni = "",
        string $nombre = "",
        ?contacto $contacto = null,
        string $usuario = "",
        string $contraseña = "",
        ?DateTime $fechaNacimiento = null,
        int $tipoUsuario = 0
    ) {
        $this->id = $id;
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
        $this->usuario = $usuario;
        $this->contraseña = $contraseña;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->tipoUsuario = $tipoUsuario;
    }

    public static function crear(int $id, string $dni, string $nombre, contacto $contacto, string $usuario, string $contraseña, ?DateTime $fechaNacimiento, int $tipoUsuario): Usuario
    {
        return new Usuario(
            $id,
            $dni,
            $nombre,
            $contacto,
            $usuario,
            $contraseña,
            $fechaNacimiento,
            $tipoUsuario
        );
    }
}
