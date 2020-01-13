<?php

header('Access-Control-Allow-Origin: *');

header('Content-Type: application/json');

///////////////////validação do ID//////////////////

if(!isset($_GET['ID'])){err('Falta o campo ID!', __LINE__);}
if(!ctype_digit($_GET['ID'])){err('Preencha o campo ID com dados válidos!', __LINE__);}

///////////////////validação da Foto//////////////////

if(!isset($_FILES['Imagem'])){err('Falta o campo Imagem!', __LINE__);} 

// Saber o tipo da imagem se é png, jpeg etc....
$extension = pathinfo($_FILES['Imagem']['name'], PATHINFO_EXTENSION);  //echo $extension;

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

    $q = $db->prepare('UPDATE Usuario SET Imagem = :Imagem WHERE ID = :ID');
    $q->bindValue(':Imagem', $uniquePictureName);
    $q->bindValue(':ID', $_GET['ID']);
    $q->execute();
    if(!$q->rowCount($_FILES['Imagem']['tmp_name'])){err('Usuário não encontrado!', __LINE__);}
    
     //mover a Imagem da pasta TMP para pasta pictures

     $destinationFolder = __DIR__.'/pictures/';
     $finalPath = $destinationFolder.$uniquePictureName;
     move_uploaded_file($_FILES['Imagem']['tmp_name'], $finalPath);
    
    echo '{"status":1, "Message":"Imagem do usuário atualizada com sucesso!"}';
    exit();

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