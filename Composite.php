<?php

/*
Objetivo: Agrupar objetos que fazem parte de uma relação parte-todo de forma a tratá-los sem
distinção.
*/

interface TrechoInterface {
    public function imprime();
}

class TrechoAndando implements TrechoInterface {
    private $direcao;
    private $distancia;

    public function __construct($direcao, $distancia) {
        $this->direcao = $direcao;
        $this->distancia = $distancia;
    }

    public function imprime() {
        echo "<br />Vá Andando: " . '<br />';
        echo $this->direcao . '<br />';
        echo "A distância percorrida será de: " . $this->distancia . " metros<br />";
    }
}

class TrechoDeCarro implements TrechoInterface {
    private $direcao;
    private $distancia;

    public function __construct($direcao, $distancia) {
        $this->direcao = $direcao;
        $this->distancia = $distancia;
    }

    public function imprime() {
        echo "<br />Vá de Carro: " . '<br />';
        echo $this->direcao . '<br />';
        echo "A distância percorrida será de: " . $this->distancia . " metros<br />";
    }
}

class Caminho implements TrechoInterface {
    private $trechos;

    public function __construct() {
        $this->trechos = [];
    }

    public function adiciona(TrechoInterface $trecho) {
        $this->trechos[] = $trecho;
    }

    public function remove(TrechoInterface $trecho) {
        array_pop($this->trechos);
    }

    public function imprime() {
        foreach ($this->trechos as $trecho) {
            $trecho->imprime();
        }
    }
}

$trecho1 = new TrechoAndando("Vá até o cruzamento da Av. Rebouças com a Av. Brigadeiro Faria Lima", 500) ;
$trecho2 = new TrechoDeCarro("Vá até o cruzamento da Av. Brigadeiro Faria Lima com a Av. Cidade Jardim", 1500) ;
$trecho3 = new TrechoDeCarro("Vire a direita na Marginal Pinheiros", 500) ;

$caminho1 = new Caminho();
$caminho1->adiciona($trecho1);
$caminho1->adiciona($trecho2);

echo "Caminho 1: ";
$caminho1->imprime();

$caminho2 = new Caminho();
$caminho2->adiciona($caminho1);
$caminho2->adiciona($trecho3);
echo "<hr />";
echo "Caminho 2: ";
$caminho2->imprime();