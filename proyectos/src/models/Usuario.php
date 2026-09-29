<?php

namespace App\Models;

abstract class Usuario{

    public function __construct(protected readonly string $nombre, protected string $correo){}


    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    abstract public function getFactorPago(): float;

    public function __toString(): string
    {
        return $this->nombre . " - " . $this->correo;
    }
}
