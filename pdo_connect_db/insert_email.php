<?php

require_once "../connect_db.php";
require_once "../functions/email_make.php";

$id = $_GET["id"];
$InnCustomer = $_GET["InnCustomer"];
$new_email=trim(htmlspecialchars($_GET["new_email"]));
$actual_email = $_GET["actual_email"];
$commentEmail=htmlspecialchars($_GET["commentEmail"]);
$today = date("Y-m-d H:i:s"); 

$new_email_arr=array( "InnCustomer" => $InnCustomer,
                          "new_email" => $new_email,
                          "actual" => $actual_email,
                          "commentPhone" => $commentEmail,
                          "today" => $today,
                          
                        );
InsertOurEmailInDB ($pdo, $new_email_arr);


   
  $db_comment="Нов.почта. :$new_email :";
  $db_comment.=" коммент :".$commentEmail.";";
  $db_comment.=" актуал :".$actual_email.";";
    
  $date_change = date("Y-m-d");
  $id_item = $InnCustomer;
  $what_change = 6;  // Добавляем емайл в БД
  $comment_change = $db_comment; 
  $author = $userdata['user_login'];
  require "insert_reports.php";
       
header ("Location: ..?transition=10&id=".$id."&InnCustomer=".$InnCustomer);
exit();    // прерываем работу скрипта, чтобы забыл о прошлом


?>
