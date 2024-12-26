<?php
require_once '../PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require_once '../connect_db.php';



$xls = PHPExcel_IOFactory::load("../".$_GET['LinkKp']);
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$i=19;
$stop =0;

$kp_name = $sheet->getCellByColumnAndRow(6, 6)->getValue();
$Zakazchik = $sheet->getCellByColumnAndRow(9, 8)->getValue();
$Phone = $sheet->getCellByColumnAndRow(9, 10)->getValue();
$Email = $sheet->getCellByColumnAndRow(9, 11)->getValue();
$ZakupName = $sheet->getCellByColumnAndRow(2, 16)->getValue();


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


while ($stop <> 1 ) {
$name = $sheet->getCellByColumnAndRow(3, $i)->getValue();

if ($name == '') {
	$stop =1;
	break;
}

$ed_izm = $sheet->getCellByColumnAndRow(8, $i)->getValue();
$kolvo = $sheet->getCellByColumnAndRow(10, $i)->getValue();
$kolvo = str_replace(' ','',$kolvo);
$kolvo = str_replace(',','.',$kolvo);
$price = $sheet->getCellByColumnAndRow(11, $i)->getValue();
$sum_price = $sheet->getCellByColumnAndRow(11, $i)->getValue();
$price = str_replace(' ','',$price);
$price = str_replace(',','.',$price);

$prods[] = 
	array(
		'name'  => $name,
		'kol' => $kolvo,
		'ed_izm' => $ed_izm,
		'price' => $price,
    'sum_price' => $sum_price
	);

$i++;
}

// цепляем доставку  
$idost= $i+8;
$price_dost = $sheet->getCellByColumnAndRow(12, $idost)->getValue();
$price_dost = str_replace(' ','',$price_dost);
$price_dost = str_replace(',','.',$price_dost);

$p=1;
$temp_sum =0;
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


  $i_1 = $i+6;
  $temp =$sheet->getCellByColumnAndRow(5, $i_1)->getValue();
  echo "<b>Условия оплаты : ".$temp."</b><br>";
  $i_1 = $i+7;
  $temp =$sheet->getCellByColumnAndRow(5, $i_1)->getValue();
  echo "<b>Срок изготовления : ".$temp."</b><br>";
  $i_1 = $i+8;
  $temp =$sheet->getCellByColumnAndRow(5, $i_1)->getValue();
  echo "<b>".$temp." : ".number_format($price_dost,2)."</b><br>"; 