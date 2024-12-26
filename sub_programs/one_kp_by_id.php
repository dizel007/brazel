<?php
include_once 'functions/full_get.php'; // считваем все GET данные
include_once 'functions/form_select.php'; // Настраиваем SQL запрос
$smarty->display('info_filtr.tpl');
include_once 'functions/setup_param_main_table.php'; // настраиваем всек данные для шаблона
// $smarty->display('info_setup_filtr.tpl');

$smarty->assign('text', 'Информация о КП');
$smarty->display('title_razdel.tpl');

$smarty->display('main_table.tpl'); // выводим данные о выбранном КП


$InnCustomer = $array_with_all_kp[0]['InnCustomer']; // Получили ИНН компании из выбранного КП
$company_arr = GetCompanyByInn($pdo, $InnCustomer); // Получили все данные о компании
$smarty->assign("company_arr",$company_arr);

$telephons_company = GetTelephoneByInn($pdo,$InnCustomer); //Получили все телефоны о компании с таким ИНН

foreach ($telephons_company as &$valueZZ) {
 $valueZZ['whatsapp_tel'] = preg_replace("/[^,.0-9]/", '', $valueZZ['telephone']);
}
$smarty->assign("telephons_company",$telephons_company);

$emails_company = GetEmailByInn($pdo,$InnCustomer); //Получили все email о компании с таким ИНН
$smarty->assign("emails_company",$emails_company);

// отображает информацию о компании только если есть ИНН
if (isset($company_arr[0])) {
  $smarty->display('company_table.tpl'); 

// ***** Если есть ИНН ,Получаем остальные КП по ИНН и убирааем ранее выведенное 
  $KpByInn_temp = GetKPByInn($pdo,$InnCustomer);
  foreach ($KpByInn_temp as $value) {
    if ($value['id'] != $id) {
      $KpByInn[] = $value;
    }
  }

    if (isset($KpByInn)) {
   $smarty->assign('text', 'Остальные КП высланные в эту компанию');
   $smarty->display('title_razdel.tpl');

      SetParametrsTable($smarty, $KpByInn);
      $KpCount = count($KpByInn); // количество выводимых КП
      $end_item_on_page =   $KpCount-1; // вывод неачинается с 0 
      $smarty->assign("end_item_on_page", $end_item_on_page);
      $smarty->display('main_table.tpl'); // выводим данные о выбранном КП
    }
}