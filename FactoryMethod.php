<?php

/* 
    Factory Method:
    Objetivo: Encapsular a escolha da classe concreta a ser utilizada 
    na criação de objetos de um determinado tipo.
*/

interface EmissorInterface {
    public function envia($mensagem);
}

class EmissorSMS implements EmissorInterface {

    public function envia($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Argumento não é uma string');

        echo "Enviando por SMS a mensagem: $mensagem";
    }
}

class EmissorEmail implements EmissorInterface {

    public function envia($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Argumento não é uma string');

        echo "Enviando por email a mensagem: $mensagem";
    }
}

class EmissorJMS implements EmissorInterface {

    public function envia($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Argumento não é uma string');

        echo "Enviando por JMS a mensagem: $mensagem";
    }
}

class EmissorCreator {

    const SMS = 0;
    const EMAIL = 1;
    const JMS = 2;

    public function create($tipoDeEmissor) {

        if (!is_int($tipoDeEmissor))
            throw new InvalidArgumentException('Argumento não é uma string');

        if($tipoDeEmissor == self::SMS) {
            return new EmissorSMS();
        } else if($tipoDeEmissor == self::EMAIL) {
            return new EmissorEmail();
        } else if($tipoDeEmissor == self::JMS) {
            return new EmissorJMS();
        } else {
            throw new InvalidArgumentException("Tipo de emissor não suportado");
        }
    }
}

$creator = new EmissorCreator();

$emissor = $creator->create(EmissorCreator::SMS);
$emissor->envia('Estudando o Factory Method');

echo '<hr />';

$emissor = $creator->create(EmissorCreator::EMAIL);
$emissor->envia('Estudando o Factory Method');

echo '<hr />';

$emissor = $creator->create(EmissorCreator::JMS);
$emissor->envia('Estudando o Factory Method');