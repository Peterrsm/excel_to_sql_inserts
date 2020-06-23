<?php
    //Remove WARNING
    error_reporting(E_ERROR | E_PARSE);
    //Inclusão da biblioteca PHPExcel
    include './Service/Classes/PHPExcel/IOFactory.php';

    //Método para verificar conexão com banco de dados
    function verificaConexao(){
      $banco = 'mysql';
      $usuario = 'root';
      $senha = '';
      $hostname = 'localhost';
      $conn = mysqli_connect($hostname,$usuario,$senha);
      mysqli_select_db($conn, $banco) or die('Não foi possível conectar ao banco MySQL');

      if (!$conn) {   
         mysql_close();
         return false;
      }
      else {
         mysql_close(); 
         return true;
      }     
   }


    //Método que remove o último caractere do texto passado
    function acertaVirgula($texto){
        $texto = trim($texto);
        $limite = strlen($texto);
        $limite--;

        return substr($texto, 0, $limite);
    }

    //Método retorna nome para o arquivo txt
    function geraNome($nomearquivo){
        $posicao = strripos($nomearquivo, '.');
        return substr($nomearquivo, 0, $posicao);
    }

    //Método que gera o arquivo
    function geraArquivo($sql, $nomearquivo){
        $idarquivo = geraNome($nomearquivo); 

        //gera arquivo txt
        $agora = date('Y-m-d_H-i-s');
        $arquivo = fopen('./txt/' . $idarquivo . '_inserts.txt','w+');

        //verifica se foi criado
        if ($arquivo == false) die('Não foi possível criar o arquivo.');

        //escreve no arquivo
        fwrite($arquivo, $sql);

        //Fecha o arquivo após escrever nele
        fclose($arquivo);
    }

    function geraInserts($tabela){
        $path = "./Arquivos/";
        $diretorio = dir($path);
        
        while($arquivo = $diretorio -> read()){
           if(strval($arquivo) != '..' && strval($arquivo) != '.'){
              $inputFileName='./Arquivos/' . $arquivo;
  
              //Carrega arquivo excel
              try{
                 $objPHPExcel=PHPExcel_IOFactory::load($inputFileName);
              }
              catch(Exception $e) {
                 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
              }
  
              try {
                 $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                 $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                 $objPHPExcel = $objReader->load($inputFileName);
                 $objWorksheet = $objPHPExcel->getActiveSheet();
                 $maxRow = $objWorksheet->getHighestRow();
                 $maxColumn = $objWorksheet->getHighestColumn();
                 $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($maxColumn); 
              } 
              catch(Exception $e) {
                 die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
              }
              
              $atributos = array();
              $valores = array();
              $sql = "";
              
              //Monta array com valores da primeira linha do arquivo xls
              for($j = 0; $j <= $highestColumnIndex; $j++){
                 $valor = $objWorksheet->getCellByColumnAndRow($j, 1)->getValue();
                 if(!is_null($valor)){
                    $atributos[$j] = $valor;
                 }
              }
              
              /*
              *Inicia a instrução sql final com os atributos 
              *identificados anteriormente
              */
              $sql .= "INSERT INTO " . $tabela;
  
              $sql .= "(";
              for($j = 0; $j <= $highestColumnIndex; $j++){
                 $valor = $objWorksheet->getCellByColumnAndRow($j, 1)->getValue();
                 
                 if(!is_null($valor)){
                    $sql .= $valor . ", ";
                    $sql = trim($sql);
                 }
              }
  
              $sql = acertaVirgula($sql);
              $sql .= ")VALUES";
              
  
              /*
              * Enquanto lê o documento excel, monta o comando sql
              * com os valores para cada atributo
              */
              for($row= 2; $row <= $maxRow; $row++){
                 $sql .= "(";
                 for($col = 0; $col < $highestColumnIndex; $col++){
                    $valor = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $sql .= "'" . $valor . "',";
                    $sql = trim($sql);
                 }   
                 $sql = acertaVirgula($sql);
                 $sql .= "),";
                 $sql = trim($sql);
              }
              $sql = acertaVirgula($sql);
  
              //Gera arquivo
              geraArquivo($sql, $arquivo);
           }
        }
  
        $diretorio -> close();
     }

 ?>