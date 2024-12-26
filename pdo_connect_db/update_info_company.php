<?php
require_once "../connect_db.php";
// Обновляем данные в талиблице. 

$id = $_POST['id'];
$InnCustomer = $_POST['InnCustomer'];

$stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = $InnCustomer");
$stmt->execute([]);
$old_inn_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);


$contactFace=trim($_POST['contactFace'], $character_mask = " \t\n\r\0\x0B");  // убипаем все лишние пробелы и переносы
$comment=trim($_POST['comment'], $character_mask = " \t\n\r\0\x0B");  // убипаем все лишние пробелы и переносы
$contactFace=htmlspecialchars($contactFace);
$comment=htmlspecialchars($comment);


$data_arr = [
  'contactFace'=> $contactFace,
  'comment'=> $comment,
  'inn' => $InnCustomer,
];

$sql = "UPDATE inncompany SET contactFace=:contactFace,
                              comment=:comment
                        WHERE inn=:inn";
$stmt= $pdo->prepare($sql);
$stmt->execute($data_arr);


$db_comment="";
      if ($old_inn_arr[0]['contactFace'] != $contactFace) { $db_comment.="конт.лицо :".$contactFace.";";}
      if ($old_inn_arr[0]['comment'] != $comment)    { $db_comment.=" комент :".$comment.";";}
// Если нет изменений, то ничего писать не будем
if ($db_comment <> "") {     
    $id_item = $InnCustomer;
    $what_change = 2; 
    $comment_change = $db_comment; 
    $author = $userdata['user_login'];
    require "insert_reports.php";
  }
header ("Location: ../?transition=10&id=".$id."&InnCustomer=".$InnCustomer);  // перенаправление на нужную страницу
exit();    // прерываем работу скрипта, чтобы забыл о прошлом

?>
