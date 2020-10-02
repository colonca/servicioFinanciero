<?php

namespace src\Banco\Domain;

class CuentaBancaria extends Credenciales implements IServicioFinanciero {

    //COLLECCIONES
    protected $movimientos = [];

    //CONSTANTES
    protected $VALORMINIMODECONSIGNACIONINICIAL;


    public function __construct(string $numero,string $nombre, string $ciudad, float $saldo)
    {
       parent::__construct( $numero, $nombre,  $ciudad,  $saldo);
    }


    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        $movimiento = new CuentaBancariaMovimiento($saldoAnterior,$valorCredito,$valorDebito,$tipo,$fechaDeLaTransaccion);
        $this->movimientos[]=$movimiento;
    }

    protected function tieneConsignaciones() : bool{
        return count($this->movimientos) !== 0 || $this->getSaldo() != 0;
    }

    function consignar(float $valorConsignacion,string $ciudad): string{}
    function retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string{}
}