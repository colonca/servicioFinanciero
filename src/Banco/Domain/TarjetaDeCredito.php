<?php


namespace src\Banco\Domain;


class TarjetaDeCredito extends Credenciales implements IServicioFinanciero
{
    private $cupoPreAprobado;

    public function __construct(string $numero, string $nombre, string $ciudad, float $saldo, float $cupoPreAprobado)
    {
        parent::__construct($numero, $nombre, $ciudad, $saldo);
        $this->cupoPreAprobado = $cupoPreAprobado;
    }

    public function consignar(float $valorConsignacion, string $ciudadDondeSeRealizoLaConsignacion): string
    {
       if($valorConsignacion <= 0 || $valorConsignacion > $this->getSaldo())
           return 'El valor del abono es incorrecto';

       $this->setSaldo($this->getSaldo()-$valorConsignacion);

       return sprintf('Su Nuevo Saldo es de $%s pesos m/c y el cupo esta por $%s',number_format($this->getSaldo(),2),number_format($this->cupoPreAprobado,2));

    }

    public function retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string
    {
        // TODO: Implement retirar() method.
    }
}