<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação do Nome do Dispositivo//////////////////
if(!isset($_POST['Nome'])){err('Falta o campo nome!', __LINE__);}
if($_POST['Nome'] === ""){err('Preencha o campo nome!', __LINE__);}
if(strlen($_POST['Nome'])<3){err('Nome do dispositivo com no minimo 3 letras!', __LINE__);}

///////////////////validação do Codigo//////////////////
if(!isset($_POST['Codigo'])){err('Falta o campo Codigo!', __LINE__);}
if(strlen($_POST['Codigo'])>20){err('Codigo deve ter no máximo 20 caracter!', __LINE__);}

///////////////////validação do Descrição do Dispositivo//////////////////
if(!isset($_POST['Descricao'])){err('Falta o campo descrição!', __LINE__);}
if($_POST['Descricao'] === ""){err('Preencha o campo descrição!', __LINE__);}


require_once(__DIR__.'/protected/database.php');

try{

    $q = $db->prepare('INSERT INTO Dispositivo VALUES (NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL, :Nome, :CodigoLabel, :DescricaoDispositivo, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)');
    $q->bindValue(':Nome', $_POST['Nome']);
    $q->bindValue(':CodigoLabel', $_POST['Codigo']);
    $q->bindValue(':DescricaoDispositivo', $_POST['Descricao']);
    $q->execute();
    $dispositivoId = $db->lastInsertId();
    echo '{"status":1, "Message":"Dispositivo criado com sucesso!", "id":"'.$dispositivoId.'"}';

}catch(PDOException $ex){
   
    err('Não pode criar o usuário!', __LINE__);

}

function err($message = 'error', $debug = 0)
{

    echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
    exit();
}