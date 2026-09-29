<?php

namespace App\Utils;

use App\Models\Equipo;
use RuntimeException;

class SinExistenciasException extends RuntimeException
{
    public function __construct(Equipo $equipo)
    {
        parent::__construct(
            "No hay suficientes unidades de "
            . $equipo->getNombre()
        );
    }
}