<?php

namespace test\src\Banco\Domain;

use PHPUnit\Framework\TestCase;
use src\Banco\Domain\CuentaAhorros;

class CuentaAhorrosConsignacionesTest extends TestCase {

    /*
     * //Escenario: Valor de consignaci�n negativo o cero
        //H1: Como Usuario quiero realizar consignaciones a una cuenta de ahorro para salvaguardar el dinero.
        //Criterio de Aceptaci�n:
        //1.2 El valor a abono no puede ser menor o igual a 0
        //Ejemplo
        //Dado El cliente tiene una cuenta de ahorro                                       //A =>Arrange /Preparaci�n
        //N�mero 10001, Nombre �Cuenta ejemplo�, Saldo de 0 , ciudad Valledupar
        //Cuando Va a consignar un valor menor o igual a cero  (0)                            //A =>Act = Acci�n
        //Entonces El sistema presentar� el mensaje. �El valor a consignar es incorrecto�  //A => Assert => Validaci�n
     * @test
     */
    public function testValorConsignacionNegativoOCero(): void
    {
        $cuentaAhorros = new CuentaAhorros('10001','�Cuenta ejemplo�','Valledupar',0.0);
        $resultado = $cuentaAhorros->consignar(0,'Valledupar');
        $this->assertEquals('El valor a consignar es incorrecto',$resultado);
    }

    /*
     *  //Escenario: Consignaci�n Inicial Correcta
        //HU: Como Usuario quiero realizar consignaciones a una cuenta de ahorro para salvaguardar el dinero.
        //Criterio de Aceptaci�n:
        //1.1 La consignaci�n inicial debe ser mayor o igual a 50 mil pesos
        //1.3 El valor de la consignaci�n se le adicionar� al valor del saldo aumentar�
        //Dado El cliente tiene una cuenta de ahorro
        //N�mero 10001, Nombre �Cuenta ejemplo�, Saldo de 0 ciudad valledupar
        //Cuando Va a consignar el valor inicial de 50 mil pesos
        //Entonces El sistema registrar� la consignaci�n
        //AND presentar� el mensaje. �Su Nuevo Saldo es de $50.000,00 pesos m/c�.
     */

    public function testConsignacionCorrecta() : void {
        $cuentaAhorro = new CuentaAhorros('10001','�Cuenta ejemplo�','Valledupar',0.0);
        $resultado = $cuentaAhorro->consignar(50000,'Valledupar');
        $this->assertEquals('Su Nuevo Saldo es de $50,000.00 pesos m/c',$resultado);
    }

    /*
     * Escenario: Consignación Inicial Incorrecta
            HU: Como Usuario quiero realizar consignaciones a una cuenta de ahorro para salvaguardar el
            dinero.
            Criterio de Aceptación:
            1.1 La consignación inicial debe ser mayor o igual a 50 mil pesos
            Dado El cliente tiene una cuenta de ahorro con
            Número 10001, Nombre “Cuenta ejemplo”, Saldo de 0
            Cuando Va a consignar el valor inicial de $49.950 pesos
            Entonces El sistema no registrará la consignación
            AND presentará el mensaje. “El valor mínimo de la primera consignación debe ser
            de $50.000 mil pesos. Su nuevo saldo es $0 pesos”.
     */
    public function testConsignacionInicialIncorrecta() : void {
        $cuentaAhorro = new CuentaAhorros('1001','Cuenta de Ejemplo','Valledupar',0);
        $resultado = $cuentaAhorro->consignar(49950,'Valledupar');
        $this->assertEquals('El valor mínimo de la primera consignación debe ser de $50,000 mil pesos. Su nuevo saldo es $0 pesos',$resultado);
    }

    /*
     * Escenario: Consignación posterior a la inicial correcta
        HU: Como Usuario quiero realizar consignaciones a una cuenta de ahorro para salvaguardar el
        dinero.
        Criterio de Aceptación:
        1.3 El valor de la consignación se le adicionará al valor del saldo aumentará
        Dado El cliente tiene una cuenta de ahorro con un saldo de 30.000
        Cuando Va a consignar el valor inicial de $49.950 pesos
        Entonces El sistema registrará la consignación
        AND presentará el mensaje. “Su Nuevo Saldo es de $79.950,00 pesos m/c”.
     */
    public function testConsignacionPosteriorAlaInicialCorrecta() {
        $cuentaAhorro = new CuentaAhorros('10001','Cuenta de Ejemplo','Valledupar',30000);
        $resultado = $cuentaAhorro->consignar(49950,'Valledupar');
        $this->assertEquals('Su Nuevo Saldo es de $79,950.00 pesos m/c',$resultado);
    }


    /*
    * Escenario: Consignación posterior a la inicial correcta
       HU: Como Usuario quiero realizar consignaciones a una cuenta de ahorro para salvaguardar el
       dinero.
       Criterio de Aceptación:
       1.4 La consignación nacional (a una cuenta de otra ciudad) tendrá un costo de $10 mil pesos.
       Dado El cliente tiene una cuenta de ahorro con un saldo de 30.000 perteneciente a una
       sucursal de la ciudad de Bogotá y se realizará una consignación desde una sucursal
       de la Valledupar.
       Cuando Va a consignar el valor inicial de $49.950 pesos.
       Entonces El sistema registrará la consignación restando el valor a consignar los 10 mil pesos.
       AND presentará el mensaje. “Su Nuevo Saldo es de $69,950.00 pesos m/c”.
    */
    public function testConsignaciónPosteriorA_laInicialCorrecta() : void {
        $cuentaAhorros = new CuentaAhorros('10001','Cuenta Ejemplo','Bogota',30000);
        $resultado = $cuentaAhorros->consignar(49950,'Valledupar');
        $this->assertEquals('Su Nuevo Saldo es de $69,950.00 pesos m/c',$resultado);
    }

}