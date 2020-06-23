<?php

    //Remove WARNING
    //error_reporting(E_ERROR | E_PARSE);

    //Verifica conexão com banco de dados
    $banco = 'pessoas';
    $usuario = 'root';
    $senha = '';
    $hostname = 'localhost';
    $conn = mysqli_connect($hostname,$usuario,$senha);
    mysqli_select_db($conn, $banco) or die('Não foi possível conectar ao banco MySQL');
    
    if (!$conn) {   
        echo 'Não foi possível conectar ao banco MySQL.'; 
        exit;}
    else {
        echo 'Parabéns!! A conexão ao banco de dados ocorreu normalmente!.';
    }


    mysql_close(); 

?>