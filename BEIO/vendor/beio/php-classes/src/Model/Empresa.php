<?php

namespace Beio\Model;
use \Beio\DB\Sql;
use \Beio\Model;

  

class Empresa extends Model{

public function inserir($data){

    $sql = new Sql();
    $query = "INSERT INTO Empresa ( EmpresaIDFK, Empresa, CNPJ, Logo)  VALUES ( :EMPRESAIDFK, :EMPRESA, :CNPJ, :LOGO )";

    $params = array(
        ':EMPRESAIDFK' => $data[''],
        ':EMPRESA' => $data[''], 
        ':CNPJ' => $data[''], 
        ':LOGO' => $data[''], 
        
    );
     
    $sql->query($query, $params);

}
  


public function bucarEmpresas($id){

    $query = "SELECT ID, Empresa FROM Empresa where ID = :ID OR EmpresaIDFK = :ID ";
    $params = array (
        ':ID'=> $id
    );
    $sql = New Sql();
    $results = $sql->select($query,$params);
    return $results;
}

public function alterar(){
    
}

public function deletar(){
    
}

}
