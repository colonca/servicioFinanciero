<?php

namespace src\Banco\Domain;

use Cassandra\Date;

class CuentaBancariaMovimiento{

    private  $saldoAnterior;
    private  $valorCredito;
    private  $valorDebito;
    private  $tipo;
    private  $fechaDeLaTransaccion;


    public function __construct(float $saldoAnterior, float $valorCredito, float $valorDebito, string $tipo, \DateTime $fechaDeLaTransaccion)
    {
        $this->saldoAnterior = $saldoAnterior;
        $this->valorCredito = $valorCredito;
        $this->valorDebito = $valorDebito;
        $this->tipo = $tipo;
        $this->fechaDeLaTransaccion = $fechaDeLaTransaccion;
    }

    /**
     * @return string
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }


    public function getFechaDeLaTransaccion() : \DateTime {
        return $this->fechaDeLaTransaccion;
    }




}