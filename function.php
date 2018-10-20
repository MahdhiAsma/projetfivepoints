<?php
/**
 * Created by PhpStorm.
 * User: Imen
 * Date: 18/08/2018
 * Time: 23:41
 */
function debug($var)
{
    echo '<pre>' . print_r($var, true) . '</pre>';

}

function str_random($length){
    $alphabet="0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet,$length)), 0,$length);

}

