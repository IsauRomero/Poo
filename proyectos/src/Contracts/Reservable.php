<?php

namespace App\Contracts;

use App\Models\Equipo;
use App\Models\Reserva;
use App\Models\Usuario;

interface Reservable
{
    public function reservar(
        Usuario $usuario,
        Equipo $equipo,
        int $cantidad,
        int $horas
    ): Reserva;
}