<?php

namespace Beio\Model;
use \Beio\DB\Sql;
use \Beio\Model;

  

class Endereco extends Model{

public function inserir($data){

    $sql = new Sql();
    $query = "INSERT INTO Endereco ( UsuarioIDFK, Descricao, CEP, Cidade, Estado, Pais, Logradouro, Bairro, Numero)  VALUES ( :USUARIO, :DESCRICAO, :CEP, :CIDADE, :ESTADO, :PAIS, :LOGRADOURO, :BAIRRO, :NUMERO)";

    $params = array(
        ':USUARIO' => $data['id'],
        ':DESCRICAO' => $data['descricao'], 
        ':CEP' => $data['cep'], 
        ':CIDADE' => $data['cidade'], 
        ':ESTADO' => $data['estado'], 
        ':PAIS' => $data['pais'], 
        ':LOGRADOURO' => $data['logradouro'], 
        ':BAIRRO' => $data['bairro'], 
        ':NUMERO' => $data['numero']
    );
     
    $sql->query($query, $params);

}
  



public function alterar(){
    
}

public function deletar(){
    
}

}
