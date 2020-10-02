<?php

namespace src\Banco\Domain;

interface IServicioFinanciero
{
    public function  consignar(float $valorConsignacion,string $ciudadDondeSeRealizoLaConsignacion): string;
    public function  retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string;
}