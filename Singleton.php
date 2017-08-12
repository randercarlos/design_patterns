<?php

/*
Objetivo: Permitir a criação de uma única instância de uma classe e fornecer um modo para
recuperá-la.
*/

class Configuracao {

    private $propriedades;
    private static $instance;

    private function __construct() {
        $this->propriedades = array("time-zone" => " America/Sao_Paulo", "currency-code" => "BRL");
    }

    public static function getInstance() {
        if (self::$instance == null ) {
            self::$instance = new Configuracao();
        }

        return self::$instance;
    }

    public function getPropriedade($nomeDaPropriedade) {
        if (!is_string($nomeDaPropriedade))
            throw new InvalidArgumentException('Argumento não é uma string');

        return $this->propriedades[$nomeDaPropriedade];
    }
}

$config = Configuracao::getInstance();
echo $config->getPropriedade('time-zone') . '<br />';
echo $config->getPropriedade('currency-code');