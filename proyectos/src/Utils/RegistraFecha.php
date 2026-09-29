<?php
namespace App\Utils;

trait RegistraFecha
{
    public function obtenerFecha(): string
    {
        return date('d-m-Y');
    }
}