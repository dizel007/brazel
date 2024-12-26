<?php

require_once "../connect_db.php";

  $id = $_POST["id"];
  $id_email = $_POST["id_email_cor"];
  $InnCustomer = $_POST['InnCustomer'];
  $actual = $_POST["actual_email"];
  $commentEmail=htmlspecialchars($_POST["commentEmail"]);
  $today = date("Y-m-d H:i:s");       
  $real_email = $_POST["real_email"];

  $data_arr = [
    'comment'=> $commentEmail,
    'actual'=> $actual,
    'date_write'=> $today,
    'id' => $id_email,
  ];
  
$sql = "UPDATE email SET  comment=:comment, actual=:actual, date_write=:date_write
                        WHERE id=:id";
  $stmt= $pdo->prepare($sql);
  $stmt->execute($data_arr);


  
$db_comment="Изм.почты. :$real_email :";
$db_comment.=" коммент :".$commentEmail.";";
$db_comment.=" актуал :".$actual.";";
  
   
$date_change = date("Y-m-d");
$id_item = $InnCustomer;
$what_change = 5;  // Изменяем емайл в БД
$comment_change = $db_comment; 
$author = $userdata['user_login'];
require "insert_reports.php";

header ("Location: ..?transition=10&id=".$id."&InnCustomer=".$InnCustomer);
exit();    // прерываем работу скрипта, чтобы забыл о прошлом


?>
