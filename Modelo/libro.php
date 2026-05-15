<?php

class libro
{
    public int $id;
    public string $isbn;
    public string $titulo;
    public string $autor;
    public DateTime $fechaDePublicacion;


    public function __contruct(int $id, int $isbn, string $titulo, string $autor, DateTime $fechaDePublicacion)
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->fechaDePublicacion = $fechaDePublicacion;
    }

    public static function crear(int $id, string $isbn, string $titulo, string $autor, string $fecha): Libro
    {
        return new Libro($id, $isbn,  $titulo, $autor, new DateTime($fecha));
    }
}
