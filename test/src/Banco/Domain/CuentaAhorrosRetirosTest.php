<?php

namespace test\src\Banco\Domain;

use PHPUnit\Framework\TestCase;
use src\Banco\Domain\CuentaAhorros;

class CuentaAhorrosRetirosTest extends TestCase
{

    /*
    *
       Escenario:  Retiro con un saldo mínimo
       HU 2. Como Usuario quiero realizar retiros a una cuenta de ahorro para obtener el dinero en efectivo
       Criterio de Aceptación:
       2.1 El valor a retirar se debe descontar del saldo de la cuenta.
       2.2 El saldo mínimo de la cuenta deberá ser de 20 mil pesos.
       Dado
       El cliente tiene una cuenta de ahorro Numero 1001, Nombre “Cuenta Ejemplo”,Ciudad Valledupar, Saldo de $10000
       Cuando
       va a retirar 50000 mil pesos
       Entonces
       El sistema presentará el mensaje. “El saldo mínimo para poder retirar es de $20,000.00, Retiro cancelado”
    */

    public function testRetiroConUnSaldoMinimo(): void
    {
        $cuentaAhorro = new CuentaAhorros('1001', 'Cuenta Ejemplo', 'Valledupar', 10000);
        $resultado = $cuentaAhorro->retirar(50000,new \DateTime('NOW'));
        $this->assertEquals('El saldo mínimo para poder retirar es de $20,000.00 pesos m/c, Retiro cancelado',$resultado);
    }

    /*
     *
        Escenario:  Retiro correcto
        HU 2. Como Usuario quiero realizar retiros a una cuenta de ahorro para obtener el dinero en efectivo
        Criterio de Aceptación:
        2.1 El valor a retirar se debe descontar del saldo de la cuenta.
        2.2 El saldo mínimo de la cuenta deberá ser de 20 mil pesos.
        Dado
        El cliente tiene una cuenta de ahorro Numero 1001, Nombre “Cuenta Ejemplo”,Ciudad Valledupar Saldo de $50000
        Cuando
        va a retirar 50000 mil pesos
        Entonces
        El sistema presentará el mensaje. “Su Nuevo Saldo es de $0 pesos m/c”
     */
       public function testRetiroCorrecto(){
            $cuentaAhorro = new CuentaAhorros('1001', 'Cuenta Ejemplo', 'Valledupar', 50000);
            $resultado = $cuentaAhorro->retirar(50000,new \DateTime('NOW'));
            $this->assertEquals('Su nuevo saldo es de $0.00 pesos m/c',$resultado);
        }

    /*
     *
        Escenario:  Retiros sin costos
        HU 2. Como Usuario quiero realizar retiros a una cuenta de ahorro para obtener el dinero en efectivo
        Criterio de Aceptación:
        2.1 El valor a retirar se debe descontar del saldo de la cuenta.
        2.2 El saldo mínimo de la cuenta deberá ser de 20 mil pesos.
        2.3 Los primeros 3 retiros del mes no tendrán costo.
        Dado
        El cliente tiene una cuenta de ahorro Numero 1001, Nombre “Cuenta Ejemplo” , Ciudad “Valledupar”, Saldo de $50000
        Cuando
        va a realizar tres retiros en tres fechas distintas del mes de febrero
        la primer el día  11/03/2020 por $10,000.00 pesos m/c
        la segunda el día 15/03/2020  por $10,000.00 pesos m/c
        la tercera el día 24/03/2020 por $20,000.00 pesos m/c
        Entonces
        El sistema debe arrojar un mensaje : "Su Nuevo Saldo es de $10,000.00 pesos m/c"
     */

    public function testRetirosSinCostos() : void {
        $cuentaAhorro = new CuentaAhorros('1001', 'Cuenta Ejemplo', 'Valledupar', 50000);
        $primeraFecha =  new \DateTime('11-03-2020');
        $resultado = $cuentaAhorro->retirar(10000,$primeraFecha);
        $segundaFecha =  new \DateTime('15-03-2020');
        $resultado = $cuentaAhorro->retirar(10000,$segundaFecha);
        $terceraFecha =  new \DateTime('24-03-2020');
        $resultado = $cuentaAhorro->retirar(20000,$terceraFecha);
        $this->assertSame('Su nuevo saldo es de $10,000.00 pesos m/c',$resultado);
    }

    /*
     *
        Escenario:  Retiro con costo
        HU 2. Como Usuario quiero realizar retiros a una cuenta de ahorro para obtener el dinero en efectivo
        Criterio de Aceptación:
        2.1 El valor a retirar se debe descontar del saldo de la cuenta.
        2.2 El saldo mínimo de la cuenta deberá ser de 20 mil pesos.
        2.3 Los primeros 3 retiros del mes no tendrán costo.
        2.4 Del cuarto retiro en adelante del mes tendrán un valor de 5 mil pesos.
        Dado
        El cliente tiene una cuenta de ahorro Numero 1001, Nombre “Cuenta Ejemplo” , Ciudad “Valledupar”, Saldo de $80000
        Cuando
        va a realizar cuatro retiros en cuatro fechas distintas del mes de marzo
        la primer el día  11/03/2020 por $10,000.00 pesos m/c
        la segunda el día 15/03/2020  por $10,000.00 pesos m/c
        la tercera el día 24/03/2020 por $20,000.00 pesos m/c
        la cuarta el día 25/03/2020 por $20,000.00 pesos m/c
        Entonces
        El sistema debe arrojar un mensaje : "Su nuevo saldo es de $15,000.00 pesos m/c"
     */

    public function testRetiroConCosto(){
        $cuentaAhorro = new CuentaAhorros('1001', 'Cuenta Ejemplo', 'Valledupar', 80000);
        $primeraFecha =  new \DateTime('11-03-2020');
        $resultado = $cuentaAhorro->retirar(10000,$primeraFecha);
        $segundaFecha =  new \DateTime('15-03-2020');
        $resultado = $cuentaAhorro->retirar(10000,$segundaFecha);
        $terceraFecha =  new \DateTime('24-03-2020');
        $resultado = $cuentaAhorro->retirar(20000,$terceraFecha);
        $terceraFecha =  new \DateTime('25-03-2020');
        $resultado = $cuentaAhorro->retirar(20000,$terceraFecha);
        $this->assertSame('Su nuevo saldo es de $15,000.00 pesos m/c',$resultado);
    }

}
