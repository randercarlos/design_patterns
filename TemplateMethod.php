<?php

/*
Objetivo: Definir a ordem na qual determinados passos devem ser realizados na resolução de um
problema e permitir que esses passos possam ser realizados de formas diferentes de acordo com a situação.
*/

abstract class Conta {
    private $saldo;

    public function deposita($valor) {
        $this->saldo += $valor;
        $this->saldo -= $this->calculaTaxa();
    }

    public function saca($valor) {
        $this->saldo -= $valor;
        $this->saldo -= $this->calculaTaxa();
    }

    public function getSaldo () {
        return $this->saldo;
    }

    public abstract function calculaTaxa();
}

class ContaCorrente extends Conta {
    public function calculaTaxa() {
        return 3;
    }
}

class ContaPoupanca extends Conta {
    public function calculaTaxa() {
        return 1;
    }
}

$contaCorrente = new ContaCorrente();
$contaPoupanca = new ContaPoupanca();

$contaCorrente->deposita(100);
$contaCorrente->saca(10);

$contaPoupanca->deposita(100);
$contaPoupanca->saca(10);

echo "<br />Saldo da Conta Corrente: " . $contaCorrente->getSaldo();
echo "<br />Saldo da Conta Poupança: " . $contaPoupanca->getSaldo();