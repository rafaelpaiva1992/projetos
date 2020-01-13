<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação do Nome//////////////////
if(!isset($_POST['Nome'])){err('Falta o campo nome!', __LINE__);}
if($_POST['Nome'] === ""){err('Preencha o campo nome do dipositivo!', __LINE__);}
if(strlen($_POST['Nome'])<3){err('Nome do dispositivo com no minimo 3 letras!', __LINE__);}

///////////////////validação o ID//////////////////

if(!isset($_GET['ID'])){err('Falta o campo ID!', __LINE__);}
if(!ctype_digit($_GET['ID'])){err('Preencha o campo ID com dados válidos!', __LINE__);}


///////////////////validação do Codigo//////////////////
// if(!isset($_POST['Codigo'])){err('Falta o campo Codigo!', __LINE__);}
// if(strlen($_POST['Codigo'])>20){err('Codigo deve ter no máximo 20 caracter!', __LINE__);}

// ///////////////////validação do Descrição do Dispositivo//////////////////
// if(!isset($_POST['Descricao'])){err('Falta o campo descrição!', __LINE__);}




require_once(__DIR__.'/protected/database.php');

try{
    //CodigoLabel=:CodigoLabel, DescricaoDispositivo=:DescricaoDispositivo
    $q = $db->prepare('UPDATE Dispositivo SET Nome = :Nome  WHERE ID = :ID');
    $q->bindValue(':Nome', $_POST['Nome']);
    // $q->bindValue(':CodigoLabel', $_POST['Codigo']);
    // $q->bindValue(':DescricaoDispositivo', $_POST['Descricao']);
    $q->bindValue(':ID', $_GET['ID']);
    $q->execute();
    if(!$q->rowCount()){err('Não existe esse dipositivo!', __LINE__);}
    echo '{"status":1, "Message":"Dispositivo atualizado com sucesso!"}';
    exit();

}catch(PDOException $ex){
   
    err('Não pode atualizar o Dipositivo verifique a query!', __LINE__);

}

function err($message = 'error', $debug = 0)
{

    echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
    exit();
}


