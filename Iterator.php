<?php

/*
Objetivo: Fornecer um modo eficiente para percorrer sequencialmente os elementos de uma coleção,
sem que a estrutura interna da coleção seja exposta.
*/

class ListaDeNomes implements Iterator {
    private $nomes;
    private $length;
    private $i;

    public function __construct(array $nomes) {
        $this->nomes = $nomes;
        $this->length = count($this->nomes);
        $this->i = 0;
    }

    public function iterator() {
        return $this->listaDeNomesIterator();
    }
   
    public function valid() {
        return ($this->i < $this->length);
    }

    public function next() {
        return $this->nomes[$this->i++];
    }

    public function rewind() {
        $this->i = 0;
    }

    public function current() {
        return $this->nomes[$this->i];
    }

    public function key() {
        return $this->i;
    }

    public function remove() {
        $this->nomes[$this->i] = null;

        for ($j = $this->i; ($j + 1) < $this->length; $j++) {
            $this->nomes[$j] = $this->nomes[$j + 1];
        }

        $this->length--;
    }
}


$nomes = [];
$nomes[0] = " Rafael Cosentino ";
$nomes[1] = " Marcelo Martins ";
$nomes[2] = " Jonas Hirata ";
$nomes[3] = " Solange Domingues ";

$listaDeNomes = new ListaDeNomes($nomes);
$listaDeNomes->valid();
$listaDeNomes->remove();

while ($listaDeNomes->valid()) {
    $nome = $listaDeNomes->current();
    echo $nome . '<br />';

    $listaDeNomes->next();
}

echo '<hr />';
echo 'Testando o foreach: ' . '<br />';
foreach ($listaDeNomes as $key => $value) {
    echo $value . '<br />';
} 