<?php

declare(strict_types=1);

namespace src\Banco\Domain;

use phpDocumentor\Reflection\Types\Boolean;

class CuentaAhorros extends CuentaBancaria {

    private $retiros = [];

    //constantes
    private $SALDOMINIMOPARARETIRAR = 20000;
    private $CANTIDADDERETIROSGRATUITOSPORMES = 3;
    private $VALORDELRETIRO = 5000;
    private $VALORDELACONSIGNACIONDESDEUNACUENTADEOTRACIUDAD = 10000;

    public function __construct(string $numero,string $nombre, string $ciudad, float $saldo)
    {
        parent::__construct($numero,$nombre, $ciudad, $saldo);
        $this->VALORMINIMODECONSIGNACIONINICIAL = 50000;
    }

    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        parent::addMovimiento($saldoAnterior, $valorCredito,  $valorDebito,  $tipo, $fechaDeLaTransaccion);
        if($tipo == 'RETIRO'){
            $key = $fechaDeLaTransaccion->format('m-Y');
            $this->retiros[$key] = array_key_exists($key,$this->retiros) ? $this->retiros[$key]+1 : 1;
        }
    }

    public function consignar(float $valorConsignacion,string $ciudadDondeSeRealizoLaConsignacion): string
    {
        if($valorConsignacion <= 0) return 'El valor a consignar es incorrecto';

        if($valorConsignacion < $this->VALORMINIMODECONSIGNACIONINICIAL && !$this->tieneConsignaciones())
            return sprintf('El valor mínimo de la primera consignación debe ser de $%s mil pesos. Su nuevo saldo es $%s pesos',number_format($this->VALORMINIMODECONSIGNACIONINICIAL),number_format($this->getSaldo()));

        if($ciudadDondeSeRealizoLaConsignacion !== $this->getCiudad() && ($valorConsignacion+$this->getSaldo()) < $this->VALORDELACONSIGNACIONDESDEUNACUENTADEOTRACIUDAD)
            return 'Saldo insuficienta para realizar la consignacion';

        $cobroPorConsignacionNacional = $ciudadDondeSeRealizoLaConsignacion !== $this->getCiudad() ? $this->VALORDELACONSIGNACIONDESDEUNACUENTADEOTRACIUDAD : 0;
        $valorAConsignar  = $valorConsignacion-$cobroPorConsignacionNacional;
        $this->addMovimiento($this->getSaldo(),$valorAConsignar,0,'CONSIGNACION',new \DateTime('NOW'));
        $this->setSaldo($this->getSaldo()+$valorAConsignar);

        return  sprintf('Su Nuevo Saldo es de $%s pesos m/c',number_format($this->getSaldo(),2));
    }

    public function retirar(float $dineroARetirar,\DateTime $fechaDeLaTransaccion):string {

        if($this->getSaldo() < $this->SALDOMINIMOPARARETIRAR)
            return sprintf('El saldo mínimo para poder retirar es de $%s pesos m/c, Retiro cancelado',number_format($this->SALDOMINIMOPARARETIRAR,2));

        $this->addMovimiento($this->getSaldo(),0,$dineroARetirar,'RETIRO',$fechaDeLaTransaccion);
        $cobroDelRetiro = $this->cobrarRetiro($fechaDeLaTransaccion) ? $this->VALORDELRETIRO  : 0;
        $this->setSaldo($this->getSaldo()-$dineroARetirar-$cobroDelRetiro);

        return sprintf('Su nuevo saldo es de $%s pesos m/c',number_format($this->getSaldo(),2));
    }

    private function cobrarRetiro(\DateTime $fecha) : bool{
        $retirosEnElMes = $this->retiros[$fecha->format('m-Y')]??0;
        return $retirosEnElMes > $this->CANTIDADDERETIROSGRATUITOSPORMES;
    }

}