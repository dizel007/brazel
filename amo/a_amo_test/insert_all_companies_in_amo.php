<?php
// ob_end_clean();
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


echo "<pre>";
  // Вычитываем все компании из реестра компаний 
  $stmt = $pdo->prepare("SELECT id, inn, name FROM inncompany WHERE amo_d <> 1 ORDER BY id DESC");
  // $stmt = $pdo->prepare("SELECT * FROM reestrkp ORDER BY id DESC LIMIT 100");

  $stmt->execute([]);
  $arr_inn_name = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "<br>".(count($arr_inn_name))."<br>";
print_r($arr_inn_name);
// die();

foreach ($arr_inn_name as $j_inn) {
  echo "<br><b>*************************************************************************************************</b><br>";
  set_time_limit(120);
  echo "<br><b>SET_LIMIT_120</b><br>";

  $id = $j_inn['id']; // ID КП
  $inn = $j_inn['inn']; // ИНН из КП

        $inn_our_company = find_company_by_inn ($connect_data, $inn); // ищем есть ли такой ИНН в АМО
      if ($inn_our_company == null)  { // проверяем есть ли такой ИНН в АМО
        require "parts/add_only_company_in_amo.php";

        $data_arr_2 = [
          'inn' => $inn,
        ];
          
        $sql_2 = "UPDATE inncompany SET amo_d=1 WHERE inn=:inn";
        $stmt_2= $pdo->prepare($sql_2);
        $stmt_2->execute($data_arr_2);
        echo "<br>//////////////////////////// ОБНОВИЛИ БАЗУ //////////////////////<br>";
        $count++;
      
     } else  {
        echo "<br>//////////////////////////// КОМПАНИЯ Существует //////////////////////<br>";
          $data_arr_2 = [
            'inn' => $inn,
          ];
          
        $sql_2 = "UPDATE inncompany SET amo_d=1 WHERE inn=:inn";
        $stmt_2= $pdo->prepare($sql_2);
        $stmt_2->execute($data_arr_2);
        echo "<br>//////////////////////////// ОБновили  АМО КОМПАНИЯ Существует //////////////////////<br>";       
        }

      
    echo date('Y-m-d H:i:s');
    echo "<br> CONUT =$count<br>";

    echo "<br><b>*************************************************************************************************</b><br>";
}

echo "<br> VSEGO DOBAVILI COMPANY =$count";
