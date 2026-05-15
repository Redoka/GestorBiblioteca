<?php
require("historialLibro.php");
class biblioteca
{
    public int $id;
    public string $nombre;
    public contacto $contacto;
    public $historialLibros = array();
    public $libros = array();

    public function __contruct(int $id, string $nombre, contacto $contacto, $historialLibros, $libros)
    {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->contacto = $contacto;
        $this->historialLibros = $historialLibros;
        $this->libros = $libros;
    }
}
