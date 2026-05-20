<?php

class libro
{
    public int $id;
    public string $isbn;
    public string $titulo;
    public string $autor;
    public DateTime $fechaDePublicacion;
    public ?string $descripcion;

    public function __construct(int $id, int $isbn, string $titulo, string $autor, DateTime $fechaDePublicacion, ?string $descripcion)
    {
        $this->id = $id;
        $this->isbn = $isbn;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->fechaDePublicacion = $fechaDePublicacion;
        $this->descripcion = $descripcion;
    }

    public static function crear(int $id, string $isbn, string $titulo, string $autor, string $fecha, string $descripcion): Libro
    {
        return new Libro($id, $isbn,  $titulo, $autor, new DateTime($fecha), $descripcion);
    }
}
