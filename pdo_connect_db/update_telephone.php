<?php

require_once "../connect_db.php";

  $id_phone = $_POST["id_phone_cor"];
  $id = $_POST["id"];
  $InnCustomer = $_POST['InnCustomer'];
  $whatsapp = $_POST["whatsapp"];
  $actual = $_POST["actual_phone"];
  $commentPhone=htmlspecialchars($_POST["commentPhone"]);
  $contactName=htmlspecialchars($_POST["contactName"]);
  $today = date("Y-m-d H:i:s");       
  $real_phone = $_POST["real_phone"];
  

 
  $data_arr = [
    'comment'=> $commentPhone,
    'whatsapp'=> $whatsapp,
    'name'=> $contactName,
    'actual'=> $actual,
    'date_write'=> $today,
    'id' => $id_phone,
  ];
  

$sql = "UPDATE telephone SET  comment=:comment,
                              whatsapp=:whatsapp,
                              name=:name,
                              actual=:actual,
                              date_write=:date_write
                        WHERE id=:id";
  $stmt= $pdo->prepare($sql);
  $stmt->execute($data_arr);

 
  
$db_comment="Изм. тел. :$real_phone :";
$db_comment.="контакт :".$contactName.";";
$db_comment.=" коммент :".$commentPhone.";";
$db_comment.=" актуал :".$actual.";";
     
$date_change = date('Y-m-d');
$id_item = $InnCustomer;
$what_change = 3;  // 3 -  изменение телефона
$comment_change = $db_comment; 
$author = $userdata['user_login'];


  
require "insert_reports.php";
        

      

header ("Location: ../index.php?transition=10&id=".$id."&InnCustomer=".$InnCustomer);
exit();    // прерываем работу скрипта, чтобы забыл о прошлом


?>
