<?php

namespace src\Banco\Domain;

class CuentaCorriente extends CuentaBancaria {

    private $cupoSobreGiro;

    public function __construct(string $numero, string $nombre, string $ciudad, float $saldo,float $cupoSobreGiro)
    {
        parent::__construct($numero, $nombre, $ciudad, $saldo);
        $this->cupoSobreGiro = $cupoSobreGiro;
        $this->VALORMINIMODECONSIGNACIONINICIAL = 100000;
    }

    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        parent::addMovimiento($saldoAnterior, $valorCredito,  $valorDebito,  $tipo, $fechaDeLaTransaccion);
    }

    function consignar(float $valorConsignacion,string $ciudad): string
    {
        if($valorConsignacion <= 0) return 'El valor a consignar es incorrecto';

        if($valorConsignacion < $this->VALORMINIMODECONSIGNACIONINICIAL && !$this->tieneConsignaciones())
            return sprintf('El valor mínimo de la primera consignación debe ser de $%s mil pesos. Su nuevo saldo es $0 pesos',number_format($this->VALORMINIMODECONSIGNACIONINICIAL,2));

        $this->addMovimiento($this->getSaldo(),$valorConsignacion,0,'CONSIGNACION',new \DateTime('NOW'));
        $this->setSaldo($this->getSaldo()+$valorConsignacion);

        return sprintf('Su nuevo saldo es de $%s pesos m/c', number_format($this->getSaldo(),2));

    }

    function retirar(float $valorRetiro, \DateTime $fechaDeLaTransaccion): string
    {
        $cantidadRestante = $this->getSaldo() - $valorRetiro - $valorRetiro/250;

        if($cantidadRestante < $this->cupoSobreGiro)
            return "cupo de sobregiro superado, Retiro cancelado";

        $this->addMovimiento($this->getSaldo(),0,$valorRetiro,'RETIRO',$fechaDeLaTransaccion);
        $this->setSaldo($cantidadRestante);

        return sprintf('Su nuevo saldo es de $%s pesos m/c',number_format($this->getSaldo(),2));

    }

}
