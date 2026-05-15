<?php

require("libro.php");
require("usuario.php");

class historialLibro
{
    public int $id;
    public libro $idLibro;
    public usuario $idUsuario;
    public DateTime $fechaPrestamo;
    public ?DateTime $fechaEntrega;

    public function __construct(int $id, libro $idLibro, usuario $idUsuario, DateTime $fechaPrestamo, ?DateTime $fechaEntrega)
    {
        $this->id = $id;
        $this->idLibro = $idLibro;
        $this->idUsuario = $idUsuario;
        $this->fechaPrestamo = $fechaPrestamo;
        $this->fechaEntrega = $fechaEntrega;
    }

    public static function crear(int $id, libro $idLibro, usuario $idUsuario, string $fechaPrestamo, string $fechaEntrega): HistorialLibro
    {
        return new HistorialLibro($id, $idLibro, $idUsuario, new DateTime($fechaPrestamo), new DateTime($fechaEntrega));
    }

}
