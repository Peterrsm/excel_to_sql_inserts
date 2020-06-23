<?php

    //Inclusão dmétodos úteis
    include 'metodos.php';    

    $tabela = trim($_POST['tabela']);

    /*
    if(verificaConexao)
        geraInserts($tabela);
    */
    
   //Informa conclusão
   echo 'Arquivo(s) gerado(s) com sucesso para a tabela "' . $tabela . '".';
  
?>