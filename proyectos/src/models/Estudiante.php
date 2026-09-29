<?php

namespace App\Models;

final class Estudiante extends Usuario
{
    #[\Override]
    public function getFactorPago(): float
    {
        return 0.80;
    }
}