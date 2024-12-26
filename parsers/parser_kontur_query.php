<?php
// 
//  Парсиv сайт закупки у Контура
// 
include_once __DIR__ . '/phpQuery/phpQuery.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
// $KonturLink ='https://zakupki.kontur.ru/0126300038923000019?h=%D0%BE%D0%B1%D0%BE%D1%80%D1%83%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D1%8F&h=%D0%BC%D0%BE%D0%B5%D1%87%D0%BD%D0%B0%D1%8F&searchHash=85d18f397540d3ebac45ffa4ce51ea2e4349c437';

// $KonturLink ='https://zakupki.kontur.ru/3211506_4?searchHash=85d18f397540d3ebac45ffa4ce51ea2e4349c437';


// $KonturLink ='https://zakupki.kontur.ru/32312055224?h=%D0%BC%D0%B5%D0%B1%D0%B5%D0%BB%D1%8C&h=%D0%BD%D0%B5%D1%80%D0%B6%D0%B0%D0%B2%D0%B5%D1%8E%D1%89%D0%B5%D0%B9&h=%D1%81%D1%82%D0%B0%D0%BB%D0%B8&h=%D0%B3%D0%B0%D1%81%D1%82%D1%80%D0%BE%D0%B5%D0%BC%D0%BA%D0%BE%D1%81%D1%82%D1%8C&searchHash=85d18f397540d3ebac45ffa4ce51ea2e4349c437';


$html = phpQuery::newDocument(file_get_contents($KonturLink));

$tender_data= array();
// $pos=0;
$pos = strrpos($KonturLink, '?');
($pos !='')?$KonturLink = mb_strimwidth($KonturLink, 0, $pos ):$pos=0;
$tender_data['KonturLink']=$KonturLink;


// парсим номер заукпки
$pos = strrpos($KonturLink, '/');
$tender_number = mb_strimwidth($KonturLink, $pos, $pos );
$tender_number = str_replace('/','',$tender_number);
// $pos = strrpos($tender_number, '?');
// $tender_number = mb_strimwidth($tender_number, 0, $pos );
$tender_data['tender_number']=$tender_number;

// парсим описание заукупки
$tender_descr = $html->find('h1');
$tender_descr = pq($tender_descr)->text();
$tender_data['tender_descr']=$tender_descr;

// парсим НМЦК заукупки
$tender_begin_price = $html->find('.tender-named-values_value');
$tender_begin_price = pq($tender_begin_price)->text();
$tender_begin_price = str_replace(',', '.', $tender_begin_price);
$tender_begin_price = preg_replace('/\s+/', '', $tender_begin_price); // удалить все пробелы (включая табуляции и концы строк)
$pos = strpos ($tender_begin_price, '₽');
$tender_begin_price = mb_strimwidth($tender_begin_price, 0, $pos );
// unset($data);
$tender_data['tender_begin_price']=$tender_begin_price;



// парсим ссылку на ЕИС заукупки
$tender_link_eis = "https://zakupki.gov.ru/epz/order/notice/ok20/view/common-info.html?regNumber=".$tender_data['tender_number'];
 $tender_data['tender_link_eis']=$tender_link_eis;



// Парсим адресс доставки

$tender_adress = $html->find('.purchase-page__block');
$tender_adress = $tender_adress->find('.tender-named-values_row');
$data = array();
foreach ($tender_adress as $row) {
	$data = pq($row)->text();
	if (strstr($data, 'Место поставки'))  {
		$tender_adress = $data;
		break;
	}
}


$tender_adress = str_replace(array("\n","\r"), '', $tender_adress);
$tender_adress = str_replace('Место поставки','',$tender_adress);
$tender_adress = str_replace('Российская Федерация,','',$tender_adress);
$tender_adress = str_replace('РФ,','',$tender_adress);
$tender_adress = str_replace('Россия,','',$tender_adress);
// $tender_adress = str_replace(', ',', ',$tender_adress);

$tender_adress = trim($tender_adress);
$tender_data['tender_adress']=$tender_adress;

// echo "<pre>";
// print_r($tender_data);
// echo "<pre>";