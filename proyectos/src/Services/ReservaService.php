<?php

namespace App\Services;

use App\Contracts\Reservable;
use App\Models\Equipo;
use App\Models\Reserva;
use App\Models\Usuario;
use InvalidArgumentException;

final class ReservaService implements Reservable
{
    public const CARGO_MANTENIMIENTO = 2.50;

    #[\Override]
    public function reservar(
        Usuario $usuario,
        Equipo $equipo,
        int $cantidad,
        int $horas
    ): Reserva {

        if ($cantidad <= 0 || $horas <= 0) {

            throw new InvalidArgumentException(
                "Cantidad y horas deben ser mayores a cero."
            );
        }

        if (!$equipo->disponible($cantidad)) {

            $equipo->descontar($cantidad);
        }

        $subtotal =
            $equipo->getPrecioHora()
            * $cantidad
            * $horas;

        $porcentajeDescuento =
            (1 - $usuario->getFactorPago()) * 100;

        $total =
            ($subtotal * $usuario->getFactorPago())
            + self::CARGO_MANTENIMIENTO;

        $reserva = new Reserva(
            $usuario,
            clone $equipo,
            $cantidad,
            $horas,
            $subtotal,
            $porcentajeDescuento,
            $total
        );

        $equipo->descontar($cantidad);

        return $reserva;
    }
}