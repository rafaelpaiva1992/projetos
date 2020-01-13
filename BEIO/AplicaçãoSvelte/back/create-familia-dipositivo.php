<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação da Familia//////////////////
if(!isset($_POST['Familia'])){err('Falta o campo família!', __LINE__);}
if($_POST['Familia'] === ""){err('Preencha o campo família!', __LINE__);}

///////////////////validação da DescricaoFamilia//////////////////
if(!isset($_POST['Descricao'])){err('Falta o campo Descrição!', __LINE__);}
if($_POST['Descricao'] === ""){err('Preencha o campo Descrição!', __LINE__);}

require_once(__DIR__.'/protected/database.php');

try{

    $q = $db->prepare('INSERT INTO FamiliaDispositivo VALUES (NULL,:NomeFamilia, :DescricaoFamilia, NULL, NULL)');
    $q->bindValue(':NomeFamilia', $_POST['Familia']);
    $q->bindValue(':DescricaoFamilia', $_POST['Descricao']);
    $q->execute();
    $familiaId = $db->lastInsertId();
    echo '{"status":1, "Message":"Familia de dispositivo criado com sucesso!", "id":"'.$familiaId.'"}';

}catch(PDOException $ex){
   
    err('Não pode criar a familia verifique a query!', __LINE__);

}

function err($message = 'error', $debug = 0)
{

    echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
    exit();
}