<?php

/*
Objetivo: Compartilhar, de forma eficiente, objetos que são usados em grande quantidade.
*/

interface TemaFlyweightInterface {
    public function imprime($titulo, $texto);
}

class TemaHifen implements TemaFlyweightInterface {
    public function imprime($titulo, $texto) {
        echo '----------------------------' . $titulo . '----------------------------';
        echo '<br />' . $texto . '<br />';
        $rodape = [];
        $rodape = array_fill(0, 150, '-');
        echo implode('', $rodape);
    }
}

class TemaAsterisco implements TemaFlyweightInterface {
    public function imprime($titulo, $texto) {
        echo '********************************' . $titulo . '********************************';
        echo '<br />' . $texto . '<br />';
        $rodape = [];
        $rodape = array_fill(0, 100, '*');
        echo implode('', $rodape);
    }
}

class TemaK19 implements TemaFlyweightInterface {
    public function imprime($titulo, $texto) {
        echo '#######################################' . strtoupper($titulo) . '#######################################';
        echo '<br />' . $texto . '<br />';
        $rodape = [];
        $rodape = array_fill(0, 50, '#');
        echo (implode('', $rodape)) . ' www.k19.com.br ' . (implode('', $rodape));
    }
}

class TemaFlyweightFactory {
    
    const ASTERISCO = 'TemaAsterisco';
    const HIFEN = 'TemaHifen';
    const K19 = 'TemaK19';
    private static $temas = array('TemaAsterisco', 'TemaHifen', 'TemaK19');

    public static function getTema($clazz) {
        if (in_array($clazz, self::$temas)) {
            return new $clazz();
        }

        return null;
    }
}

class Slide {
    private $tema;
    private $titulo;
    private $texto;

    public function __construct(TemaFlyweightInterface $tema, $titulo, $texto) {
        $this->tema = $tema;
        $this->titulo = $titulo;
        $this->texto = $texto;
    }

    public function imprime() {
        $this->tema->imprime($this->titulo, $this->texto);
    }
}

class Apresentacao {
    private $slides = [];

    public function adicionaSlide(Slide $slide) {
        $this->slides[] = $slide;
    }

    public function imprime() {
        foreach ($this->slides as $slide) {
            $slide->imprime();
            echo '<hr />';
        }
    }
}

$a = new Apresentacao();
$a->adicionaSlide(new Slide(TemaFlyweightFactory::getTema(TemaFlyweightFactory::K19)," K11 - Orientação a Objetos em Java ", " Com este curso você vai obter uma base sólida de conhecimentos de Java e de Orientação a Objetos"));
$a->adicionaSlide(new Slide(TemaFlyweightFactory::getTema(TemaFlyweightFactory::ASTERISCO),
    " K12 - Desenvolvimento Web com JSF2 e JPA2 ", " Depois deste curso , você estará apto a"
    . " desenvolver aplicações Web com os padrões da plataforma Java ."));
$a->adicionaSlide(new Slide(TemaFlyweightFactory::getTema(TemaFlyweightFactory::HIFEN),
    " K21 - Persistência com JPA2 e Hibernate ","Neste curso de Java Avançado, abordamos de maneira profunda os recursos de persistência do JPA2 e do Hibernate."));

$a->imprime();