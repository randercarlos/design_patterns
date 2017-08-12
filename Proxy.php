<?php

/*
Objetivo: Controlar as chamadas a um objeto através de outro objeto de mesma interface.
*/

interface ContaInterface {
    public function deposita($valor);
    public function saca($valor);
    public function getSaldo();
}

class ContaPadrao implements ContaInterface {
    private $saldo;

    public function deposita($valor) {
        $this->saldo += $valor;
    }

    public function saca($valor) {
        $this->saldo -= $valor;
    }

    public function getSaldo() {
        return $this->saldo;
    }
}

class ContaProxy implements ContaInterface {
    private $conta;

    public function __construct(ContaInterface $conta) {
        $this->conta = $conta;
    }

    public function deposita($valor) {
        echo "Efetuando o depósito de R$ " . $valor . "...";
        $this->conta->deposita($valor);
        echo "Depósito de R$ " . $valor . " efetuado...";
    }

    public function saca($valor) {
        echo "Efetuando o saque de R$ " . $valor . '...';
        $this->conta->saca($valor);
        echo "Saque de R$ " . $valor . " efetuado...";
    }

    public function getSaldo() {
        echo " Verificando o saldo... ";
        return $this->conta->getSaldo();
    }
}

$contaPadrao = new ContaPadrao();
$contaProxy = new ContaProxy($contaPadrao);
$contaProxy->deposita(100);
echo '<hr />';
$contaProxy->saca(59);
echo '<hr />';
echo "Saldo: R$ " . $contaProxy->getSaldo();