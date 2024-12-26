<?php
ob_end_clean();
require_once 'connect_db.php';
require_once 'amo_setup.php';
require_once 'access.php';
require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
require_once 'parts/parce_excel_file.php'; // парсер ексель КП

require_once '../../PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$count = 0;
echo "<br>";
echo date('Y-m-d H:i:s');
echo "<br>";
$connect_data['access_token'] = $access_token ;
// echo "<br>";
$connect_data['subdomain'] = $subdomain;
// echo "<br>";




$stmt_all = $pdo->prepare("SELECT id,InnCustomer, NameCustomer FROM reestrkp WHERE id_amo_lead = 0");
// $stmt = $pdo->prepare("SELECT * FROM reestrkp ORDER BY id DESC LIMIT 100");

$stmt_all->execute([]);
$arr_all_deals = $stmt_all->fetchAll(PDO::FETCH_ASSOC);

echo "<pre>";
print_r($arr_all_deals);

foreach ($arr_all_deals as $arr_deal) {

 $id = $arr_deal["id"];

  // Вычитываем все телефоны с таким ID
  $stmt = $pdo->prepare("SELECT id,InnCustomer, NameCustomer FROM reestrkp WHERE id = $id");
  // $stmt = $pdo->prepare("SELECT * FROM reestrkp ORDER BY id DESC LIMIT 100");

  $stmt->execute([]);
  $arr_inn_name = $stmt->fetchAll(PDO::FETCH_ASSOC);

// print_r($data_temp5);
// die();

foreach ($arr_inn_name as $j_id) {
  echo "<br><b>*************************************************************************************************</b><br>";
  set_time_limit(120);
  echo "<br><b>SET_LIMIT_120</b><br>";

  $id = $j_id['id']; // ID КП
  $inn = $j_id['InnCustomer']; // ИНН из КП
  
    if ($inn !=0) {  /// проверяем если ли ИНН в сделке
        $inn_our_company = find_company_by_inn ($connect_data, $inn); // ищем есть ли такой ИНН в АМО
      if ($inn_our_company == null)  { // проверяем есть ли такой ИНН в АМО
        require "parts/parts_with_inn_with_reestr.php";
      } else {
          echo "<br>Eсть Компания с ИНН : $inn БУДЕМ ДОБАВЛЯТЬ СДЕЛКУ<br>";
          require "parts/parts_with_inn_add_only_deal.php";
        //  Print_r($inn_our_company);
        //  die();
             }
     } else  {
        echo "<br>//////////////////////////// КОМПАНИЯ БЕЗ ИНН //////////////////////<br>";
        require "parts/parts_without_inn_with_reestr.php";

    }

    sleep(1);
    $count++;
    echo date('Y-m-d H:i:s');
    echo "<br>";
    echo "<br> CONUT =$count<br>";

    echo "<br><b>*************************************************************************************************</b><br>";
}

echo "<br> OYOGO=$count";
}