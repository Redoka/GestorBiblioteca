<?php

class contacto
{

    public string $telefono;
    public string $domicilio;
    public string $email;

    public function __construct(string $telefono, string $domicilio, string $email)
    {
        $this->telefono = $telefono;
        $this->domicilio = $domicilio;
        $this->email = $email;
    }
}
