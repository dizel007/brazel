<?php

function parce_excel_kp($LinkKp){
    $xls = PHPExcel_IOFactory::load($LinkKp );
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $i=19;
    $stop = 0;
    $priz_name_kp=0;

while ($stop <> 1 ) {
$stop = 0;

$name = $sheet->getCellByColumnAndRow(3, $i)->getValue();

if ($name == '') {
  $stop =1;
  break;
}
// $name = "*".$name; //  костыль из-за кодирвки, почему то в рус языке первый символ игнориться в поиске строка в строке
$ed_izm = $sheet->getCellByColumnAndRow(8, $i)->getValue();
$kolvo = $sheet->getCellByColumnAndRow(10, $i)->getValue();
$kolvo = str_replace(' ','',$kolvo);
$kolvo = str_replace(',','.',$kolvo);
$price_temp = $sheet->getCellByColumnAndRow(11, $i)->getValue();
$price = intval(preg_replace('/[^0-9]+/', '', $price_temp), 10)/100; // убираем все пробелы 
// делаем проверку на вхождение нащих слов в наименование товара


$arr_tovari[$i-19]['name'] = $name;
$arr_tovari[$i-19]['ed_izm'] = $ed_izm;
$arr_tovari[$i-19]['kol'] = $kolvo;
$arr_tovari[$i-19]['price'] = $price;
$i++;
}

return $arr_tovari;
}



function parce_json_kp($link_json_file) {
  $products = json_decode( file_get_contents($link_json_file), true); // берем на Json файл с данными КП

echo "<pre>";

  print_r( $products);
  return $products['products'];
 }


 function parce_json_kp_return_name_object($link_json_file) {
  $all_info  = json_decode( file_get_contents($link_json_file), true); // берем на Json файл с данными КП
  $name_object  = str_replace('Предлагаем рассмотреть приобретение следующих товаров, для закупки', 'Закупка', $all_info['dop_info']['ZakupName']);
  echo "<br> ИЗ ФУНКЦИИ НАИМЕНОВАНИЕ ЗАКУПКИ : $name_object<br>";
  return   $name_object;
 }
