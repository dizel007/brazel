<?php
// https://habr.com/en/post/137664/
// инструкция по вставки через PDO

// require_once ("../connect_db.php");
// require_once ("../new_kp_info/test_file_name.php"); // если имя файла занято, то добавится индекс
require_once "new_kp_info/analiz_siroy_kp.php";
require_once "update_data_in_kp/parce_excel_for_update_kp.php";

/*
GET данные
*/
$id = $_GET['id']; // 

if (isset($_GET['add_str_plus'])) {
  $add_str = $_GET['add_str_plus']; // количество добавленных строк в новом КП
} else {
  $add_str = 0; // количество добавленных строк в новом КП
}
// Формируем признак, откуда мы пришли, если после подцепки ИНН то признак  = новому ИНН инчае '' ж
if (isset($_GET['InnCustomer'])) {
  $priz_update_inn = $_GET['InnCustomer'];
$arrNameCustomer = GetCompanyByInn($pdo,$priz_update_inn);
$NameCustomer = $arrNameCustomer[0]['name'];
} else {
  $priz_update_inn = '';
}



//  Вычиитаваем все данные о КП из реестра 
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` WHERE `id` = ?");
$stmt->execute([$id]);
$arr_kp_by_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

$InnCustomer = $arr_kp_by_id[0]['InnCustomer'];
$type_kp = $arr_kp_by_id[0]['type_kp'];
$LinkKp = $arr_kp_by_id[0]['LinkKp'];

/// Преобразуем ссылку с эксель файла на ссылку json файла
$t_2 = str_replace( 'EXCEL/' , 'JSON_KP/',  $LinkKp);
$t_2 = substr($t_2, 0, -4)."json";;
$file_name_="".$t_2; // получаем путь и имя файла


// $sum_kp_array= parce_kp($file_name_); // получили все данные из КП (шапку, продуцию, доп инфу)
$sum_kp_array= parce_json_kp_file($file_name_); // получили все данные из КП (шапку, продуцию, доп инфу)

$type_product = $arr_kp_by_id[0]['type_product'];
$pdf_visota_prod_stroki = $arr_kp_by_id[0]['visota_str_pdf_doc'];
$pdf_visota_prod_stroki < 2?$pdf_visota_prod_stroki=5:$pdf_visota_prod_stroki=$arr_kp_by_id[0]['visota_str_pdf_doc'];

// echo "<pre>";
// print_r($arr_kp_by_id);
// echo "<pre>";
// die();

/*
 * Увеличиваем количество строк в массиве в товарами, если нужно
 */
for($i=0;$i<$add_str;$i++) {
  $sum_kp_array['prods'][] = 
  array(
    'name'  => '',
    'kol' => '',
    'ed_izm' => '',
    'price' => '',
    
  );

}

// echo "<pre>";
// print_r($sum_kp_array);
// echo "<pre>";
$smarty->assign('pdf_visota_prod_stroki' , $pdf_visota_prod_stroki); 
$smarty->assign('InnCustomer' , $InnCustomer);
$smarty->assign('priz_update_inn' , $priz_update_inn);
$smarty->assign('NameCustomer' , @$NameCustomer);
$smarty->assign('id' , $id);
$smarty->assign('type_kp' , $type_kp);
$smarty->assign('type_product' , $type_product);

dispay_update_kp($smarty, $sum_kp_array,$add_str, $id);  // выводим наше КП

// die('********************* Вывели изображение на экран **********************');





