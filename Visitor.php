<?php

/*
Objetivo: Permitir atualizações específicas em uma coleção de objetos de acordo com o tipo particular
de cada objeto atualizado.
*/

abstract class Funcionario implements AtualizavelInterface {
    private $nome;
    private $salario;

    public function __construct($nome, $salario) {
        $this->nome = $nome;
        $this->salario = $salario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
    }
}

class Gerente extends Funcionario {
    private $senha;

    public function __construct($nome, $salario, $senha) {
        parent::__construct($nome, $salario);
        $this->senha = $senha;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function aceita(AtualizadorDeFuncionarioInterface $atualizador) {
        $atualizador->atualiza($this);
    }
}

class Telefonista extends Funcionario {
    private $ramal;

    public function __construct($nome, $salario, $ramal) {
        parent::__construct($nome, $salario);
        $this->ramal = $ramal;
    }

    public function getRamal() {
        return $this->ramal;
    }

    public function aceita(AtualizadorDeFuncionarioInterface $atualizador) {
        $atualizador->atualiza2($this);
    }
}

class Departamento implements AtualizavelInterface {
    private $nome;
    private $funcionarios;

    public function __construct($nome) {
        $this->funcionarios = [];
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getFuncionarios() {
        return $this->funcionarios;
    }

    public function add(Funcionario $func) {
        $this->funcionarios[] = $func;
    }

    public function aceita(AtualizadorDeFuncionarioInterface $atualizador) {
        foreach ($this->funcionarios as $funcionario) {
            $funcionario->aceita($atualizador);
        }
    }
}

interface AtualizadorDeFuncionarioInterface {
    public function atualiza(Gerente $g);
    public function atualiza2(Telefonista $t);
}

class AtualizadorSalarial implements AtualizadorDeFuncionarioInterface {
    public function atualiza(Gerente $g) {
        $g->setSalario($g->getSalario() * 1.43) ;
    }

    public function atualiza2(Telefonista $t) {
        $t->setSalario($t->getSalario() * 1.27) ;
    }
}

interface AtualizavelInterface {
    public function aceita(AtualizadorDeFuncionarioInterface $atualizador);
}

$lista = [];
$departamento = new Departamento("Departamento 1");
$gerente = new Gerente("Gerente 1", 1500, "1234");
$telefonista = new Telefonista("Telefonista", 1000, 2);

$departamento->add($gerente);
$departamento->add($telefonista);

$lista[] = $departamento;
$departamento2 = new Departamento("Departamento 2");
$gerente2 = new Gerente("Gerente 2", 1800, "1234");
$gerente3 = new Gerente("Gerente 3", 1800, "1234");
$telefonista2 = new Telefonista("Telefonista2", 1200, 1);

$departamento2->add($gerente2);
$departamento2->add($gerente3);
$departamento2->add($telefonista2);

$lista[] = $departamento2;

$atualizador = new AtualizadorSalarial();

foreach ($lista as $d) {
    $d->aceita($atualizador);
}

foreach ($lista as $d) {
    foreach ($d->getFuncionarios() as $f) {
        echo '<br />';
        echo "Nome: " . $f->getNome() . " - Salário: " . number_format($f->getSalario(), 2, ',', '.');
    }
}