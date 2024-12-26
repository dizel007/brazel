<?php
require_once '../connect_db.php';
require_once '../pdo_connect_db/select_functions.php';

require_once 'function_get_file_link_by_id.php';

// достааем адрес файла по этому КП  по этому КП
$json_kp_file = get_filelink_kp_by_id ($pdo, $_GET['id']);


// получаем данные из JSON файла
require_once("../functions/parce_json_kp_file.php");

echo "<b>Заказчик :".$Zakazchik;"</b><br>";
echo "<br><br>";
echo "<b>Телефон :".$Phone;"</b><br>";
echo "<br>";
echo "<b>Эл. почта :".$Email;"</b><br>";
echo "<br>";
echo "<br>";

// $ZakupName = substr($ZakupName, 132, -64);
echo "<b>".$ZakupName;"</b><br>";
echo "<br>";
echo "<br><b>".$kp_name;"</b><br>";

echo "<br><br>";

$p = 1;
$temp_sum = 0;



echo '<table border="1" cellpadding="3" style="border-collapse: collapse">';
echo '<tr>';
echo '<td>' . "пп" . '</td>';
echo '<td>' . "Наименование" . '</td>';
echo '<td>' . "ед.изм" . '</td>';
echo '<td>' . "Кол-во" . '</td>';
echo '<td> Цена  </td>';
echo '<td>' . "Стоимость" . '</td>';
echo '</tr>';

foreach ($prods as $value) {
echo '<tr>';
echo '<td>' . $p . '</td>';
echo '<td>' . $value['name'] . '</td>';
echo '<td>' . $value['ed_izm'] . '</td>';
echo '<td>' . $value['kol'] . '</td>';
echo '<td>' . $value['price'] . '</td>';
echo '<td>' . number_format($value['price'] * $value['kol'],2) . '</td>';
			
echo '</tr>';
$temp_sum += $value['price'] * $value['kol'];
$p++;
}

echo '<tr>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td> ИТОГО :</td>';
echo '<td>' . number_format($temp_sum,2) . '</td>';
echo '</tr>';

$temp_nds= $temp_sum - $temp_sum/1.2;
echo '<tr>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td>' . "" . '</td>';
echo '<td> НДС 20%: </td>';
echo '<td>' .number_format($temp_nds,2). '</td>';
echo '</tr>';


echo '</table>';
echo "<br>";
  // echo "<pre>";
  // print_r ($prods);
  // echo "<pre>";
  // die('dxfghdfgh');


  echo "<b>Условия оплаты : ".$uslovia_oplati."</b><br>";
  echo "<b>Срок изготовления : ".$srok_izgotovl."</b><br>";
  echo "<b>".$adress_dostavki." : ".number_format($price_dost,2)."</b><br>"; 