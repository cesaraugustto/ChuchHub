<?php
/**
 * Undocumented function
 *
 * @return \PDO
 */
function getConnection(){

$dsn = "mysql:host=localhost;dbname=betel;charset=utf8";
$user = "root";
$pass = "";
    
    try{
    $pdo = new PDO($dsn, $user, $pass);
    return $pdo;
    echo 'conectou';
    }
    catch (PDOException $ex){
        echo 'Erro ao conectar: '. $ex->getMessage(); //Aqui é para mostrar onde foi o erro. 
    }
}
?>