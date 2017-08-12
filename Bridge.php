<?php

/*
Objetivo: Separar uma abstração de sua representação, de forma que ambos possam variar e produzir
tipos de objetos diferentes.
*/

interface DocumentoInterface {
    public function geraArquivo();
}

interface GeradorDeArquivoInterface {
    public function gera($conteudo);
}

class GeradorDeArquivoTXT implements GeradorDeArquivoInterface {
    public function gera($conteudo) {
        try {
            file_put_contents('arquivo.txt', $conteudo);
        } catch (InvalidArgumentException $e) {
            echo $e->getTraceAsString();
        }
    }
}

class Recibo implements DocumentoInterface {
    private $emissor;
    private $favorecido;
    private $valor;
    private $geradorDeArquivo;

    public function __construct($emissor, $favorecido, $valor, GeradorDeArquivo $geradorDeArquivo) {
        $this->emissor = $emissor;
        $this->favorecido = $favorecido;
        $this->valor = $valor;
        $this->geradorDeArquivo = $geradorDeArquivo;
    }

    public function geraArquivo() {
        try {
            $dados = <<<DADOS
            Recibo: 
            Empresa: {$this->emissor};
            Cliente: {$this->favorecido};
            Valor: {$this->valor};
DADOS;
            $this->geradorDeArquivo->gera($dados);
        } catch (InvalidArgumentException $e) {
            echo $e->getTraceAsString();
        }
    }
}

$geradorDeArquivoTXT = new GeradorDeArquivoTXT();
$recibo = new Recibo("K19 Treinamentos", "Marcelo Martins", 1000 , $geradorDeArquivoTXT);
$recibo->geraArquivo();