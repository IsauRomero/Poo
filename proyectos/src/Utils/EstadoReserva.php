<?php
namespace App\Utils;

enum EstadoReserva: string
{
    case Pendiente = 'pendiente';
    case Reservado = 'reservado';
    case Cancelado = 'cancelado';

    public function etiqueta(): string
    {
        return match ($this) {
            self::Pendiente => 'Pendiente',
            self::Reservado => 'Reservado',
            self::Cancelado => 'Cancelado',
        };
    }
}