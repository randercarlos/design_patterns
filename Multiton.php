<?php

/*
Objetivo: Permitir a criação de uma quantidade limitada de instâncias de determinada classe e
fornecer um modo para recuperá-las.
*/

class Tema {
    private $nome;
    private $corDoFundo;
    private $corDaFonte;
    private static $temas;

    const SKY = "Sky";
    const FIRE = "Fire";
    const BLUE = 'Blue';
    const RED = 'Red';

    private static function buildTemas() {
        self::$temas = [];

        $tema1 = new Tema();
        $tema1->setNome(self::SKY);
        $tema1->setCorDoFundo(self::BLUE);
        $tema1->setCorDaFonte(self::RED);

        $tema2 = new Tema();
        $tema2->setNome(self::FIRE);
        $tema2->setCorDoFundo(self::RED);
        $tema2->setCorDaFonte(self::BLUE);

        self::$temas[$tema1->getNome()] = $tema1;
        self::$temas[$tema2->getNome()] = $tema2;
    }

    public static function getInstance($nomeDoTema) {
        if (empty(self::$temas)) {
            self::buildTemas();
        }

        return self::$temas[$nomeDoTema];
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;    
    }

    public function getCorDoFundo() {
        return $this->corDoFundo;
    }

    public function setCorDoFundo($corDoFundo) {
        $this->corDoFundo = $corDoFundo;
    }

    public function getCorDaFonte() {
        return $this->corDaFonte;
    }

    public function setCorDaFonte($corDaFonte) {
        $this->corDaFonte = $corDaFonte ;
    }
}

$temaFire = Tema::getInstance(Tema::FIRE);
echo "Tema: " . $temaFire->getNome() . '<br />';
echo "Cor Da Fonte: " . $temaFire->getCorDaFonte() . '<br />';
echo "Cor Do Fundo: " . $temaFire->getCorDoFundo() . '<br />';


$temaFire2 = Tema::getInstance(Tema::FIRE);
echo '-------------------------------------' . '<br />';
echo 'Comparando as referências...' . '<br />';
echo $temaFire == $temaFire2 ? true : false;