<?php
namespace App\Models;

final class Docente extends Usuario
{
    #[\Override]
    public function getFactorPago(): float
    {
        return 0.90;
    }
}