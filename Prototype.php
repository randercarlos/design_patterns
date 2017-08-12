<?php


/*
Objetivo: Possibilitar a criação de novos objetos a partir da cópia de objetos existentes.
*/

interface PrototypeInterface {
    public function __clone();
}

class Campanha implements PrototypeInterface {

    private $nome;
    private $vencimento;
    private $palavrasChave;

    public function __construct($nome, DateTime $vencimento, array $palavrasChave) {
        $this->nome = $nome;
        $this->vencimento = $vencimento;
        $this->palavrasChave = $palavrasChave;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getVencimento() {
        return $this->vencimento;
    }

    public function getPalavrasChave() {
        return $this->palavrasChave;
    }

    public function __clone() {
        $nome = "Cópia da Campanha : $this->nome";
        $vencimento = $this->vencimento;
        $palavrasChave = $this->palavrasChave;

        $campanha = new Campanha($nome, $vencimento, $palavrasChave);

        return $campanha;
    }

    public function __toString() {
        $palavrasChave = implode(' - ', $this->palavrasChave);
        $str = <<<STR
        <hr />
        Nome da Campanha: {$this->nome}<br />
        Vencimento: {$this->vencimento->format('d/m/Y')}<br />
        Palavras-Chave: {$palavrasChave}<br />
STR;
        return $str;
    }
}

$nome = 'K19';
$vencimento = new DateTime();
$vencimento = $vencimento->add(new DateInterval('P30D'));

$palavrasChave = ['curso', 'java', 'K19'];

$campanha = new Campanha($nome, $vencimento, $palavrasChave);
echo $campanha;

$campanha2 = clone $campanha;
echo $campanha2;