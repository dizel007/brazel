<?php
require_once "../connect_db.php";

// require_once "../functions/make_arr_from_obj.php";
// require_once "../functions/get_user.php";
// Обновляем данные в талиблице. $typeQuery - выбоо столбца, который будем редактировать. $id -  ИД строки которую будем редактировать
$id = $_POST['id'];
$id = htmlspecialchars($id);

// $user_login = $_POST['user_login']; // Получаем имя пользователья
$user_login = $userdata['user_login'];
$stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = ?");
$stmt->execute([$id]);
$my_id_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

$KpImportance = $_POST['KpImportance'];
$Responsible = $_POST['Responsible'];
$Comment = htmlspecialchars($_POST['Comment']);
$Comment = trim($Comment, $character_mask = " \t\n\r\0\x0B");  // убипаем все лишние пробелы и переносы

$Comment_for_reports = $Comment; // Этот коммент пойдет в логи

if ($Comment != '') {
  $dateForComment = date('Y-m-d') . "(" . $user_login . "): "; // добавление в виде даты и логина пользователя
  $oldPerem = str_replace("@!" . $dateForComment, '', $my_id_arr[0]['Comment']); // удаляем 
  $Comment = "@!" . $dateForComment . $Comment . "||+ " . $oldPerem; // цепляем дату внесения комметнария
} else {
  $Comment = $my_id_arr[0]['Comment'];
}
// $Comment=htmlspecialchars($Comment);

$second_sell = $my_id_arr[0]['second_sell'];; // признак, что купили у нас


$DateNextCall = $_POST['DateNextCall'];
$KpCondition = $_POST['KpCondition'];
$KpSum = $_POST['KpSum'];
$FinishContract = $_POST['FinishContract'];
$Adress = htmlspecialchars($_POST['Adress']);
$dateContract = $_POST['dateContract'];
$procent_work = $_POST['procent_work'];
$dateFinishContract = $_POST['dateFinishContract'];
$today = date("Y-m-d");



//Проверяем если закупка закупка продана или закрыта, то добаляем дату продажи или закрытия;
if (($KpCondition == "Не требуется") || ($KpCondition == "Уже купили") || $FinishContract == 1) {
  $date_close = date('Y-m-d');
  $FinishContract = 1;
} else {
  $date_close = "";
}

if ($KpCondition == "Купили у нас") {
  $date_sell = date('Y-m-d'); // дата продажи
  $date_close = date('Y-m-d');
  $FinishContract = 1;
  $second_sell = 1; // признак, что купили у нас
} else {
  $date_sell = ""; // дата продажи
  // $second_sell = 0; // признак, что купили у нас
}

if ($KpCondition == "В работе") {
  $FinishContract = 0;
  $date_sell = "";
  $date_close = "";
}
if (($KpCondition == "") && ($FinishContract == 0)) {
  $FinishContract = 0;
  $date_sell = "";
  $date_close = "";
}
if (($KpCondition == "") && ($FinishContract == 1)) {
  $FinishContract = 1;
  $date_sell = "";
  $date_close = date('Y-m-d');
}


// Формируем АПдейт в БД
$data_arr = [
  'KpImportance'=> $KpImportance,
  'Responsible'=> $Responsible,
  'Comment'=> $Comment,
  'DateNextCall'=> $DateNextCall,
  'KpCondition'=> $KpCondition,
  'KpSum'=> $KpSum,
  'FinishContract'=> $FinishContract,
  'Adress' => $Adress,
  'dateContract'=> $dateContract,
  'date_sell'=> $date_sell,
  'date_close'=> $date_close,
  'date_write' => $today,
  'dateFinishContract'=> $dateFinishContract,
  'procent_work' => $procent_work, 
  'second_sell' => $second_sell, 
  'id' => $id,
];


$sql = "UPDATE reestrkp SET KpImportance=:KpImportance, 
                            Responsible =:Responsible,
                            Comment=:Comment,
                            DateNextCall=:DateNextCall,
                            KpCondition=:KpCondition,
                            KpSum=:KpSum,
                            FinishContract=:FinishContract,
                            adress=:Adress,
                            dateContract=:dateContract,
                            date_sell=:date_sell,
                            date_close=:date_close,
                            date_write=:date_write,
                            dateFinishContract=:dateFinishContract,
                            procent_work=:procent_work,
                            second_sell =:second_sell
                      WHERE id=:id";


$stmt= $pdo->prepare($sql);
$stmt->execute($data_arr);

// Формируем массив для возврата в AJAX  запрос
$backArr = array(
  "id" => $id,
  "KpImportance" => $KpImportance,
  "Responsible" => $Responsible,
  "Comment" => $Comment,
  "DateNextCall" => $DateNextCall,
  "KpCondition" => $KpCondition,
  "KpSum" => $KpSum,
  "FinishContract" => $FinishContract,
  "Adress" => $Adress,
  "dateContract" => $dateContract,
  "procent_work" => $procent_work,
  "dateFinishContract" => $dateFinishContract,
);

//  file_put_contents($file, $temp_var, FILE_APPEND | LOCK_EX); // логи по датам
//  file_put_contents($fileAll, $temp_var, FILE_APPEND | LOCK_EX); // Все логи подряд
//  file_put_contents($fileUser, $temp_var, FILE_APPEND | LOCK_EX); // Все логи подряд
//// Формируем комментарий в таблицу reports
$db_comment = "";
if ($my_id_arr[0]['Comment']  != $Comment) {
  $db_comment .= " коммент :" . $Comment_for_reports . ";";
}
if ($my_id_arr[0]['KpImportance'] != $KpImportance) {
  $db_comment .= "@! важность :" . $KpImportance . "||+";
}
if ($my_id_arr[0]['Responsible']  != $Responsible) {
  $db_comment .= "@! ответств :" . $Responsible . "||+";
}

if (($my_id_arr[0]['DateNextCall']  != $DateNextCall) && $DateNextCall != "") {
  $db_comment .= "@! дата сл.зв. :" . $DateNextCall . "||+";
}
if ($my_id_arr[0]['KpCondition']  != $KpCondition) {
  $db_comment .= "@! сост. КП :" . $KpCondition . "||+";
}
if ($my_id_arr[0]['KpSum']  != $KpSum) {
  $db_comment .= " Сумма КП :" . $KpSum . ";";
}
if (($my_id_arr[0]['dateContract']  != $dateContract) && $dateContract != "") {
  $db_comment .= " дата закл. конт. :" . $dateContract . ";";
}
if ($my_id_arr[0]['procent_work']  != $procent_work) {
  $db_comment .= " проц. вып. конт. :" . $procent_work . ";";
}
if (($my_id_arr[0]['dateFinishContract']  != $dateFinishContract) && $dateFinishContract != "") {
  $db_comment .= " дата окон. конт. :" . $dateFinishContract . ";";
}
if ($my_id_arr[0]['FinishContract']  != $FinishContract) {
  $db_comment .= "@! Закр. КП :" . $FinishContract . "||+";
}
if ($my_id_arr[0]['adress']  != $Adress) {
  $db_comment .= " Адрес :" . $Adress . ";";
}

/// добавляем запись в реестр изменени КП
$date_change = date("Y-m-d");
$id_item = $id;
$what_change = 1;
$comment_change = $db_comment; 
$author = $userdata['user_login'];
require "insert_reports.php";


/// ТУТ БУДЕТ ПРОВЕРКА КОМПАНИЙ, которые у нас покупали ранне,
// если признак купили у нас снимается, то и ранее подсвеченне 
$InnCustomer = $my_id_arr[0]['InnCustomer'];

// require "check_by_sell.php";

// unset($my_id_arr);
// header ("Location: ..?id=".$id);  // перенаправление на нужную страницу
// exit();    // прерываем работу скрипта, чтобы забыл о прошлом
echo json_encode($backArr, JSON_UNESCAPED_UNICODE);
