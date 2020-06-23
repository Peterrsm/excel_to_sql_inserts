<?php
    //Remove WARNING
    error_reporting(E_ERROR | E_PARSE);

?>

<h1>Gerar inserts</h1>

<br>

<div class="row">
    <div>
        <p><?= $nomearquivo ?></p>
    </div>
    <div class="col-6">
        <form method="POST" action="gateway.php">
            <div class="form-group">
                <label for="arquivoxls">Nome da tabela</label>
                <input type="text" id="tabela" name="tabela" required>
            </div>

            <br/>

            <button type="submit" class="btn">Gerar TXT</button>
        </form>
    </div>
</div>