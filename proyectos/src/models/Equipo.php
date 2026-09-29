<?php
namespace App\Models;

use App\Utils\SinExistenciasException;

abstract class Equipo
{
    public function __construct(
        protected readonly string $nombre,
        protected float $precioHora,
        protected int $existencias
    ) {
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getPrecioHora(): float
    {
        return $this->precioHora;
    }

    public function getExistencias(): int
    {
        return $this->existencias;
    }

    public function disponible(int $cantidad): bool
    {
        return $cantidad > 0
            && $cantidad <= $this->existencias;
    }

    public function descontar(int $cantidad): void
    {
        if (!$this->disponible($cantidad)) {
            throw new SinExistenciasException($this);
        }

        $this->existencias -= $cantidad;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }
}