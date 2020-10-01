<?php

namespace src\Banco\Domain;

abstract class CuentaBancaria {

    //COLLECCIONES
    protected $movimientos = [];

    //CONSTANTES
    protected $SALDOMINIMOPARARETIRAR;
    protected $VALORMINIMODECONSIGNACIONINICIAL;
    protected $CANTIDADDERETIROSGRATUITOSPORMES;
    protected $VALORDELRETIRO;

    private $numero;
    private $ciudad;
    private $saldo;

    public function __construct(string $numero,string $nombre, string $ciudad, float $saldo)
    {
        $this->numero = $numero;
        $this->nombre = $nombre;
        $this->ciudad = $ciudad;
        $this->saldo = $saldo;
    }

    public function getCiudad(): string
    {
        return $this->ciudad;
    }
    public function getNumero(): string
    {
        return $this->numero;
    }
    public function getSaldo(): float
    {
        return $this->saldo;
    }
    public function setSaldo(float $saldo){
        $this->saldo = $saldo;
    }

    protected function addMovimiento(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo,\DateTime $fechaDeLaTransaccion) : void {
        $movimiento = new CuentaBancariaMovimiento($saldoAnterior,$valorCredito,$valorDebito,$tipo,$fechaDeLaTransaccion);
        $this->movimientos[]=$movimiento;
    }

    protected function tieneConsignaciones() : bool{
        return count($this->movimientos) !== 0 || $this->getSaldo() != 0;
    }

    abstract function  consignar(float $valorConsignacion): string;
    abstract function  retirar(float $valorConsignacion, \DateTime $fechaDeLaTransaccion): string;

}