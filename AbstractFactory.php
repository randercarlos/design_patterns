<?php

/*
Objetivo: Encapsular a escolha das classes concretas a serem 
utilizadas na criação dos objetos de diversas famílias.
*/

interface ComunicadorFactoryInterface {

    public function createEmissor();
    public function createReceptor();
}

interface EmissorInterface {
    public function envia($mensagem);
}

interface ReceptorInterface {
    public function recebe();
}

class ReceptorVisa implements ReceptorInterface {

    public function recebe() {
        echo 'Recebendo mensagem da Visa...';

        return 'Mensagem da Visa';
    }
}

class ReceptorMastercad implements ReceptorInterface {

    public function recebe() {
        echo 'Recebendo mensagem da Mastercad...';
        
        return 'Mensagem da Mastercad';
    }
}

class EmissorVisa implements EmissorInterface {
     public function envia($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Argumento não é uma string');

        echo 'Enviando a mensagem para a Visa: ';
        echo $mensagem;
     }
}

class EmissorMastercard implements EmissorInterface {
     public function envia($mensagem) {
        if (!is_string($mensagem))
            throw new InvalidArgumentException('Argumento não é uma string');

        echo 'Enviando a mensagem para a Mastercard: ';
        echo $mensagem;
     }
}

class EmissorCreator {

    const VISA = 0;
    const MASTERCARD = 1;

    public function create($tipoDoEmissor) {
        if($tipoDoEmissor == EmissorCreator::VISA) {
            return new EmissorVisa();
        } else if($tipoDoEmissor == EmissorCreator::MASTERCARD ) {
            return new EmissorMastercard();
        } else {
            throw new InvalidArgumentException("Tipo de emissor não suportado");
        }
    }
}

class ReceptorCreator {

    const VISA = 0;
    const MASTERCARD = 1;

    public function create($tipoDoReceptor) {
        if($tipoDoReceptor == ReceptorCreator::VISA) {
            return new ReceptorVisa();
        } else if($tipoDoReceptor == ReceptorCreator::MASTERCARD ) {
            return new ReceptorVisa();
        } else {
            throw new InvalidArgumentException("Tipo de receptor não suportado");
        }
    }
}

class VisaComunicadorFactory implements ComunicadorFactoryInterface {

    private $emissorCreator;
    private $receptorCreator;

    public function __construct() {
        $this->emissorCreator = new EmissorCreator();
        $this->receptorCreator = new ReceptorCreator();
    }

    public function createEmissor () {
        return $this->emissorCreator->create(EmissorCreator::VISA);
    }

    public function createReceptor () {
        return $this->receptorCreator->create(ReceptorCreator::VISA);   
    }
}

class MastercardComunicadorFactory implements ComunicadorFactoryInterface {

    private $emissorCreator;
    private $receptorCreator;

    public function __construct() {
        $this->emissorCreator = new EmissorCreator();
        $this->receptorCreator = new ReceptorCreator();
    }

    public function createEmissor () {
        return $this->emissorCreator->create(EmissorCreator::MASTERCARD);
    }

    public function createReceptor () {
        return $this->receptorCreator->create(ReceptorCreator::MASTERCARD);   
    }
}

$comunicadorFactory = new VisaComunicadorFactory();

$transacao = 'Valor=560;Senha=123';
$emissor = $comunicadorFactory->createEmissor();
$emissor->envia($transacao);

echo '<hr />';

$receptor = $comunicadorFactory->createReceptor();
echo  $receptor->recebe();

echo '<hr />';

$comunicadorFactory = new MastercardComunicadorFactory();

$transacao = 'Valor=32;Senha=239374';
$emissor = $comunicadorFactory->createEmissor();
$emissor->envia($transacao);

echo '<hr />';

$receptor = $comunicadorFactory->createReceptor();
echo  $receptor->recebe();