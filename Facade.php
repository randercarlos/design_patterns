<?php

/*
Objetivo: Prover uma interface simplificada para a utilização de várias interfaces de um subsistema.
*/

class Pedido {
    private $produto;
    private $cliente;
    private $enderecoDeEntrega;

    public function __construct($produto, $cliente, $enderecoDeEntrega) {
        $this->produto = $produto;
        $this->cliente = $cliente;
        $this->enderecoDeEntrega = $enderecoDeEntrega;
    }

    public function getProduto() {
        return $this->produto;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function getEnderecoDeEntrega() {
        return $this->enderecoDeEntrega;
    }
}

class Estoque {
    public function enviaProduto($produto, $enderecoDeEntrega) {
        $data = new DateTime();
        $data = $data->format('d/m/Y H:i:s');

        echo "<br />O produto " . $produto . " será entregue no endereço " . $enderecoDeEntrega
        . " até as 18h do dia " . $data;
    }
}

class Financeiro {
    public function fatura($cliente, $produto) {
        echo '<br />Fatura: ';
        echo '<br />Cliente: ' . $cliente;
        echo '<br />Produto: ' . $produto;
    }
}

class PosVenda {
    public function agendaContato($cliente, $produto) {
        $data = new DateTime();
        $data = $data->format('d/m/Y H:i:s');

        echo '<br />Entrar em contato com ' . $cliente . ' sobre o produto ' . $produto . " no dia " . $data;
    }
}

class PedidoFacade {
    private $estoque;
    private $financeiro;
    private $posVenda;

    public function __construct(Estoque $estoque, Financeiro $financeiro, PosVenda $posVenda) {
        $this->estoque = $estoque;
        $this->financeiro = $financeiro;
        $this->posVenda = $posVenda;
    }

    public function registraPedido(Pedido $p) {
        $this->estoque->enviaProduto($p->getProduto(), $p->getEnderecoDeEntrega());
        $this->financeiro->fatura($p->getCliente(), $p->getProduto());
        $this->posVenda->agendaContato($p->getCliente(), $p->getProduto());
    }
}

$estoque = new Estoque();
$financeiro = new Financeiro();
$posVenda = new PosVenda();
$pedido = new Pedido("Notebook", "Rafael Cosentino","Av Brigadeiro Faria Lima, 1571, São Paulo, SP");

$facade = new PedidoFacade($estoque, $financeiro, $posVenda);
$facade->registraPedido($pedido);