<?php
require_once 'access.php';
require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;


$name_sdelka = "№777 от  77777 DJLJGHJDJL)";
echo "$name_sdelka ********************************************************************** СДЕЛКУ<br>";
$link_to_change_kp = 'https://brazel.ru/?transition=30&id=777';
$link_to_see_pdf = 'https://brazel.ru/';
$price_sdelka = 77777;
echo $pipeline_id = 7242730;
// формируем массив для созждания сделки
$data_sdelka = Make_simple_sdelka ($name_sdelka, $link_to_change_kp, $link_to_see_pdf, $price_sdelka, $pipeline_id); 


$res = post_query_in_amo($access_token, $subdomain , '/api/v4/leads' , $data_sdelka);



echo "<pre>";
print_r($res);

