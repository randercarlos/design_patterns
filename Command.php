<?php

/*
Objetivo: Controlar as chamadas a um determinado componente, modelando cada requisição
como umobjeto. Permitir que as operações possam ser desfeitas, enfileiradas ou registradas.
*/

class Player {

    public function play($filename) {
        echo "<br />Tocando o arquivo " . $filename;
        $duracao = rand(1, 5);
        echo "<br />Duração (s): " . $duracao . ' segundos';
        sleep($duracao);
        echo "<br />Fim" . '<hr />';
    }

    public function increaseVolume($levels) {
        echo "Diminuindo o volume em " . $levels . '<hr />';
    }

    public function decreaseVolume($levels) {
        echo "Aumentando o volume em " . $levels . '<hr />';
    }
}

interface ComandoInterface {
    public function executa();
}


class TocaMusicaComando implements ComandoInterface {
    private $player;
    private $file;

    public function __construct(Player $player, $file) {
        $this->player = $player;
        $this->file = $file;
    }

    public function executa() {
        try {
            $this->player->play($this->file);
        } catch (Exception $e) {
            $e->getTraceAsString();
        }
    }
}

class AumentaVolumeComando implements ComandoInterface {
    private $player;
    private $levels;

    public function __construct(Player $player, $levels) {
        $this->player = $player;
        $this->levels = $levels;
    }

    public function executa() {
        $this->player->increaseVolume($this->levels);
    }
}

class DiminuiVolumeComando implements ComandoInterface {
    private $player;
    private $levels;

    public function __construct(Player $player, $levels) {
        $this->player = $player;
        $this->levels = $levels;
    }

    public function executa() {
        $this->player->decreaseVolume($this->levels);
    }
}

class ListaDeComandos {
    private $comandos;

    public function __construct() {
        $this->comandos = new ArrayObject();
    }

    public function adiciona(ComandoInterface $comando) {
        $this->comandos->append($comando);
    }

    public function executa() {

        $iterator = $this->comandos->getIterator();
        while($iterator->valid()) {
            $iterator->current()->executa() . "<br />";

            $iterator->next();
        }
    }
}


$player = new Player();
$listaDeComandos = new ListaDeComandos();

$listaDeComandos->adiciona(new TocaMusicaComando($player, "musica1.mp3"));
$listaDeComandos->adiciona(new AumentaVolumeComando($player, 3));
$listaDeComandos->adiciona(new TocaMusicaComando($player, "musica2.mp3"));
$listaDeComandos->adiciona(new DiminuiVolumeComando($player, 3));
$listaDeComandos->adiciona(new TocaMusicaComando($player, "musica3.mp3"));

$listaDeComandos->executa();