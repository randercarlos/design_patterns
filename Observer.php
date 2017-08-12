<?php

/*
Objetivo: Definir um mecanismo eficiente para reagir às alterações realizadas em determinados
objetos.
*/

class Acao {
    private $codigo;
    private $valor;
    private $interessados;

    public function __construct($codigo, $valor) {
        $this->codigo = $codigo;
        $this->valor = $valor;
        $this->interessados = [];
    }

    public function registraInteressado(AcaoObserverInterface $interessado) {
        $this->interessados[] = $interessado;
    }

    public function cancelaInteresse(AcaoObserverInterface $interessado) {
        for($i = 0; $i < count($this->interessados); $i++) {
            if ($this->interessados[$i] == $interessado) {
                $this->interessados[$i] = null;
            }
        }
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;

        foreach($this->interessados as $interessado) {
            $interessado->notificaAlteracao($this);
        }
    }

    public function getCodigo() {
        return $this->codigo;
    }
}

interface AcaoObserverInterface {
    public function notificaAlteracao(Acao $acao);
}

class Corretora implements AcaoObserverInterface {
    private $nome;

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function notificaAlteracao(Acao $acao) {
        echo "<br />Corretora " . $this->nome . " sendo notificada: ";
        echo "<br />A ação " . $acao->getCodigo() . " teve o seu valor alterado para " . $acao->getValor();
    }
}

$acao = new Acao("VALE3", 45.27);

$corretora1 = new Corretora("Corretora1");
$corretora2 = new Corretora("Corretora2");

$acao->registraInteressado($corretora1);
$acao->registraInteressado($corretora2);

$acao->setValor(50);