<?php
header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

if(!isset($_GET['ID'])){err('Falta o campo ID!', __LINE__);}
if(!ctype_digit($_GET['ID'])){err('Preencha o campo ID com dados válidos!', __LINE__);}

require_once(__DIR__.'/protected/database.php');

try{

    $q = $db->prepare('DELETE FROM Usuario WHERE ID = :ID');
    $q->bindvalue(':ID', $_GET['ID']); //Evitat o SQL INJECTION
    $q->execute();
    if(!$q->rowCount()){err('Usuário não existe!', __LINE__);}
    echo '{"status":1, "message":"Usuário deletado!"}';
    exit();

}catch(PDOException $ex){

    err('error ao executar a query', __LINE__);

}

function err($message = 'error', $debug = 0)
{

    echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
    exit();
}