<?php

/*
Objetivo: Permitir de maneira simples a variação dos algoritmos utilizados na resolução de um
determinado problema.
*/

class Item {

    private $nome;
    private $valor;

    public function __construct($nome, $valor) {
        $this->nome = $nome;
        $this->valor = $valor;
    }

    public function setValor($valor) {
        if (!is_numeric($valor))
            throw new InvalidArgumentException('Parâmetro não é um número!');

        $this->valor = $valor;
    }

    public function getValor() {
        return $this->valor;
    }
}

class Carrinho {
    private $itens;

    public function __construct() {
        $this->itens = array();
    }

    public function add(Item $item) {
        $this->itens[] = $item;
    }    

    // adiciona item, remove item e outros métodos do carrinho
    public function getTotal() {
        $total = 0;
        foreach($this->itens as $item) {
        $total += $item->getValor();
        }

        return $total;
    }

     // calcula o desconto
    public function getTotalComDesconto(FormaDePagamentoInterface $formaPagamento) {
        $total = $this->getTotal();
        $total = $formaPagamento->calcula($total);

        return $total;
    }

}


interface FormaDePagamentoInterface {
    public function calcula($total);
}

class DebitoOnline implements FormaDePagamentoInterface {
    // calcula o desconto
    public function calcula($total) {
        return $total * 0.93;
    }
}
 
class PayPal implements FormaDePagamentoInterface {
    // calcula o desconto
    public function calcula($total) {
        return $total * 0.95;
    }
}
 
class CartaoCredito implements FormaDePagamentoInterface {
    // calcula o desconto
    public function calcula($total) {
        return $total;
    }
}

$i1 = new Item("Monitor LCD LG 21'", 214.15);
$i2 = new Item("Mouse ótico Preto", 8.9);
$i3 = new Item("Teclado ABNT 2", 12.3);

$carrinho = new Carrinho();
$carrinho->add($i1);
$carrinho->add($i2);
$carrinho->add($i3);

echo 'Total: R$ ' . number_format($carrinho->getTotal(), 2, ',', '.');
echo '<br />Total com desconto(Paypal): R$ ' . number_format($carrinho->getTotalComDesconto(new PayPal()), 2, ',', '.');
echo '<br />Total com desconto(Débito): R$ ' . number_format($carrinho->getTotalComDesconto(new DebitoOnline()), 2, ',', '.');

