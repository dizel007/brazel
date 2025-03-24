<?php

// href="/epz/order/notice/notice223/common-info.html?noticeInfoId=16548140"
/******************************************************************************************************
 * ПАРСИМ САЙТ закупки гов по 223 ФЗ
 *******************************************************************************************************/
function get_temp_link_223_fz($client, $url_zakupki_gov_223fz , $Number_gos_zakupki) {
    $response = $client->get($url_zakupki_gov_223fz);
    $html = $response->getBody()->getContents();
    // print_r($html);
    $dom = new DOMDocument();
    libxml_use_internal_errors(true); // Отключаем предупреждения
  
    $dom->loadHTML($html);
    libxml_clear_errors();
    
    $xpath = new DOMXPath($dom);
    
    // Ищем все <a> теги и получаем атрибут href
    $nodes = $xpath->query("//a");
    
    foreach ($nodes as $node) {
        $test  =  $node->getAttribute("href");
        // echo  $test. "<br>"; 
             if (strpos($test, 'order/notice/notice223/common-info.html?noticeInfoId')) {
                $link_223_zakupka = 'https://zakupki.gov.ru'.$test;
             }
        

    }
   

return $link_223_zakupka;

}


/**
 *  ПАРСИМ 223 закупку
 */


function get_tender_data_223_fz($client, $url_zakupki_gov_223fz , $Number_gos_zakupki) {
$response = $client->get($url_zakupki_gov_223fz);
$html = $response->getBody()->getContents();

// print_r($html);

$dom = new DOMDocument();
libxml_use_internal_errors(true); // Отключаем предупреждения
$dom->loadHTML($html);
libxml_clear_errors();

$finder = new DOMXPath($dom);
$classname = "common-text__value";
$nodes_zakup_name = $finder->query("//div[contains(@class, '$classname')]");
$classname = "price-block__value"; 
$nodes_price_tender = $finder->query("//div[contains(@class, '$classname')]");

// Ищеем наименование закупки
$i=0;
foreach ($nodes_zakup_name as $node) {
    $test = $node->nodeValue;
//   echo  $test. "<br><br>"; 
if ($i == 2) {
    $zakupka_name = $test; 
    $zakupka_name = trim($zakupka_name);
}
 
$i++;
}

// Ищем НМЦК закупки 


foreach ($nodes_price_tender as $node) {
    $max_contract_price = $node->nodeValue;
//   echo  $test. "<br><br>"; 
}
$max_contract_price = intval(preg_replace('/[^0-9,]+/', '', $max_contract_price), 10);

$tender_data['tender_number'] = $Number_gos_zakupki;
$tender_data['tender_descr']=$zakupka_name;
$tender_data['tender_begin_price']=$max_contract_price;
$tender_data['tender_adress'] = '';

// echo  "<pre>"; 
// print_r($tender_data);
// die();
return $tender_data;
}