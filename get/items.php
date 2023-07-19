<?php
    $array = array();
    $array['message'] = 1;
    $array['response'] = array();
    $items = ["RADIOFRECUENCIA", "Láser spectra","Infini", "radiofrecuencia intradérmic"];
    $prices = ["5000", "8000","5250", "10500"];
    for ($i=0; $i < 4; $i++) { 
        $array['response'][$i]['rowID']=$i;
        $array['response'][$i]['items_category']= $items[$i];
        $array['response'][$i]['items_price']= $prices[$i];
    }
    echo json_encode($array);
?>



