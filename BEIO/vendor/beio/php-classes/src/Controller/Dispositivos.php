<?php

namespace Beio\Controller;

use \Beio\DB\Sql;

class Dispositivos
{

    public function inserir()
    {

        try {

            $sql = new Sql();
            $query = "INSERT INTO Dispositivo VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL, :Nome, :CodigoLabel, :DescricaoDispositivo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL";
            $params = array(
                ':Nome' => $_POST['Nome'],
                ':CodigoLabel' => $_POST['Codigo'],
                ':DescricaoDispositivo' => $_POST['Descricao'],
            );
            $sql->query($query, $params);

            $dispositivoId = $sql->lastInsertId();
            echo '{"status":1, "Message":"Dispositivo criado com sucesso!", "id":"' . $dispositivoId . '"}';

        } catch (PDOException $ex) {

            $this->err('Não pode criar o usuário!', __LINE__);

        }

    }

    public function alterar()
    {

        try {
            //CodigoLabel=:CodigoLabel, DescricaoDispositivo=:DescricaoDispositivo
            $sql = new Sql();
            $query = "UPDATE Dispositivo SET Nome = :Nome  WHERE ID = :ID";
            $paaram = array(
                ':Nome'=> $_POST['Nome'],
            );
            // $q->bindValue(':CodigoLabel', $_POST['Codigo']);
            // $q->bindValue(':DescricaoDispositivo', $_POST['Descricao']);
            $ql->query($query, $param);
            if (!$sql->rowCount()) {err('Não existe esse dipositivo!', __LINE__);}
            echo '{"status":1, "Message":"Dispositivo atualizado com sucesso!"}';
            exit();

        } catch (PDOException $ex) {

            $this->err('Não pode atualizar o Dipositivo verifique a query!', __LINE__);

        }

    }

    public  function buscarDispositivo($data)
    {
        if ($data['Pesquisa'] == '*')
        {
       try {
            
            $sql = new Sql();
            $query = "SELECT ID, Nome, CodigoLabel, DescricaoDispositivo from Dispositivo limit 15 ";
        
            $result = $sql->select($query);

            if (count($result) == 0) 
            {
                return err('Não existe esse dipositivo!', __LINE__);

            } else{
                return $result;
            }
            

        } catch (PDOException $ex) {

            return $this->err('Não pode atualizar o Dipositivo verifique a query!', __LINE__);

        }

    } else {
        try {
            //CodigoLabel=:CodigoLabel, DescricaoDispositivo=:DescricaoDispositivo
            $sql = new Sql();
            $query = "UPDATE Dispositivo SET Nome = :Nome  WHERE ID = :ID";
            $paaram = array(
                ':Nome'=> $_POST['Nome'],
            );
            // $q->bindValue(':CodigoLabel', $_POST['Codigo']);
            // $q->bindValue(':DescricaoDispositivo', $_POST['Descricao']);
            $ql->query($query, $param);
            if (!$sql->rowCount()) {err('Não existe esse dipositivo!', __LINE__);}
            echo '{"status":1, "Message":"Dispositivo atualizado com sucesso!"}';
            exit();

        } catch (PDOException $ex) {

            $this->err('Não pode atualizar o Dipositivo verifique a query!', __LINE__);

        }


    }

    }

    public function deletar()
    {

        try {

            $sql = new Sql();
            $query = "DELETE FROM Dispositivo WHERE ID = :ID";
            $params = array(
                ':ID'=> $_GET['ID'],
            );
            $sql->query($query, $params);

            if (!$sql->rowCount()) {err('Dispositivo não existe!', __LINE__);}
            echo '{"status":1, "message":"Dispositivo deletado!"}';
            exit();

        } catch (PDOException $ex) {

            $this->err('error ao executar a query', __LINE__);

        }

    } 

    
    public function inserirFamilia()
    {

        try {

            $sql = new Sql();
            $query = "INSERT INTO FamiliaDispositivo VALUES (NULL,:NomeFamilia, :DescricaoFamilia, NULL, NULL)";
            $params = array(
                ':NomeFamilia' => $_POST['Familia'],
                ':DescricaoFamilia' => $_POST['Descricao']
            );

            $sql->query($query, $params);
            $familiaId = $sql->lastInsertId();
            echo '{"status":1, "Message":"Familia de dispositivo criado com sucesso!", "id":"'.$familiaId.'"}';

}catch(PDOException $ex){
   
    $this->err('Não pode criar a familia verifique a query!', __LINE__);

}

    }

    
    public function deleteFamilia()
    {

        try {

            $sql = new Sql();
            $query = "DELETE FROM FamiliaDispositivo WHERE ID = :ID";
            $params = array(
                ':ID'=> $_GET['ID']
            );
            $sql->query($query, $params);

            if(!$q->rowCount()){err('Família de dispositivo não existe!', __LINE__);}
            echo '{"status":1, "message":"Família deletada!"}';
            exit();
        
        }catch(PDOException $ex){
        
            err('error ao executar a query', __LINE__);
        
        }

    }

    
    public function updateFamilia()
    {

        try {

            $sql = new Sql();
            $query = "";
            $params = array(
                
            );
            
            $sql->query($query, $params);

            if(!$q->rowCount()){err('Família de dispositivo não existe!', __LINE__);}
            echo '{"status":1, "message":"Família deletada!"}';
            exit();
        
        }catch(PDOException $ex){
        
            err('error ao executar a query', __LINE__);
        
        }

    }

    public function err($message = 'error', $debug = 0)
    {

        echo '{ "status":0,
                "message":"' . $message . '",
                "debug":' . $debug . '}';
        exit();
    }

}
