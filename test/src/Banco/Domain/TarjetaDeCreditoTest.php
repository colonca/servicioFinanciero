<?php


namespace test\src\Banco\Domain;


use PHPUnit\Framework\TestCase;
use src\Banco\Domain\TarjetaDeCredito;

class TarjetaDeCreditoTest extends  TestCase
{

    /*
     *
        Escenario:  Valor del abono negativo o cero
        HU 5. Como Usuario quiero realizar consignaciones (abonos) a una Tarjeta Crédito para abonar al saldo del servicio.
        Criterio de Aceptación:
        5.1 El valor a abono no puede ser menor o igual a 0
        Dado
        El cliente tiene una tarjeta de crédito Número 4508-0356-0456-0125
        , Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $0, cupo preaprobado $2,000,000.00
        Cuando
        va abonar $0
        Entonces
        El sistema presentará el mensaje. “El valor del abono es incorrecto”
     */
     public function testConsignacionMenorOIgualACero() : void {
        $tarjeta = new TarjetaDeCredito('4508-0356-0456-0125','Cuenta Ejemplo','Valledupar',0,2000000);
        $resultado = $tarjeta->consignar(0,'Valledupar');
        $this->assertEquals('El valor del abono es incorrecto',$resultado);
     }


     /*
      *
        Escenario:  Valor del abono mayor al saldo de la tarjeta.
        HU 5. Como Usuario quiero realizar consignaciones (abonos) a una Tarjeta Crédito para abonar al saldo del servicio.
        Criterio de Aceptación:
         5.1 El valor a abonar no puede ser menor o igual a 0.
         5.2 El abono podrá ser máximo el valor del saldo de la tarjeta de crédito.
        Dado
        El cliente tiene una tarjeta de crédito Número 4508-0356-0456-0125
        , Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $200000, cupo preaprobado $2,000,000.00
        Cuando
        va abonar $250000
        Entonces
        El sistema presentará el mensaje. “El valor del abono es incorrecto”
      */
     public function testValordelAbonoMayorAlSaldoDeLaTarjeta() : void {
         $tarjeta = new TarjetaDeCredito('4508-0356-0456-0125','Cuenta Ejemplo','Valledupar',200000,2000000);
         $resultado = $tarjeta->consignar(250000,'Valledupar');
         $this->assertEquals('El valor del abono es incorrecto',$resultado);
     }

}