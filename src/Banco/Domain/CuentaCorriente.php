<?php

namespace src\Banco\Domain;

class CuentaCorriente extends CuentaBancaria {

    public function __construct(string $numero, string $nombre, string $ciudad, float $saldo)
    {
        parent::__construct($numero, $nombre, $ciudad, $saldo);
        $this->VALORMINIMODECONSIGNACIONINICIAL = 100000;
    }

    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        parent::addMovimiento($saldoAnterior, $valorCredito,  $valorDebito,  $tipo, $fechaDeLaTransaccion);
    }

    function consignar(float $valorConsignacion): string
    {
        if($valorConsignacion <= 0) return 'El valor a consignar es incorrecto';

        if($valorConsignacion < $this->VALORMINIMODECONSIGNACIONINICIAL && !$this->tieneConsignaciones())
            return sprintf('El valor mínimo de la primera consignación debe ser de $%s mil pesos. Su nuevo saldo es $0 pesos',number_format($this->VALORMINIMODECONSIGNACIONINICIAL,2));

        $this->addMovimiento($this->getSaldo(),$valorConsignacion,0,'CONSIGNACION',new \DateTime('NOW'));
        $this->setSaldo($this->getSaldo()+$valorConsignacion);

        return sprintf('Su nuevo saldo es de $%s pesos m/c', number_format($this->getSaldo(),2));

    }

    function retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string
    {
        // TODO: Implement retirar() method.
    }

}
