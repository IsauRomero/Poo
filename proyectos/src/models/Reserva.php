<?php
namespace App\Models;

use App\Utils\EstadoReserva;
use App\Utils\RegistraFecha;

final class Reserva
{
    use RegistraFecha;
    private readonly string $fecha;
    private EstadoReserva $estado;

    public function __construct(
        private Usuario $usuario,
        private Equipo $equipo,
        private int $cantidad,
        private int $horas,
        private float $subtotal,
        private float $descuento,
        private float $total
    ){
        $this->fecha = $this->obtenerFecha();
        $this->estado = EstadoReserva::Pendiente;
    }

    public function getUsuario(): Usuario{
        return $this->usuario;
    }
    public function getEquipo(): Equipo{
        return $this->equipo;
    }
    public function getCantidad(): int{
        return $this->cantidad;
    }
    public function getHoras(): float{
        return $this->descuento;
    }
    public function getTotal(): float{
        return $this->total;
    }
    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getEstado(): EstadoReserva
    {
        return $this->estado;
    }
    public function getDescuento(): float
    {
        return $this->descuento;
    }
}