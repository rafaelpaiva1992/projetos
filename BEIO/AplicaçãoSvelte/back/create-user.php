<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação do Nome//////////////////
if(!isset($_POST['Nome'])){err('Falta o campo name!', __LINE__);}
if($_POST['Nome'] === ""){err('Preencha o campo nome!', __LINE__);}
if(strlen($_POST['Nome'])<3){err('Usuário com no minimo 3 letras!', __LINE__);}

///////////////////validação da Foto//////////////////

//if(($_FILES['Imagem'])=== ""){err('teste!', __LINE__);} 

// Saber o tipo da imagem se é png, jpeg etc....
$extension = pathinfo($_FILES['Imagem']['name'], PATHINFO_EXTENSION);  
//var_dump($extension);

//Validar a extensions
$allowedExtensions = ['png', 'jpg', 'gif','jpeg'];

if(!in_array($extension, $allowedExtensions)){

    err('A imagem deve ser uma dessa extensão '.implode(',', $allowedExtensions));
}

//Validar o tamanho da imagem SIZE
if(($_FILES['Imagem']['size']) < 300){err('Imagem muito pequena!', __LINE__);}
if(($_FILES['Imagem']['size']) > 20000){err('Imagem muito grande!', __LINE__);}


//unique name for the image

$uniquePictureName = bin2hex(random_bytes(16)); // 32 long char+dig
$uniquePictureName .= '.'.$extension;

//salvar no banco
require_once(__DIR__.'/protected/database.php');

try{

    $q = $db->prepare('INSERT INTO Usuario VALUES (NULL,NULL,NULL, :Nome, NULL,NULL,NULL, :Imagem, NULL, NULL)');
    $q->bindValue(':Nome', $_POST['Nome']);
    $q->bindValue(':Imagem', $uniquePictureName);
    $q->execute();
    $userId = $db->lastInsertId();

    //mover a Imagem da pasta TMP para pasta pictures

    $destinationFolder = __DIR__.'/pictures/';
    $finalPath = $destinationFolder.$uniquePictureName;
    move_uploaded_file($_FILES['Imagem']['tmp_name'], $finalPath);

    echo '{"status":1, "Message":"Usuário criado com sucesso!", "id":"'.$userId.'"}';

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