<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação do Nome//////////////////
if(!isset($_POST['Nome'])){err('Falta o campo name!', __LINE__);}
if($_POST['Nome'] === ""){err('Preencha o campo nome!', __LINE__);}
if(strlen($_POST['Nome'])<3){err('Usuário com no minimo 3 letras!', __LINE__);}

///////////////////validação o ID//////////////////

if(!isset($_GET['ID'])){err('Falta o campo ID!', __LINE__);}
if(!ctype_digit($_GET['ID'])){err('Preencha o campo ID com dados válidos!', __LINE__);}


require_once(__DIR__.'/protected/database.php');

try{

    $q = $db->prepare('UPDATE Usuario SET Nome = :Nome WHERE ID = :ID');
    $q->bindValue(':Nome', $_POST['Nome']);
    $q->bindValue(':ID', $_GET['ID']);
    $q->execute();
    if(!$q->rowCount()){err('Não pode atualizar o usuário!', __LINE__);}
    echo '{"status":1, "Message":"Nome do usuário atualizado com sucesso!"}';
    exit();

}catch(PDOException $ex){
   
    err('Não pode atualizar o usuário!', __LINE__);

}

function err($message = 'error', $debug = 0)
{

    echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
    exit();
}


