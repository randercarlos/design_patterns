<?php

/*
Objetivo: Alterar o comportamento de um determinado objeto de acordo com o estado no qual ele
se encontra.
*/

interface BandeiraInterface {
    public function calculaValorDaCorrida($tempo, $distancia);
}

class Taximetro {
    private $bandeira;

    public function __construct(BandeiraInterface $bandeira) {
        $this->bandeira = $bandeira;
    }

    public function setBandeira(BandeiraInterface $bandeira) {
        $this->bandeira = $bandeira;
    }

    public function calculaValorDaCorrida($tempo, $distancia) {
        return $this->bandeira->calculaValorDaCorrida($tempo, $distancia);
    }
}

class Bandeira1 implements BandeiraInterface {
    public function calculaValorDaCorrida($tempo, $distancia) {
        return 5.0 + $tempo * 1.5 + $distancia * 1.7;
    }
}

class Bandeira2 implements BandeiraInterface {
    public function calculaValorDaCorrida($tempo, $distancia) {
        return 10.0 + $tempo * 3.0 + $distancia * 4.0;
    }
}

$b1 = new Bandeira1();
$b2 = new Bandeira2();

$taximetro = new Taximetro($b1);

$valor1 = $taximetro->calculaValorDaCorrida(10, 20);
echo "<br />Valor da corrida em bandeira 1: " . $valor1;

$taximetro->setBandeira($b2);

$valor2 = $taximetro->calculaValorDaCorrida(5, 30);
echo "<br />Valor da corrida em bandeira 2: " . $valor2;