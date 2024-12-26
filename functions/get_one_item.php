<?php
//Достаем массив данных для модального окна
require_once ("../connect_db.php");
$id = $_POST['id'];
$stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = ?");
$stmt->execute([$id]);
$arr_name = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Возвращаем данные в формате JSon
echo json_encode($arr_name, JSON_UNESCAPED_UNICODE);
?>
