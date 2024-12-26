<?php

include_once 'functions/full_get.php'; // считваем все GET данные
// костыль для вывода закрытых КП
if (($get_KpCondition == 'Купили у нас') OR
   ($get_KpCondition == 'Не требуется')  OR 
   ($get_KpCondition == 'Уже купили')  ) 
   {
  $get_FinishContract = 1;
  }

// костыль чтобы через фильтр выводились и закрытые КП при выводе черещ ИНН компании
if (($get_inn <>'' ) OR ($get_nomerKP <>'') or ($get_name_zakazchik<>'')){
  $get_FinishContract = 1;
}
include_once 'functions/form_select.php'; // Настраиваем SQL запрос


if (isset($get_type_kp)) {
$get_value_type_kp = GetOneValueKptype($pdo,$get_type_kp);
$smarty->assign('get_value_type_kp', $get_value_type_kp);
} else {
  $smarty->assign('get_value_type_kp', '');  
}

$smarty->assign('transitionForForm', 7); //  Задаем тип перехода при нажатии на кнопки обновить
$smarty->display('info_filtr.tpl');

include_once 'functions/setup_param_main_table.php'; // настраиваем всек данные для шаблона
include_once 'sub_programs/page_number.php'; // выводим номера страниц на таблице



$smarty->display('info_setup_filtr.tpl');
if ($kpCount == 0) { // Если нет КП по фильтру по выводим ошибку
  $smarty->assign('alarm_message', 'Нет КП по выбранным параметрам, возможно КП уже закрыто');
      $smarty->assign('back_adress', $_SERVER['HTTP_REFERER']);
      $smarty->display('alarm_message.tpl');
} else { // если есть хоть 1 КП, то выводим его
  $smarty->display('main_table.tpl');
  include 'sub_programs/page_number.php'; // выводим номера страниц на таблице
}
