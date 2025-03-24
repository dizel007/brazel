<?php


/******************************************************************************************************
 * ПАРСИМ САЙТ закупки гов по 44 ФЗ
 *******************************************************************************************************/
function get_tender_data_44_fz($client, $url_zakupki_gov_44fz , $Number_gos_zakupki) {
$response = $client->get($url_zakupki_gov_44fz);
$html = $response->getBody()->getContents();

$dom = new DOMDocument();
libxml_use_internal_errors(true); // Отключаем предупреждения
$dom->loadHTML($html);
libxml_clear_errors();

$finder = new DOMXPath($dom);
$classname = "blockInfo__section section";
$nodes = $finder->query("//section[contains(@class, '$classname')]");

foreach ($nodes as $node) {
    if (strpos($node->nodeValue, 'есто поставки товара, выполнения раб')) {
        $adress = $node->nodeValue;
        $adress =  str_replace('Место поставки товара, выполнения работы или оказания услуги' , '', $adress);
        $adress =  str_replace('Российская Федерация, ' , '', $adress);
        $adress = trim($adress);

    };

    if (strpos($node->nodeValue, 'Наименование объекта закупки')) {
        $zakupka_name = $node->nodeValue;
        $zakupka_name =  str_replace('Наименование объекта закупки' , '', $zakupka_name);
        $zakupka_name = trim($zakupka_name);
    };

    if (strpos($node->nodeValue, 'Начальная (максимальная) цена контракта')) {
        $max_contract_price = $node->nodeValue;
        $max_contract_price =  str_replace('Начальная (максимальная) цена контракта' , '', $max_contract_price);
        $max_contract_price = intval(preg_replace('/[^0-9,]+/', '', $max_contract_price), 10);
   

        
    };


}

$tender_data['tender_number'] = $Number_gos_zakupki;
$tender_data['tender_descr']=$zakupka_name;
$tender_data['tender_begin_price']=$max_contract_price;
$tender_data['tender_adress']=$adress;


// print_r($tender_data);

return $tender_data;
}