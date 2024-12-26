<?php
include_once 'functions/full_get.php'; // считваем все GET данные
include_once 'functions/form_select.php'; // Настраиваем SQL запрос

if ($_GET['overdue_type'] == 1) {
  $smarty->assign('text', 'Просроченные КП за СЕГОДНЯ');
$arr_overdue_kp =  select_overdue_kp_now($smarty, $pdo, $userdata['user_name']);
isset($arr_overdue_kp)?$kpCount = count($arr_overdue_kp): $kpCount =0;
}
if ($_GET['overdue_type'] == 2) {
  $smarty->assign('text', 'Просроченные КП за ВЕСЬ СРОК');
  $arr_overdue_kp =  select_overdue_kp_all($smarty, $pdo, $userdata['user_name']);
  isset($arr_overdue_kp)?$kpCount = count($arr_overdue_kp): $kpCount =0;
  }



$smarty->assign("kpCount", $kpCount);   // количество элементов

SetPageNumbers ($smarty, $arr_overdue_kp, $pageNumber);
SetParametrsTable ($smarty, $arr_overdue_kp);

include_once 'sub_programs/page_number.php'; // выводим номера страниц на таблице
// die();



$smarty->display('title_razdel.tpl');

$smarty->display('main_table.tpl'); // выводим данные о выбранном КП

include 'sub_programs/page_number.php'; // выводим номера страниц на таблице