<?php
    //Remove WARNING
    //error_reporting(E_ERROR | E_PARSE);
    
    $data = date("Y-m-d");
    
    //$data = date('Y-m-d', '2020-06-11');

    echo 'Hoje: ' . $data;

    echo '<br><br>';

    $novadata = date_sub(new DateTime($data),date_interval_create_from_date_string("01 days"));

    echo $novadata->format('Y-m-d');

?>