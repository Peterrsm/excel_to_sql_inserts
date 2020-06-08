<?php
    include 'PHPExcel/IOFactory.php';

    $nomearquivo = "";
    
    /*
    if($_POST["arquivoxls"]) {
        $nomearquivo = "Recebido";
     }
     else{
        $nomearquivo = "Não recebido";
     }
     */
  
?>


<h1>Selecionar Planilhas</h1>

<br>

<div class="row">
    <div>
        <p><?= $nomearquivo ?></p>
    </div>
    <div class="col-6">
        <form method="POST" action="comparativo.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="arquivoxls">XLS Planilha 1</label>
                <input type="file" accept=".xls, .xlsx" id="arquivoxls" name="arquivoxls" required>
            </div>

            <button type="submit" class="btn">Selecionar Tab</button>
        </form>
    </div>
</div>