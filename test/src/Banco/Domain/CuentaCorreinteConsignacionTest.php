<?php

namespace test\src\Banco\Domain;

use PHPUnit\Framework\TestCase;
use src\Banco\Domain\CuentaCorriente;

class CuentaCorreinteConsignacionTest extends TestCase {

    /*
     *
        Escenario:  consignación incorrecta
        HU 3. Como Usuario quiero realizar consignaciones a una cuenta corriente para salvaguardar el dinero.
        Criterio de Aceptación:
        3.2 El valor consignado debe ser adicionado al saldo de la cuenta.
        Dado
        El cliente tiene una cuenta corriente Número 1001, Nombre “Cuenta Ejemplo” , Ciudad “Valledupar”, Saldo de $0
        Cuando
        va a realizar una consignación menor o igual a cero
        Entonces
        El sistema debe arrojar un mensaje : "El valor a consignar es incorrecto"
     */
    public function testConsignacionIncorrecta(){
        $cuentaCorriente = new CuentaCorriente('10001','Cuenta Ejemplo','Valledupar',0.00,0);
        $resultado = $cuentaCorriente->consignar(0,'Valledupar');
        $this->assertEquals('El valor a consignar es incorrecto',$resultado);
    }

    /*
     *
        Escenario:  consignación correcta
        HU 3. Como Usuario quiero realizar consignaciones a una cuenta corriente para salvaguardar el dinero.
        Criterio de Aceptación:
        3.1 La consignación inicial debe ser de mínimo 100 mil pesos.
        3.2 El valor consignado debe ser adicionado al saldo de la cuenta.
        Dado
        El cliente tiene una cuenta corriente Número 1001, Nombre “Cuenta Ejemplo” , Ciudad “Valledupar”, Saldo de $0
        Cuando
        va a realizar una consignación de $100000 mil pesos m/c
        Entonces
        El sistema debe arrojar un mensaje : "Su nuevo saldo es de $100,000 pesos m/c"
     */
    public function testConsignacionCorrecta()
    {
        $cuentaCorriente = new CuentaCorriente('10001','Cuenta Ejemplo','Valledupar',0.00,0);
        $resultado = $cuentaCorriente->consignar(100000,'Valledupar');
        $this->assertEquals('Su nuevo saldo es de $100,000.00 pesos m/c',$resultado);
    }

    /*
     * Escenario: Consignación Inicial Incorrecta
            HU3: Como Usuario quiero realizar consignaciones a una cuenta corriente para salvaguardar el dinero.
            Criterio de Aceptación:
            3.1 La consignación inicial debe ser de mínimo 100 mil pesos.
            Dado El cliente tiene una cuenta corriente con
            Número 10001, Nombre “Cuenta ejemplo”, Saldo de 0
            Cuando Va a consignar el valor inicial de $99.950 pesos
            Entonces El sistema no registrará la consignación
            AND presentará el mensaje. “El valor mínimo de la primera consignación debe ser
            de $50.000 mil pesos. Su nuevo saldo es $0 pesos”.
     */
    public function testConsignacionInicialIncorrecta() : void {
        $cuentaAhorro = new CuentaCorriente('1001','Cuenta de Ejemplo','Valledupar',0,0);
        $resultado = $cuentaAhorro->consignar(99950,'Valledupar');
        $this->assertEquals('El valor mínimo de la primera consignación debe ser de $100,000.00 mil pesos. Su nuevo saldo es $0 pesos',$resultado);
    }

    /*
  * Escenario: Consignación posterior a la inicial correcta
     HU3: Como Usuario quiero realizar consignaciones a una cuenta corriente para salvaguardar el dinero.
     Criterio de Aceptación:
     1.3 El valor de la consignación se le adicionará al valor del saldo aumentará
     Dado El cliente tiene una cuenta corriente con un saldo de 80000
     Cuando Va a consignar el valor inicial de $99.950 pesos
     Entonces El sistema registrará la consignación
     AND presentará el mensaje. “Su Nuevo Saldo es de $79.950,00 pesos m/c”.
  */
    public function testConsignacionPosteriorAlaInicialCorrecta() {
        $cuentaAhorro = new CuentaCorriente('10001','Cuenta de Ejemplo','Valledupar',80000,0);
        $resultado = $cuentaAhorro->consignar(99950,'Valledupar');
        $this->assertEquals('Su nuevo saldo es de $179,950.00 pesos m/c',$resultado);
    }



}
