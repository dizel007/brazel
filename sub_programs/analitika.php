<?php
$now=date('Y-m-d');
$smarty->assign('now' , $now);
$yesturday = date('Y-m-d', strtotime($now . '-1 day'));
$smarty->assign('yesturday' , $yesturday);
$last_week = date('Y-m-d', strtotime($now . '-7 day'));
$smarty->assign('last_week' , $last_week);
$last_month = date('Y-m-d', strtotime($now . '-30 day'));
$smarty->assign('last_month' , $last_month);
$last_kvartal = date('Y-m-d', strtotime($now . '-90 day'));
$smarty->assign('last_kvartal' , $last_kvartal);

include_once 'functions/full_get.php'; // считваем все GET данные

/* Данные для ввода даты в шаблинизатор  */
($get_date_start=='')?$get_date_start=$now: $get_date_start=$get_date_start;
($get_date_end=='')?$get_date_end=$now: $get_date_end=$get_date_end;
$smarty->assign('get_date_start', $get_date_start);
$smarty->assign('get_date_end', $get_date_end);

// echo "<pre>";
// print_r($arr_users);
// echo "<pre>";

// Достаем все изменения за выбранный период
include_once "analitika/analitika_table_change.php"; // тут формируются данные для таблицы с изменениями (АНАЛИТИКА)

// Достаем все закрытые КП за выбранный период
include_once "analitika/analitika_close_kp.php"; // 

// Достаем все проданные КП за выбранный период
include_once "analitika/analitika_sold_kp.php"; // 


$smarty->display('analitika/analitika.tpl');

