<?php

namespace Beio;

// Para fazer os Get and set de todas os metodos automatico
class Model{

private $valores = [];

public function __call($name, $argumentos ){

    $metodo = substr($name, 0, 3); // Se é Get ou Set
    $valor = substr($name, 3, strlen($name) );

    switch($metodo){
        case "get":
           return $this->valores[$valor];
        break;
        
        case "set":
             $this->valores[$valor]=$argumentos[0];
        break;

    }

}

public function setData($dados = array() ){

    foreach($dados as $key => $value){

        $this->{"set".$key}($value);
    }

}

function getValues(){

    return $this->valores;
}
    
}