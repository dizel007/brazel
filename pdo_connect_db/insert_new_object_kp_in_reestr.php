<?php
// https://habr.com/en/post/137664/
// инструкция по вставки через PDO

require_once ("../connect_db.php");
require_once ("../functions/make_new_kp_number.php");
require_once ("../new_kp_info/test_file_name.php"); // если имя файла занято, то добавится индекс
require_once ("../new_kp_info/analiz_siroy_kp.php");  // функция получения массива информации с товарами
// require_once ("../new_kp_info/format_new_kp.php");    // фукция по создания EXCEL файла 
require_once '../new_kp_info/make_pdf.php';
require_once '../functions/check_by_sell.php'; // функции проверки были ли продажи в компании 

require_once '../new_kp_info/make_json_file.php'; // фукнция создания КП в пдф формате
// echo "<pre>";
// print_r($userdata['user_name']);
// echo "<pre>";
// die();
$marker = 1;

$tender_begin_price  = $_POST['tender_begin_price']; // НМЦК тендера
// тип КП - откуда пришел запрос
$type_kp = $_POST['type_kp'];
// тип пролукции в КП 
$product_type = $_POST['product_type'];
// номер КП берем последний из БД
$KpNumber = make_new_kp_number($pdo);

$uslovia_oplati='по согласованию сторон';
$srok_izgotovl='в наличии';


// Дату используем в разных форматах для КП и для БД  
$KpDate= date('Y-m-d'); // дата для БД
$now = new DateTime($KpDate);
$KpDate_temp = $now->format('d.m.Y'); // Для КП


// Если задан ИНН то проверим его по БД, если добавляем по инн, то нужно будет его ввести в Базу
$InnCustomer = $_POST['InnCustomer'];
// ******************* делаем запрос, чтобы узнать есть ли у нас в БД этот ИНН ********
$NameCustomer_temp = $_POST['NameCustomer'];
//  ********** делаем костыль чтобы убрать двойные ковычки из названий компаний ************
$NameCustomer = str_replace('"', '«', $NameCustomer_temp, $count);
for ($i = 0; $i < mb_strlen($NameCustomer); $i++) {
    $char = mb_substr($NameCustomer, $i, 1);
  }
if ($char == '«') {
  $NameCustomer = substr($NameCustomer,0,-2);
  $NameCustomer .="»";
}

$_POST['ContactCustomer'] ==''?$ContactCustomer = 'Отдел снабжения': $ContactCustomer = $_POST['ContactCustomer'];

$TelCustomer = $_POST['TelCustomer'];
$TelCustomer = mb_strstr($TelCustomer, '(', false);
$TelCustomer = '7 '.$TelCustomer;

$EmailCustomer = $_POST['EmailCustomer'];
$KonturLink = $_POST['KonturLink']; // ссылка на контур

$idKp = $_POST['idKp']; // неповтор
$adress = $_POST['Adress'];

$adress_in_kp = TEXT_PERED_ADRESOM_DOSTAVKI.'('.$adress.')';  

$date_write = date('Y-m-d');
isset($_POST['tender_number'])?$tender_number = $_POST['tender_number']:$tender_number = ''; // номер закукпки


$KpFileName = "№".$KpNumber." от ".$KpDate_temp." ". $NameCustomer." (КП к закупке№".$tender_number.") ООО ТД АНМАКС";
$DostCost = 0; // чтобы формитирование КП не переделывать

 if (isset($_POST['tender_descr'])) {
$ZakupName = "Предлагаем рассмотреть приобретение следующих товаров, для закупки №".$tender_number. " ".$_POST['tender_descr'].", победителем которой вы являетесь:";}
else {
  $ZakupName =TEXT_KP_INFO;
}

// Данные не заполняются при создании КП

$Responsible = $userdata['user_name'];
$KpImportance = "";

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
$comparr += array ('Telephone' => $TelCustomer);
$comparr += array ('responsible' => $Responsible);
$comparr += array ('DostCost' => $DostCost);
$comparr += array ('ZakupName' => $ZakupName);

$comparr += array ('KpFileName' => $KpFileName); // название файла

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



unlink($temp);  // удаляем загружаемый файл, Нах их копить



/* 
*********************************** Формируем JSON *************************************
*/
$temp_array['total'] = make_json_kp_file($products, $comparr,$user_responsible_arr,5);
$KpSum = $temp_array['total'];
$KpFileName= $comparr['KpFileName'];

// $LinkKp = 'EXCEL/'.$KpFileName.".xlsx"; // закоментил 26.12.2024 - когда решил отказать от екскля
$LinkKp = ''; // закоментил 26.12.2024 - когда решил отказать от екскля


$Link_json_link_Kp = $KpFileName;

// ****************************************
// format_new_kp($products, $comparr, $user_responsible_arr); // Формируем ексель КП

/* 
*************** Формируем ПДФ *************************************
*/
make_pdf_kp($products, $comparr,$user_responsible_arr, $KpSum,5); // 5- высота строки товаров



$KpImportance ='';  
$Responsible = '';
$KpSum = '';


// **************** вставляем каждый параметр  данных  *********************

$stmt  = $pdo->prepare("INSERT INTO `reestrkp` 
                        (KpNumber, KpData, InnCustomer, NameCustomer, idKp, KpImportance, Responsible, KpSum, adress, konturLink, date_write, LinkKp, type_kp, type_product, marker, TenderSum, json_file	)
                        VALUES (:KpNumber, :KpData, :InnCustomer, :NameCustomer, :idKp, :KpImportance, :Responsible, :KpSum, :adress, :konturLink, :date_write, :LinkKp, :type_kp, :type_product, :marker, :TenderSum, :json_file)");

$stmt ->bindParam(':KpNumber', $KpNumber);
$stmt ->bindParam(':KpData', $KpDate);
$stmt ->bindParam(':InnCustomer', $InnCustomer);
$stmt ->bindParam(':NameCustomer', $NameCustomer);
$stmt ->bindParam(':idKp', $idKp);
$stmt ->bindParam(':KpImportance', $KpImportance);
$stmt ->bindParam(':Responsible', $Responsible);
$stmt ->bindParam(':KpSum', $KpSum);
$stmt ->bindParam(':adress', $adress);
$stmt ->bindParam(':konturLink', $KonturLink);
$stmt ->bindParam(':date_write', $date_write);
$stmt ->bindParam(':LinkKp', $LinkKp);
$stmt ->bindParam(':type_kp', $type_kp);
$stmt ->bindParam(':type_product', $product_type);
$stmt ->bindParam(':marker', $marker);
$stmt ->bindParam(':TenderSum', $tender_begin_price);
$stmt ->bindParam(':json_file', $Link_json_link_Kp);



if ($stmt ->execute()) {
  $last_id = $pdo->lastInsertId(); // получаем id - введенной строки 
  check_by_sell($pdo, $InnCustomer); // обновляем признак продадив эту комапнию

  // ******************* Добавляем строчку в отчеты  ********
  $date_change = date("Y-m-d");
  $id_item = $last_id;
  $what_change = 8;
  $comment_change = "Нов. КП№".$KpNumber." ".$NameCustomer; 
  $author = $userdata['user_login'];
  require "insert_reports.php";

  // echo "Запись УДАЧНО добавлена successfully";
} else {
  die (" ** DIE ** Не получилось добавить данные, INSERT нового КП с сайта");
}

//  *** сомтрим признак нужно ли обновить номер КП, или номер был ввен вручную
update_kp_number_in_db ($pdo, $KpNumber); 


// header("Location: ../".$LinkKp);
header("Location: ../index.php?transition=10&id=".$id_item);

// echo "ID= ", $last_id,"<br>";
die('Умерли на вводе данных в реестр при добавлении нового КП');