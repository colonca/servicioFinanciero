<?php

namespace test\src\Banco\Domain;

use PHPUnit\Framework\TestCase;
use src\Banco\Domain\CuentaCorriente;

class CuentaCorrienteRetiroTest extends TestCase
{

    /*
     *
        Escenario:  retiro incorrecto
        HU 4. Como Usuario quiero realizar retiros a una cuenta corriente para salvaguardar el dinero
        Criterio de Aceptación:
        4.1 El valor a retirar se debe descontar del saldo de la cuenta.
        4.2 El saldo mínimo deberá ser mayor o igual al cupo de sobregiro.
        4.3 El retiro tendrá un costo del 4×Mil
        Dado
        El cliente tiene una cuenta corriente Numero 1001, Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $50000, cupodesobregiro $40000
        Cuando
        va a retirar 50000 mil pesos
        Entonces
        El sistema presentará el mensaje. “cupo de sobregiro superado, Retiro cancelado”
     */

    public function testRetiroIncorrecto() : void {
        $cuentaCorriente = new CuentaCorriente('1001','Cuenta Ejemplo','Valledupar',50000,40000);
        $resultado = $cuentaCorriente->retirar(50000,new \DateTime('NOW'));
        $this->assertEquals('cupo de sobregiro superado, Retiro cancelado',$resultado);
    }


    /*
     *
        Escenario:  retiro correcto
        HU 4. Como Usuario quiero realizar retiros a una cuenta corriente para salvaguardar el dinero
        Criterio de Aceptación:
        4.1 El valor a retirar se debe descontar del saldo de la cuenta.
        4.2 El saldo mínimo deberá ser mayor o igual al cupo de sobregiro.
        4.3 El retiro tendrá un costo del 4×Mil
        Dado
        El cliente tiene una cuenta corriente Numero 1001, Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $80000, cupodesobregiro $40000
        Cuando
        va a retirar 30000 mil pesos
        Entonces
        El sistema descontara los 30000 mil de la cuenta AND
        El sistema presentará el mensaje. “Su nuevo saldo es de $49,880.00 pesos m/c”
     */

    public function testRetiroCorrecto() : void {
        $cuentaCorriente = new CuentaCorriente('1001','Cuenta Ejemplo','Valledupar',80000,40000);
        $resultado = $cuentaCorriente->retirar(30000,new \DateTime('NOW'));
        $this->assertEquals('Su nuevo saldo es de $49,880.00 pesos m/c',$resultado);
    }

}
