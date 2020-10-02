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

     /*
      *
        Escenario:  Valor del abono correcto
        HU 5. Como Usuario quiero realizar consignaciones (abonos) a una Tarjeta Crédito para abonar al saldo del servicio.
        Criterio de Aceptación:
         5.1 El valor a abonar no puede ser menor o igual a 0.
         5.2 El abono podrá ser máximo el valor del saldo de la tarjeta de crédito.
        Dado
        El cliente tiene una tarjeta de crédito Número 4508-0356-0456-0125
        , Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $200000, cupo preaprobado $2,000,000.00
        Cuando
        va abonar $200000
        Entonces
        El sistema presentará el mensaje. “Su Nuevo Saldo es de $0.00 pesos m/c y el cupo está por %2,000,000.00”
      */
      public function testValorDelAbonoCorrecto(): void {
          $tarjeta = new TarjetaDeCredito('4508-0356-0456-0125','Cuenta Ejemplo','Valledupar',200000,2000000);
          $resultado = $tarjeta->consignar(200000,'Valledupar');
          $this->assertEquals('Su Nuevo Saldo es de $0.00 pesos m/c y el cupo esta por $2,000,000.00',$resultado);
      }


      /*
       *
        Escenario:  Valor del avance menor o igual a cero.
        HU 6. Como Usuario quiero realizar retiros (avances) a una cuenta de crédito para retirar dinero en forma de avances del servicio de crédito.
        Criterio de Aceptación:
         6.1 El valor del avance debe ser mayor a 0
        Dado
        El cliente tiene una tarjeta de crédito Número 4508-0356-0456-0125
        , Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $200000, cupo preaprobado $2,000,000.00
        Cuando
        va retirar $0
        Entonces
        El sistema presentará el mensaje. “El valor del avance es incorrecto”
       */
       public function testValorDelAvanceMenorOIgualACero(){
           $tarjeta = new TarjetaDeCredito('4508-0356-0456-0125','Cuenta Ejemplo','Valledupar',200000,2000000);
           $resultado = $tarjeta->retirar(0,new \DateTime('NOW'));
           $this->assertEquals('El valor del avance es incorrecto',$resultado);
       }


       /*
        *
        Escenario:  avance mayor al valor disponible del cupo
        HU 6. Como Usuario quiero realizar retiros (avances) a una cuenta de crédito para retirar dinero en forma de avances del servicio de crédito.
        Criterio de Aceptación:
        6.1 El valor del avance debe ser mayor a 0.
        6.2 Al realizar un avance se debe reducir el valor disponible del cupo con el valor del avance.
        6.3 Un avance no podrá ser mayor al valor disponible del cupo.
        Dado
        El cliente tiene una tarjeta de crédito Número 4508-0356-0456-0125
        , Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $0, cupo preaprobado $2,000,000.00
        Cuando
        va retirar $2,200,000
        Entonces
        El sistema presentará el mensaje. “El cupo disponible de la tarjeta se ha copado”
        */

        public function testAvanceMayorAlValorDisponibleDelCupo(): void {
            $tarjeta = new TarjetaDeCredito('4508-0356-0456-0125','Cuenta Ejemplo','Valledupar',0,2000000);
            $resultado = $tarjeta->retirar(2200000,new \DateTime('NOW'));
            $this->assertEquals('El cupo disponible de la tarjeta se ha copado',$resultado);
        }
}