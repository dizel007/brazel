<?php
//***************************************************************************  
//  Парсиv сайт закупки у Контура
// *********************************************************************************
require_once "parce_44fz.php";
require_once "parce_223fz.php";

require_once 'vendor/autoload.php';



// echo "<pre>";
use GuzzleHttp\Client;

$client = new Client([
    'headers' => [
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
    ]
]);



$KonturLink = $_GET['KonturLink'];
if ($KonturLink == '') {
	echo "ССЫЛКА НА КОНТУР ПУСТАЯ";
	die();
}
// пытаемся вытащить номер закупки 
	$number_end_position_url = strpos($KonturLink, "?");
	($number_end_position_url>0)?$KonturLink_clear = mb_substr($KonturLink,  0, $number_end_position_url):$KonturLink_clear = $KonturLink;
	$Number_gos_zakupki = str_replace('https://zakupki.kontur.ru/','', $KonturLink_clear);


$tender_link_eis = '';
$priznak_obrabotki_zakupki = 1;

// $Number_gos_zakupki = '32514642133';
/// пробеум пробить закупку по 44 ФЗ
$url_zakupki_gov_44fz  = "https://zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?regNumber=$Number_gos_zakupki";


// Пробуем парсить сайт по 44 ФЗ
	try {
		// Code that may throw an exception
		echo "Ссылка на закупу  ".$url_zakupki_gov_44fz."<br>" ;
		$tender_data = get_tender_data_44_fz($client, $url_zakupki_gov_44fz , $Number_gos_zakupki) ;
		$priznak_zakupki_44_FZ = 1;
		
	} catch (Exception $e) {
		// Handle the exception
		// echo "Error: " . $e->getMessage() . "<br>";
		$priznak_zakupki_44_FZ = 0;
	} finally {
		// Optional: Code that will always run, regardless of an exception
		 if ($priznak_zakupki_44_FZ == 1) {
			$tender_link_eis = $url_zakupki_gov_44fz;
		 } else {
			echo "Не удалось получить данные по 44 ФЗ<br>";
		 } 
	}

	// Пробуем ЕЩЕ РАЗ С ДРУГОЙ ССЫЛКОЙ парсить сайт по 44 ФЗ
	if ($priznak_zakupki_44_FZ  == 0) {
$url_zakupki_gov_44fz  = "https://zakupki.gov.ru/epz/order/notice/ok20/view/common-info.html?regNumber=$Number_gos_zakupki";

	try {
		// Code that may throw an exception
		echo "Ссылка на закупу  ".$url_zakupki_gov_44fz."<br>" ;
		$tender_data = get_tender_data_44_fz($client, $url_zakupki_gov_44fz , $Number_gos_zakupki) ;
		$priznak_zakupki_44_FZ = 1;
		
	} catch (Exception $e) {
		// Handle the exception
		// echo "Error: " . $e->getMessage() . "<br>";
		$priznak_zakupki_44_FZ = 0;
	} finally {
		// Optional: Code that will always run, regardless of an exception
		 if ($priznak_zakupki_44_FZ == 1) {
			$tender_link_eis = $url_zakupki_gov_44fz;
		 } else {
			echo "Не удалось получить данные по 44 ФЗ<br>";
		 } 
	}

}

 /// если закупке не прошла обработку по 44 ФЗ, пробуем прогнать по 223 ФЗ
if ($priznak_zakupki_44_FZ  == 0) {
$url_zakupki_gov_223fz = "https://zakupki.gov.ru/epz/order/extendedsearch/results.html?searchString=".$Number_gos_zakupki;
$priznak_link_223 = 0;
 // получаем ссылки на закупку ()
echo "Идем проверять 223 ФЗ, номер закупки =".$Number_gos_zakupki."<br>" ;
// получаем ссылку на закупку 223 ФЗ
try {
$link_for_223_zakupki = get_temp_link_223_fz($client, $url_zakupki_gov_223fz , $Number_gos_zakupki);
$priznak_link_223 = 777;
} catch(Exception $e) {
	echo "Error: " . $e->getMessage() . "<br>";
	echo "не удалось получить ссылку на закупку<br>";
	
}

// получаем данные по  закупке, если добыли ссылку на закупку 223 ФЗ
if  ($priznak_link_223  == 777) {
try {
	$tender_data = get_tender_data_223_fz($client, $link_for_223_zakupki , $Number_gos_zakupki);
	$tender_link_eis = $link_for_223_zakupki;
	} catch(Exception $e) {
		echo "Error: " . $e->getMessage() . "<br>";
		echo "Не удалось получить данные по 223 ФЗ<br>";
		$priznak_obrabotki_zakupki = 0;
	}

}


//  echo "<pre>";
// print_r($tender_data);

// echo "ПРОПАЛИ <br>" ;
// // die('ddddddddddddddddd');


 }



$tender_data['tender_link_eis']=$tender_link_eis;
$tender_data['KonturLink'] = $KonturLink_clear;




// die();
// if (urlExists($url_zakupki_gov_44fz)) {
//     echo "Ссылка работает!";
// } else {
// 	$url_zakupki_gov_223fz = "https://zakupki.gov.ru/epz/order/extendedsearch/results.html?searchString=32413364448";
//     echo "Ссылка не найдена!";
// }



// $url_zakupki_gov_223fz = "https://zakupki.gov.ru/epz/order/extendedsearch/results.html?searchString=32413364448";




