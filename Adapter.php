<?php

/*
Objetivo: Permitir que umobjeto seja substituído por outro que, apesar de realizar a mesma tarefa,
possui uma interface diferente.
*/

class Funcionario {
    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }
}

class ControleDePonto {

    public function registraEntrada(Funcionario $f) {
        $dataAtual = new DateTime();
        $dataAtual = $dataAtual->format('d/m/Y H:i:s');

        echo "Entrada: " . $f->getNome() . ' às ' . $dataAtual . '<br />';
    }

    public function registraSaida(Funcionario $f) {
        $dataAtual = new DateTime();
        $dataAtual = $dataAtual->format('d/m/Y H:i:s');

        echo "Saída: " . $f->getNome() . " às " . $dataAtual . '<br />';
    }
}

class ControleDePontoNovo {

    public function registra(Funcionario $f, $entrada) {
        $dataAtual = new DateTime();
        $dataAtual = $dataAtual->format('d/m/Y H:i:s');

        if ($entrada == true) {
            echo "Entrada: " . $f->getNome() . ' às ' . $dataAtual . '<br />';
        } else {
            echo "Saída: " . $f->getNome() . ' às ' . $dataAtual . '<br />';
        }
    }
}

class ControleDePontoAdapter {

    private $controleDePontoNovo;

    public function __construct() {
        $this->controleDePontoNovo = new ControleDePontoNovo();
    }

    public function registraEntrada(Funcionario $f) {
        $this->controleDePontoNovo->registra($f, true);
    }

    public function registraSaida(Funcionario $f) {
        $this->controleDePontoNovo->registra($f, false);  
    }
}


$controleDePonto = new ControleDePontoAdapter();
$funcionario = new Funcionario("Marcelo Martins");

$controleDePonto->registraEntrada($funcionario);
sleep(3) ;
$controleDePonto->registraSaida($funcionario);