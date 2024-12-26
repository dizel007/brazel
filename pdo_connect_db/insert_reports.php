<?php 
date_default_timezone_set('Europe/Moscow');

$date_change = date('Y-m-d');

// Проверяем если ли какой нибуль комментарий, если нет, то не добавляем строку
// (isset($dop_comment))?$dop_comment = $dop_comment: $dop_comment='';

$stmt  = $pdo->prepare("INSERT INTO `reports` 
                      (date_change, id_item, what_change, comment_change, author)
                       VALUES (:date_change, :id_item, :what_change, :comment_change, :author)");

$stmt ->bindParam(':date_change', $date_change);
$stmt ->bindParam(':id_item', $id_item);
$stmt ->bindParam(':what_change', $what_change);
$stmt ->bindParam(':comment_change', $comment_change);
$stmt ->bindParam(':author', $author);
// $stmt ->bindParam(':dop_comment', $dop_comment);


if ($stmt ->execute()) {
  $last_id = $pdo->lastInsertId(); // получаем id - введенной строки 
  // echo "Запись УДАЧНО добавлена successfully";
} else {
  die ("Какой то облом, со вставкой записи в таблицу reports");
}
?>