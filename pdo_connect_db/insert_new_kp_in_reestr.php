<?php
// https://habr.com/en/post/137664/
// инструкция по вставки через PDO

require_once ("../connect_db.php");
require_once ("../new_kp_info/test_file_name.php"); // если имя файла занято, то добавится индекс
require_once ("../new_kp_info/analiz_siroy_kp.php");
// require_once ("../new_kp_info/format_new_kp.php");
require_once ("../functions/telephone_make.php"); // наложить маску на телефонные номера

require_once '../new_kp_info/make_pdf.php'; // фукнция создания КП в пдф формате
require_once '../functions/check_by_sell.php'; // функции проверки были ли продажи в компании 

require_once '../new_kp_info/make_json_file.php'; // фукнция создания КП в пдф формате

 

// считваем все данные из ПОСТ формы
$KpNumber =  trim(htmlspecialchars($_POST['KpNumber']));
// считваем стоимость доставки 

$DostCost =  trim(htmlspecialchars($_POST['DostCost']));
$uslovia_oplati=TEXT_USLOVIA_OPLATI_DEFAULT;
$srok_izgotovl=TEXT_USLOVIA_IZGOTOVLEBIA_DEFAULT;

// тип КП - откуда пришел запрос
$type_kp = trim(htmlspecialchars($_POST['type_kp']));

// если нет номера КП то берем последний мы БД
if ($KpNumber == ''){ 
    $stmt = $pdo->prepare("SELECT last_kp_number FROM `sys_setup`");
    $stmt->execute();
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $KpNumber = $arr[0]['last_kp_number'] + 1;
    $priz_update_kp_numer = 1;
}
// Дату используем в разных форматах для КП и для БД  
$KpDate = $_POST['KpDate'];
$KpDate = date('Y-m-d', strtotime($KpDate));


$now = new DateTime($_POST['KpDate']);
$KpDate_temp = $now->format('d.m.Y');


$KpDate == ''?$KpDate= date('Y-m-d'): $KpDate=$KpDate; // если дата пустая, то стапвим сегодня
$KpDate == '1970-01-01'?$KpDate= date('Y-m-d'): $KpDate=$KpDate;
$KpDate == '0000-00-00'?$KpDate= date('Y-m-d'): $KpDate=$KpDate;

// Если задан ИНН то проверим его по БД, если добавляем по инн, то нужно будет его ввести в Базу
$InnCustomer = trim($_POST['InnCustomer']);

// ******************* делаем запрос, чтобы узнать есть ли у нас в БД этот ИНН ********
$NameCustomer_temp = trim($_POST['NameCustomer']);
//  ********** делаем костыль чтобы убрать двойные ковычки из названий компаний ************

// echo $NameCustomer_temp,"<br>";

$NameCustomer = str_replace('"', '«', $NameCustomer_temp, $count);
$NameCustomer = str_replace('/', '_', $NameCustomer); // убераем слэш из наименования  файлов

for ($i = 0; $i < mb_strlen($NameCustomer); $i++) {
    $char = mb_substr($NameCustomer, $i, 1);
  }
if ($char == '«') {
  $NameCustomer = substr($NameCustomer,0,-2);
  $NameCustomer .="»";
}
// **************убираем всякие проьелы и переносы **********************
$NameCustomer = str_replace(array("\n","\r"), '', $NameCustomer);


// Если нет контактного лица, то пишем отдел продаж
trim($_POST['ContactCustomer']) ==''?$ContactCustomer = 'Отдел снабжения': $ContactCustomer = trim($_POST['ContactCustomer']);

$TelCustomer = trim($_POST['TelCustomer']);
$TelCustomer = str_replace(' ', '', $TelCustomer); // убрали все пробелы
$arr_TelCustomer = (explode(',', $TelCustomer)); // Берем 0 и 1 телефон из ПОСТ запрсоа

$i1=0; // счетчик телефонов
if (strlen($arr_TelCustomer[0]) > 6) { // если есть хоть один номер длинее 6 цифр
foreach ($arr_TelCustomer as &$value) {
  $value = telephoneMake($value); // приводим у общему виду
  $value = DeleteFirstSymbol($value); // меняем 8 на 7 (первыую цифру)
  $i1++;
}
}

for ($i=0; $i<=$i1; $i++) {
 if ($i<2) { // оставляем не более двух телефонов
  @$new_TelCustomer.="\n".$arr_TelCustomer[$i];
  }
}
$new_TelCustomer = substr($new_TelCustomer,1,strlen($new_TelCustomer)); // удаояем первый символ

$EmailCustomer = trim(htmlspecialchars($_POST['EmailCustomer']));
$product_type = trim(htmlspecialchars($_POST['product_type']));

$idKp = date('Y').date('m').date('d').(127 + date('H')+ date('i')+date('s')*32 )*2; // неповтор
$KpImportance = $_POST['KpImportance']; 
$Responsible = $_POST['responsible'];
$adress = trim($_POST['Adress']);
 


$adress_in_kp = $adress;

$date_write = date('Y-m-d');

$KpFileName= "№".$KpNumber." от ".$KpDate_temp." ".$NameCustomer." от ООО ТД АНМАКС";


$ZakupName = TEXT_KP_INFO;

$comparr = array ('InnCustomer' => $InnCustomer,
                   'KpNumber' => $KpNumber ,
                   'KpDate' => $KpDate_temp,
                   'NameCustomer' => $NameCustomer,
                   'KpImportance' => $KpImportance ,
                   'Adress' => $adress_in_kp,
                   'uslovia_oplati' => $uslovia_oplati,
                   'srok_izgotovl' => $srok_izgotovl);
$comparr += array ('ContactCustomer' => $ContactCustomer);
$comparr += array ('Email' => $EmailCustomer);
$comparr += array ('Telephone' => $new_TelCustomer);
$comparr += array ('responsible' => $Responsible);
$comparr += array ('DostCost' => $DostCost);
$comparr += array ('ZakupName' => $ZakupName);

$comparr += array ('KpFileName' => $KpFileName); // название файла
$comparr += array('json_file_next' => $KpFileName); // наименование файла

//  ***************************************************************************************
# ЗАГРУЖАЕМ НЕОБХОДИМЫЕ ФАЙЛЫ НА САЙТ
$uploaddir = '../NEW_KP/';
$uploadfile = $uploaddir.$_FILES['upload_file']['name'];
// Если в директории есть файл с таким  именем (запустили одновременно создание 2-х КП),файл будет сохранен с названием name_1.***
$temp = safe_file($uploadfile);
// Сохораняем файл на сервер
if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $temp)) {
           // echo "Файл корректен и был успешно загружен.\n";
          // header("Location: ../index.php?fullload=777"); exit();
          // echo "file v papke";
       } else {
            echo '<pre>';
            echo "Некоторая отладочная информация:\n";
            print_r($_FILES);
            echo "</pre>";
        }

// ***************Выбираем список товаров из файла *************************************
$products = analiz_kp($temp);
// **************************************************************************************

//  вычитаваем данные про ответственного
$stmt = $pdo->prepare("SELECT * FROM `users` WHERE `user_name` = ?");
$stmt->execute([$Responsible]);
$user_responsible_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ****************************************
// $temp_array = format_new_kp($products, $comparr, $user_responsible_arr); // Формируем КП и получаем сумму КП 
// format_new_kp($products, $comparr, $user_responsible_arr); // Формируем КП и получаем сумму КП 

unlink($temp);  // удаляем загружаемый файл, Нах их копить



/************************************ Формируем JSON **************************************/
$KpSum = make_json_kp_file($products, $comparr,$user_responsible_arr,5);

// $LinkKp = 'EXCEL/'.$KpFileName.".xlsx"; // закоментил 26.12.2024 - когда решил отказать от екскля

$LinkKp = ''; // закоментил 26.12.2024 - когда решил отказать от екскля

$Link_json_link_Kp = $KpFileName;

// die('JSON');
/* 
*********************************** Формируем ПДФ *************************************
*/
make_pdf_kp($products, $comparr,$user_responsible_arr, $KpSum,5); // 5 - высота строки по умолчанию


// die('FORMAT PDF FILE');

// **************** вставляем каждый параметр  данных  *********************
$stmt  = $pdo->prepare("INSERT INTO `reestrkp` 
                       (KpNumber, KpData, InnCustomer, NameCustomer, idKp, KpImportance, Responsible, KpSum, adress, date_write, LinkKp, type_kp, type_product, json_file)
                       VALUES (:KpNumber, :KpData, :InnCustomer, :NameCustomer, :idKp, :KpImportance, :Responsible, :KpSum, :adress, :date_write, :LinkKp, :type_kp, :type_product, :json_file)");

$stmt ->bindParam(':KpNumber', $KpNumber);
$stmt ->bindParam(':KpData', $KpDate);
$stmt ->bindParam(':InnCustomer', $InnCustomer);
$stmt ->bindParam(':NameCustomer', $NameCustomer);
$stmt ->bindParam(':idKp', $idKp);
$stmt ->bindParam(':KpImportance', $KpImportance);
$stmt ->bindParam(':Responsible', $Responsible);
$stmt ->bindParam(':KpSum', $KpSum);
$stmt ->bindParam(':adress', $adress);
$stmt ->bindParam(':date_write', $date_write);
$stmt ->bindParam(':LinkKp', $LinkKp);
$stmt ->bindParam(':type_kp', $type_kp);
$stmt ->bindParam(':type_product', $product_type);
$stmt ->bindParam(':json_file', $Link_json_link_Kp);


if ($stmt ->execute()) {
  $last_id = $pdo->lastInsertId(); // получаем id - введенной строки 
  // echo "Запись УДАЧНО добавлена successfully";
  check_by_sell($pdo, $InnCustomer); // обновляем признак продадив эту комапнию
} else {
  die (" ** DIE ** Не получилось добавить данные, INSERT нового КП с сайта");
}
//  *** сомтрим признак нужно ли обновить номер КП, или номер был ввен вручную
if (@$priz_update_kp_numer == 1 ) {

  $stmt = $pdo->prepare("UPDATE `sys_setup` SET `last_kp_number` = :KpNumber");
$stmt->execute(array('KpNumber' => $KpNumber));
}


// ******************* Добавляем строчку в отчеты  ********
$date_change = date("Y-m-d");
$id_item = $last_id;
$what_change = 8;
$comment_change = "Нов. КП№".$KpNumber." ".$NameCustomer; 
$author = $userdata['user_login'];
require "insert_reports.php";

// header("Location: ../".$LinkKp);
header("Location: ../index.php?transition=10&id=".$id_item);

// echo "ID= ", $last_id,"<br>";
// die('POOOH');