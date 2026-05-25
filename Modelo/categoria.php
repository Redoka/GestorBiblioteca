<?php

class Categoria
{
    public int $id;
    public string $descripcion;

    public string $categorias;

    public function __construct(int $id, string $descripcion)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
    }

    public static function crear(int $id, string $descripcion): Categoria
    {
        return new Categoria($id, $descripcion);
    }
}
