<?php

declare(strict_types=1);

namespace src\Banco\Domain;

use phpDocumentor\Reflection\Types\Boolean;

class CuentaAhorros extends CuentaBancaria {

    private $retiros = [];

    public function __construct(string $numero,string $nombre, string $ciudad, float $saldo)
    {
        parent::__construct($numero,$nombre, $ciudad, $saldo);
        $this->SALDOMINIMOPARARETIRAR = 20000;
        $this->SALDOMINIMOPARARETIRAR = 20000;
        $this->VALORMINIMODECONSIGNACIONINICIAL = 50000;
        $this->CANTIDADDERETIROSGRATUITOSPORMES = 3;
        $this->VALORDELRETIRO = 5000;
    }

    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        parent::addMovimiento($saldoAnterior, $valorCredito,  $valorDebito,  $tipo, $fechaDeLaTransaccion);
        if($tipo == 'RETIRO'){
            $key = $fechaDeLaTransaccion->format('m-Y');
            $this->retiros[$key] = array_key_exists($key,$this->retiros) ? $this->retiros[$key]+1 : 1;
        }
    }

    public function consignar(float $valorConsignacion): string
    {
        if($valorConsignacion <= 0) return 'El valor a consignar es incorrecto';

        if($valorConsignacion < $this->VALORMINIMODECONSIGNACIONINICIAL && !$this->tieneConsignaciones())
            return 'El valor mínimo de la primera consignación debe ser de $50,000 mil pesos. Su nuevo saldo es $0 pesos';

        $this->addMovimiento($this->getSaldo(),$valorConsignacion,0,'CONSIGNACION',new \DateTime('NOW'));
        $this->setSaldo($this->getSaldo()+$valorConsignacion);

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