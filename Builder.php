<?php

/*
Objetivo: Separar o processo de construção de um objeto de sua representação e 
permitir a sua criação passo-a-passo. Diferentes tipos de objetos podem ser 
criados comimplementações distintas de cada passo.
*/

interface BoletoInterface {

    public function getSacado();
    public function getCedente();
    public function getValor();
    public function getVencimento();

    public function getNossoNumero();
    public function __toString();
}

class BBBoleto implements BoletoInterface {

    private $sacado;
    private $cedente;
    private $valor;
    private $vencimento;
    private $nossoNumero;

    public function __construct($sacado, $cedente, $valor, DateTime $vencimento, $nossoNumero) {
        $this->sacado = $sacado ;
        $this->cedente = $cedente ;
        $this->valor = $valor ;
        $this->vencimento = $vencimento ;
        $this->nossoNumero = $nossoNumero ;
    }

    public function getSacado() {
        return $this->sacado;
    }

    public function getCedente() {
        return $this->cedente;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getVencimento() {
        return $this->vencimento;
    }

    public function getNossoNumero() {
        return $this->nossoNumero;
    }

    public function __toString() {
        $mensagem = <<<STR
        Boleto BB<br />
        Sacado: {$this->sacado}<br />
        Cedente: {$this->cedente}<br />
        Valor: {$this->valor}<br />
        Vencimento: {$this->vencimento->format('d/m/Y')}<br />  
        Nosso Número: {$this->nossoNumero}
STR;

        return $mensagem;
    }
}

interface BoletoBuilderInterface {
    public function buildSacado($sacado);
    public function buildCedente($cedente);
    public function buildValor($valor);
    public function buildVencimento(DateTime $vencimento);
    public function buildNossoNumero($nossoNumero);

    public function getBoleto();
}

class BBBoletoBuilder implements BoletoBuilderInterface {

    private $sacado;
    private $cedente;
    private $valor;
    private $vencimento;
    private $nossoNumero;

    public function buildSacado($sacado) {
        if (!is_string($sacado))
            throw new InvalidArgumentException('Argumento não é uma string');

        $this->sacado = $sacado;
    }

    public function buildCedente($cedente) {
        if (!is_string($cedente))
            throw new InvalidArgumentException('Argumento não é uma string');

        $this->cedente = $cedente;
    }

    public function buildValor($valor) {
        if (!is_numeric($valor))
            throw new InvalidArgumentException('Argumento não é um número');

        $this->valor = floatval($valor);
    }

    public function buildVencimento(DateTime $vencimento) {
        $this->vencimento = $vencimento;
    }

    public function buildNossoNumero($nossoNumero) {
        if (!is_int($nossoNumero))
            throw new InvalidArgumentException('Argumento não é um número inteiro');

        $this->nossoNumero = $nossoNumero;
    }

    public function getBoleto() {
         return new BBBoleto($this->sacado, $this->cedente, $this->valor, $this->vencimento, $this->nossoNumero);
    }
}

class GeradorDeBoleto {

    private $boletoBuilder;

    public function __construct(BoletoBuilderInterface $boletoBuilder) {
        $this->boletoBuilder = $boletoBuilder ;
    }

    public function geraBoleto() {

        $this->boletoBuilder->buildSacado(" Marcelo Martins ");
        $this->boletoBuilder->buildCedente(" K19 Treinamentos ");
        $this->boletoBuilder->buildValor(100.54);

        $data = new DateTime();
        $this->boletoBuilder->buildVencimento($data->add(new DateInterval('P30D')));
        $this->boletoBuilder->buildNossoNumero(1234);

        return $this->boletoBuilder->getBoleto();
    }
}

$boletoBuilder = new BBBoletoBuilder();
$geradorDeBoleto = new GeradorDeBoleto($boletoBuilder);
$boleto = $geradorDeBoleto->geraBoleto();

echo $boleto;