
<?php
require_once __DIR__ . "/../modelo/libro.php";
class descatalogado
{
    public int $id;
    public libro $idLibro;

    public function __construct(int $id, libro $idLibro)
    {
        $this->id = $id;
        $this->idLibro = $idLibro;
    }
}
