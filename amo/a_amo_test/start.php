<?php
ob_end_clean();
require_once 'connect_db.php';
require_once 'amo_setup.php';
require_once 'access.php';
require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
require_once 'parts/parce_excel_file.php'; // парсер ексель КП

require_once 'libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
$count = 0;
echo "<br>";
echo date('Y-m-d H:i:s');
echo "<br>";
$connect_data['access_token'] = $access_token ;
// echo "<br>";
$connect_data['subdomain'] = $subdomain;
// echo "<br>";

echo "<pre>";
  // Вычитываем все телефоны с таким ИНН
  $stmt = $pdo->prepare("SELECT id,InnCustomer, NameCustomer FROM reestrkp ORDER BY id DESC LIMIT 100");
  // $stmt = $pdo->prepare("SELECT * FROM reestrkp ORDER BY id DESC LIMIT 100");

  $stmt->execute([]);
  $arr_inn_name = $stmt->fetchAll(PDO::FETCH_ASSOC);



//   echo"<pre>";
// foreach ($arr_inn_name as $sdelki) {
//   // unset($data_temp5);
//   $comment = $sdelki['Comment'];
//   $arr_comment = explode('||+', $comment); // массив с комментариями
//   print_r($arr_comment);
  
//    foreach ($arr_comment as $item_comment) {
    
//         if ((strlen($item_comment) > 6)) {
//               $item_comment = str_replace('@!', '', $item_comment);
//               echo "<br>*****$item_comment******<br>";
//               $data_temp5[] = array(
//                   "note_type" => "common",
//                   "params" => array("text" => $item_comment),
//              );
//         }
//    } 
//   }



// print_r($data_temp5);
// die();

foreach ($arr_inn_name as $j_inn) {
  echo "<br><b>*************************************************************************************************</b><br>";
  set_time_limit(120);
  echo "<br><b>SET_LIMIT_120</b><br>";

  $id = $j_inn['id']; // ID КП
  $inn = $j_inn['InnCustomer']; // ИНН из КП
  
    if ($inn !=0) {  /// проверяем если ли ИНН в сделке
        $inn_our_company = find_company_by_inn ($connect_data, $inn); // ищем есть ли такой ИНН в АМО
      if ($inn_our_company == null)  { // проверяем есть ли такой ИНН в АМО
        require "parts/parts_with_inn.php";
      } else {
                   echo "<br>Eсть Компания с ИНН : $inn <br>";
             }
     } else  {
        echo "<br>//////////////////////////// КОМПАНИЯ БЕЗ ИНН //////////////////////<br>";
        require "parts/parts_without_inn.php";

    }

    sleep(1);
    $count++;
    echo date('Y-m-d H:i:s');
    echo "<br>";
    echo "<br> CONUT =$count<br>";

    echo "<br><b>*************************************************************************************************</b><br>";
}

echo "<br> OYOGO=$count";
