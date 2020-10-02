<?php


namespace src\Banco\Domain;


class TarjetaDeCredito extends Credenciales implements IServicioFinanciero
{
    private $cupoPreAprobado;

    public function __construct(string $numero, string $nombre, string $ciudad, float $saldo, float $cupoPreAprobado)
    {
        parent::__construct($numero, $nombre, $ciudad, $saldo);
    }

    public function consignar(float $valorConsignacion, string $ciudadDondeSeRealizoLaConsignacion): string
    {
        // TODO: Implement consignar() method.
    }

    public function retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string
    {
        // TODO: Implement retirar() method.
    }
}