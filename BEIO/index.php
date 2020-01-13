<?php
require_once("config.php");
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Beio\Model\User;
use \Beio\Model\Endereco;
use \Beio\Model\Empresa;
use \Beio\Controller\Dispositivos;
use \Beio\DB\Sql as DB;


$app = new \Slim\Slim();

$app->get('/', function () {
    
    if( User::log() ){
        header("Location: /painel" );
        exit;
    } else {
        include("view/Login/public/index.html");
    }
    
});

$app->get('/painel', function () {
    User::verifyLogin();
    include("view/Painel/public/index.html");
    echo "<input type=hidden id = 'id' name = 'id'  value='".$_SESSION['User']['ID']." ' </input> ";
});

$app->post('/login', function(){
  
    $teste = User::login($_POST['login'], $_POST['password']);
   
    header("Location: /painel" );
    exit;

});

$app->get('/logout', function(){
    
    User::logout();
    header("Location: /" );
    exit;


});

$app->get('/registrar', function(){

    include("view/Registrar/public/index.html"); 

});

$app->post('/registrar', function(){

    $dados = array(
        'nome'=> $_POST['nome'], 
        'email'=> $_POST['email'],
        'password'=> $_POST['password'],
        'Imagem' => $_FILES['picture']
     
    );
    
    $user = new User();
    $user->registrar($dados);
    
});

$app->get('/user', function(){

      $result = User::info($_GET['ID']);

     echo json_encode($result);
    
});

$app->get('/todos', function(){

    $result = User::todos();
    echo '{"status":1, "data":'.json_encode($result).'}';
   
  
});


$app->post('/dispositivos', function(){
    $data = array(
      'ID'=>  $_POST['ID'], 
      'Campo' => $_POST['Campo'],
      'Pesquisa'=> $_POST['Busca'] 
    );
    $disp = New Dispositivos();
    $resp = $disp->buscarDispositivo($data);
    echo json_encode($resp);
});

$app->post('/adicionarusuario', function(){
    $user = New User();
    $usuario = array(
        'empresa'=> $_POST['empresa'], 
        'nome'=> $_POST['nome'],
        'email'=> $_POST['email'],
        'password' => $_POST['senha'],
        'permissao' => $_POST['permissao']
    );
    $id = $user->inserir($usuario);

    
    $endereco = array(
        'id' =>  $id,
        'cep'=> $_POST['cep'], 
        'cidade'=> $_POST['cidade'],
        'estado'=> $_POST['estado'],
        'pais' => $_POST['pais'],
        'logradouro' => $_POST['logradouro'],
        'bairro' => $_POST['bairro'],
        'numero' => $_POST['numero'],
        'descricao' => $_POST['descricao']
    );

    $enderecos = New Endereco();
    $enderecos->inserir($endereco);
    
    header("Location: /" );
    exit;
});


$app->post('/familia', function(){
    // $empresas = New Empresa();
    // $results = $empresas->bucarEmpresas($_POST['EmpresaIDFK']);
      
     echo json_encode("Nice Dude !!");
});

$app->post('/dispositivo', function(){
    $dispositivo = New Dispositivos();
    $results = $empresas->bucarEmpresas($_POST['EmpresaIDFK']);
      
     echo json_encode($results);
});


$app->get('/usuarios', function(){
     $user = New User();
     $results = $user->buscaUsuarios($_GET['id']);
      
     echo json_encode($results);
});


$app->run();




