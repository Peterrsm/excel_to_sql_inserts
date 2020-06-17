<?php

    $data = date("Y-m-d");
    
    echo 'Hoje: ' . $data;

    echo '<br>';

    $aux = date_sub(new DateTime($data),date_interval_create_from_date_string("01 days"));
    ajustaDiaUtil($aux->format('Y-m-d'));

    function ajustaDiaUtil($date){
        $aux = new DateTime($date);;
        if($aux->format('D') == 'Sat' || $aux->format('D') == 'Sun'){
            $aux = date_sub($aux,date_interval_create_from_date_string("01 days"));
        
            ajustaDiaUtil($aux->format('Y-m-d'));
        }
        else{
            echo 'Último dia útil: ' . $aux->format('Y-m-d');
        }

    }

?>