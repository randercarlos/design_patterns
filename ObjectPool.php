<?php

/*
Objetivo: Possibilitar o reaproveitamento de objetos.
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

interface PoolInterface {
    public function acquire();
    public function release($t);
}

class FuncionarioPool implements PoolInterface {
    private $funcionarios;

    public function __construct(){
        $this->funcionarios = array();
        $this->funcionarios[] = new Funcionario("Marcelo Martins");
        $this->funcionarios[] = new Funcionario("Rafael Cosentino");
        $this->funcionarios[] = new Funcionario("Jonas Hirata");
    }

    public function acquire() {
        if(count($this->funcionarios) > 0) {
            return array_shift($this->funcionarios);
        }
        else {
            return null;
        }
    }

    public function release($funcionario) {
        $this->funcionarios[] = $funcionario;
    }
}

$funcionarioPool = new FuncionarioPool();
$funcionario = $funcionarioPool->acquire();

while ($funcionario != null) {
    echo $funcionario->getNome() . '<br />';
    $funcionario = $funcionarioPool->acquire();
}