<?php

function debug($tableau)
{
    echo '<pre style="height:100px;overflow-y: scroll;font-size:.5rem;padding: .6rem; font-family: Consolas, Monospace;background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}


function validText($er, $data, $key, $min, $max)
{
    if(!empty($data)) {
        if(mb_strlen($data) < $min) {
            $er[$key] = 'min '.$min.' caractères';
        } elseif(mb_strlen($data) >= $max) {
            $er[$key] = 'max '.$max.' caractères';
        }
    } else{
        $er[$key] = 'Veuillez renseigner ce champ';
    }
    return $er;
}


function validEmail($err,$data,$key){
    if(!empty($data)) {
        // if email is valid
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            $err[$key] = 'Veuillez renseigner un email valide';
        }
    } else {
        $err[$key] = 'Veuillez renseigner un email';
    }

    return $err;
}

function cleanXss($key)
{
    return trim(strip_tags($_POST[$key]));
}
