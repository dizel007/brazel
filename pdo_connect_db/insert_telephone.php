<?php
require_once "../connect_db.php";
require_once "../functions/telephone_make.php";
 
$id = $_GET['id'];
$InnCustomer = $_GET['InnCustomer'];
$new_telephone=htmlspecialchars($_GET['telefon']);
$whatsapp = $_GET["whatsapp"];
// $viber = $_GET["viber"];
$actual = $_GET["actual_phone"];
$commentPhone=htmlspecialchars($_GET["commentPhone"]);
$contactName=htmlspecialchars($_GET["contactName"]);
$today = date("Y-m-d H:i:s"); 

$new_telephone_arr=array( "InnCustomer" => $InnCustomer,
                          "new_telephone" => $new_telephone,
                          "whatsapp" => $whatsapp,
                          "actual" => $actual,
                          "commentPhone" => $commentPhone,
                          "contactName" => $contactName,
                          "today" => $today,
                          
                        );
InsertOurTelephoneInDB ($pdo, $new_telephone_arr);





// $stmt = "SELECT * FROM users WHERE user_hash = '$_COOKIE[hash]'";
  
// $stmt = $pdo->prepare("SELECT user_login FROM users WHERE user_hash = '$_COOKIE[hash]'");
// $stmt->execute();
// $user_login_arr = $stmt->fetchAll(PDO::FETCH_COLUMN);
// $user_login = $user_login_arr[0];

 
$db_comment="Нов. тел. :$new_telephone :";
$db_comment.="контакт :".$contactName.";";
$db_comment.=" коммент :".$commentPhone.";";
$db_comment.=" актуал :".$actual.";";
 

  $date_change = date('Y-m-d');
  $id_item = $InnCustomer;
  $what_change = 4;  // 4 - ввод нового телефона
  $comment_change = $db_comment; 
  $author = $userdata['user_login'];

require "insert_reports.php";
    
//   $sql = "INSERT INTO `reports`(`id`, `date_change`, `id_item`, `what_change`, `comment_change`, `author`)
//     VALUES ('', '$date_change', '$id_item', '$what_change', '$comment_change', '$author')";
//   $query = $mysqli->query($sql);
//   if (!$query){
//    die("Соединение не удалось: (Добавление в реестр изменений) ");
//   }


header ("Location: ../index.php?transition=10&id=".$id."&InnCustomer=".$InnCustomer);  // перенаправление на нужную страницу
exit();    // прерываем работу скрипта, чтобы забыл о прошлом




