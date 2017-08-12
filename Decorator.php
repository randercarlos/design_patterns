<?php

/*
Objetivo: Adicionar funcionalidade a um objeto dinamicamente.
*/

interface EmissorInterface {
    public function envia($mensagem);
}

class EmissorBasico implements EmissorInterface {
    public function envia($mensagem) {
        echo "<br />Enviando uma mensagem: " . $mensagem;
    }
}

abstract class EmissorDecorator implements EmissorInterface {
    private $emissor;

    public function __construct(EmissorInterface $emissor) {
        $this->emissor = $emissor;
    }

    public abstract function envia($mensagem);

    public function getEmissor() {
        return $this->emissor;
    }
}

class EmissorDecoratorComCriptografia extends EmissorDecorator {

    public function __construct(EmissorInterface $emissor) {
        parent::__construct($emissor);
    }

    public function envia($mensagem) {
        echo "<br />Enviando mensagem criptografada: ";
        $this->getEmissor()->envia($this->criptografa($mensagem));
    }

    private function criptografa($mensagem) {
        $mensagemCriptografada = strrev($mensagem);

        return $mensagemCriptografada;
    }
}


class EmissorDecoratorComCompressao extends EmissorDecorator {

    public function __construct(EmissorInterface $emissor) {
        parent::__construct($emissor);
    }

    public function envia($mensagem) {
        echo "Enviando mensagem comprimida: ";

        $mensagemComprimida = '';
        try {
            $mensagemComprimida = $this->comprime($mensagem);
        } catch (Exception $e) {
            $mensagemComprimida = $mensagem; 
        }

        $this->getEmissor()->envia($mensagemComprimida);
    }

    private function comprime($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Parâmetro passado não é uma string!');

        return $mensagem . ' foi comprimida...';
    }
}

$mensagem = "PHP Orientado a objetos";

$emissorCript = new EmissorDecoratorComCriptografia(new EmissorBasico());
$emissorCript->envia($mensagem);

echo '<hr />';

$emissorCompr = new EmissorDecoratorComCompressao(new EmissorBasico());
$emissorCompr->envia($mensagem);

echo '<hr />';

$emissorCriptCompr = new EmissorDecoratorComCriptografia(
    new EmissorDecoratorComCompressao(new EmissorBasico()));
$emissorCriptCompr->envia($mensagem);