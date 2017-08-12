<?php

/*
Objetivo: Diminuir a quantidade de “ligações” entre objetos introduzindo um mediador, através
do qual toda comunicação entre os objetos será realizada.
*/

class Passageiro {
    private $nome;
    private $central;

    public function __construct($nome, CentralDeTaxi $central) {
        $this->nome = $nome;
        $this->central = $central;
    }

    public function getNome() {
        return $this->nome;
    }
}

class Taxi {
    private $id;
    private $central;
    private static $contador = 0;

    public function __construct(CentralDeTaxi $central) {
        $this->central = $central;
        $this->id = self::$contador++;
    }

    public function getId() {
        return $this->id;
    }

    public function atende() {
        try {
            //sleep(1);
            echo 'Atendendo táxi';
        } catch(Exception $e) {
            $e->getTraceAsString();
        }
    }
}

class CentralDeTaxi {
    private $taxisLivres = [];
    private $passageirosEmEspera = [];

    public function pedeTaxi(Passageiro $passageiro) {
        $taxi = $this->esperaTaxi($passageiro);
        echo "Taxi " . $taxi->getId() . " levando " . $passageiro->getNome();
        $taxi->atende();
    }

    public function adicionaTaxiDisponivel(Taxi $taxi) {
        echo " Taxi " . $taxi->getId() . " voltou pra fila";
        $this->taxisLivres[] = $taxi;
    }

    private function esperaTaxi(Passageiro $passageiro) {
        $this->passageirosEmEspera[] = $passageiro;

        while (empty($this->taxisLivres) || !($this->passageirosEmEspera[0] == $passageiro)) {
            try {
                //sleep(1);
                echo 'Esperando táxi...';
            } catch (Exception $e) {
                $e->getTraceAsString();
            }
        }

        array_shift($this->passageirosEmEspera);
        return array_shift($this->taxisLivres);
    }
}



$central = new CentralDeTaxi();

$p1 = new Passageiro("Rafael Cosentino", $central);
$p2 = new Passageiro("Marcelo Martins", $central);
$p3 = new Passageiro("Jonas Hirata", $central);

$t1 = new Taxi($central);
$central->adicionaTaxiDisponivel($t1);

$t2 = new Taxi($central);
$central->adicionaTaxiDisponivel($t2);

$central->pedeTaxi($p1);
$central->pedeTaxi($p2);
$central->pedeTaxi($p3);

