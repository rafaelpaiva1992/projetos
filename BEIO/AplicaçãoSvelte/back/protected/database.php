<?php
try {

    $dbUserName = 'root';
    $dbPassword = 'OLCmmm77196';
    $dbConnection = 'mysql:host=200.150.202.47; dbname=Cerebro;';
    $options = [

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // try-catch
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // JSON
    ];

    $db = new PDO( $dbConnection, $dbUserName, $dbPassword, $options);

} catch (PDOException $ex) {
    echo '{
        "status":0,
        "message":"Não pode se conectar ao Banco",
        "debug":' . __LINE__ . '
       }';

    exit();
}
