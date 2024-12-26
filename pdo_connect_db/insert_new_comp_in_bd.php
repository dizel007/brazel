<?php
// https://habr.com/en/post/137664/
// инструкция по вставки через PDO

require_once ("../connect_db.php");
$id=$_POST['id'];
$back_transition=$_POST['back_transition'];
// Если задан ИНН то проверим его по БД, если добавляем по инн, то нужно будет его ввести в Базу
$InnCustomer = $_POST['InnCustomer'];
// Проверим, чтобы не было уже такого ИНН
$stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = ?");
$stmt->execute([$InnCustomer]);
$TempInnComp = $stmt->fetchAll(PDO::FETCH_ASSOC);
$user_write = $userdata['user_login'];


// var_dump($InnCustomer);
// если ИНН существет, то уходим на создание КП
if (@$TempInnComp[0]['inn'] == $InnCustomer) {
  
  header("Location: ../index.php?transition=$back_transition&InnCustomer=".$InnCustomer."&id=".$id);
  die('Компания с таким ИНН уже вуществует');
}

$KppCustomer = $_POST['KppCustomer'];
// ******************* делаем запрос, чтобы узнать есть ли у нас в БД этот ИНН ********
$NameCustomer_temp = $_POST['NameCustomer'];

$NameCustomer = str_replace('"', '«', $NameCustomer_temp, $count);


//  ********** делаем костыль чтобы убрать двойные ковычки из названий компаний ************
for ($i = 0; $i < mb_strlen($NameCustomer); $i++) {
    $char = mb_substr($NameCustomer, $i, 1);
  }
if ($char == '«') {
  $NameCustomer = substr($NameCustomer,0,-2);
  $NameCustomer .="»";
}
// *************************************************************************************************

// контактного лица
$ContactCustomer = $_POST['ContactCustomer'];

$TelCustomer = str_replace('+' , '',$_POST['TelCustomer']); // 

$TelCustomer = mb_strstr($TelCustomer, '(', false);
$TelCustomer = '7 '.$TelCustomer;


$EmailCustomer = $_POST['EmailCustomer'];
$adress = $_POST['Adress'];
$date_write = date('Y-m-d');
$CommentCustomer='';



// echo "<pre>";
// print_r($adress);
// echo "<br>";
// print_r($date_write);
// echo "<pre>";

// echo $InnCustomer."<br>";
// echo $KppCustomer."<br>";
// echo $NameCustomer."<br>";
// echo $TelCustomer."<br>";
// echo $EmailCustomer."<br>";
// echo $adress."<br>";
// echo $CommentCustomer."<br>";
// echo $ContactCustomer."<br>";
// echo $date_write."<br>";

// die('2222222');


// **************** вставляем каждый параметр  данных  *********************
$stmt  = $pdo->prepare("INSERT INTO `inncompany` 
                       (inn, kpp, name, telefon, email, adress, contactFace, comment, date_write, user_write)
                       VALUES (:inn, :kpp, :name, :telefon, :email, :adress, :contactFace, :comment, :date_write, :user_write)");


$stmt ->bindParam(':inn', $InnCustomer);
$stmt ->bindParam(':kpp', $KppCustomer);
$stmt ->bindParam(':name', $NameCustomer);
$stmt ->bindParam(':telefon', $TelCustomer);
$stmt ->bindParam(':email', $EmailCustomer);
$stmt ->bindParam(':adress', $adress);
$stmt ->bindParam(':comment', $CommentCustomer);
$stmt ->bindParam(':contactFace', $ContactCustomer);
$stmt ->bindParam(':date_write', $date_write);
$stmt ->bindParam(':user_write', $user_write);

if ($stmt ->execute()) {
  $last_id = $pdo->lastInsertId(); // получаем id - введенной строки 
  // echo "Запись УДАЧНО добавлена successfully";
} else {
  // $stmp->errorInfo();
  echo "fff";
  $last_id = $pdo->lastInsertId(); // получаем id - введенной строки 
  die (" ** DIE ** Не получилось добавить данные о компании, INSERT новой компании по ИНН");
}

// Добавляем новый телефонв БД телефонов
if ($TelCustomer <> '') {
      $stmt  = $pdo->prepare("INSERT INTO `telephone` 
                            (inn, telephone, date_write)
                            VALUES (:inn, :telephone, :date_write)");
      $stmt ->bindParam(':inn', $InnCustomer);
      $stmt ->bindParam(':telephone', $TelCustomer);
      $stmt ->bindParam(':date_write', $date_write);
      if ($stmt ->execute()) {
          // echo "Запись УДАЧНО добавлена successfully";
      } else {
        die (" ** DIE ** Не получилось добавить телефонный номер в БД");
      }
}
// Добавляем новый EMAIL БД email
if ($EmailCustomer <> '') {
    $stmt  = $pdo->prepare("INSERT INTO `email` 
                          (inn, email, date_write)
                          VALUES (:inn, :email, :date_write)");
    $stmt ->bindParam(':inn', $InnCustomer);
    $stmt ->bindParam(':email', $EmailCustomer);
    $stmt ->bindParam(':date_write', $date_write);
    if ($stmt ->execute()) {
        // echo "Запись УДАЧНО добавлена successfully";
    } else {
      die (" ** DIE ** Не получилось добавить email в БД email");
    }
}

// ******************* Добавляем строчку в отчеты  ********
$date_change = date("Y-m-d");
$id_item =  $InnCustomer;
$what_change = 9;
$comment_change = "Нов. Компания: ".$NameCustomer; 
$author = $userdata['user_login'];
require "insert_reports.php";


// ******************* делаем перенаправление на создание нового КП ********
header("Location: ../index.php?transition=$back_transition&InnCustomer=".$InnCustomer."&id=".$id);

die('Че то померли на инсерте нового  ИНН в БД');