<?php

/******************************************************************************
Парсим JSON file и созжаем из него данные для анализа и формирования КП
********************************************************************************/
// формируем массив с данными
$arr_data_kp = json_decode(file_get_contents($json_kp_file), true);


// echo "<pre>";
// print_r($arr_data_kp);
// данные для шапки
$kp_name =  $arr_data_kp['dop_info']['KpNumber'].' от '.$arr_data_kp['dop_info']['KpDate'];
$Zakazchik = $arr_data_kp['dop_info']['NameCustomer'];
$Phone = $arr_data_kp['dop_info']['Telephone'];
$Email = $arr_data_kp['dop_info']['Email'];
$ZakupName = $arr_data_kp['dop_info']['ZakupName'];

 // массив товаров 
  foreach ($arr_data_kp['products'] as $produs) {
    $prods[] = 
      array(
        'name'  => $produs['name'],
        'kol' => $produs['kol'],
        'ed_izm' => $produs['ed_izm'],
        'price' => $produs['price'],
        'sum_price' => $produs['kol'] * $produs['price']
      );
  
    }
    $sum_kp_array['prods'] = $prods;

    // цепляем доставку  
$price_dost = $arr_data_kp['dop_info']['DostCost']; // стоимость доставки
$uslovia_oplati = $arr_data_kp['dop_info']['uslovia_oplati'];
$srok_izgotovl = $arr_data_kp['dop_info']['srok_izgotovl'];
$adress_dostavki = $arr_data_kp['dop_info']['Adress'];
