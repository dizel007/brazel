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

$sql ="";
$where = "";
// if ($typeQuery <> '') {
  if ($get_date_sell_start <>'') $where = addWhere($where, "date_sell >='".$get_date_sell_start."'");
  if ($get_date_sell_end <>'') $where = addWhere($where, "date_sell <='".$get_date_sell_end."'");


  if ($get_FinishContract  == '0') $where = addWhere($where, "FinishContract =".$get_FinishContract);

  if ($get_nomerKP <>'') $where = addWhere($where, "KpNumber =".$get_nomerKP);
  
  if ($get_inn <> '' ) $where = addWhere($where, "InnCustomer =".$get_inn);

  if ($get_responsible <>'') $where = addWhere($where, "Responsible = '".$get_responsible."'");

  if ($get_id_kp <>'') $where = addWhere($where, "idKp = '".$get_id_kp."'");
 
  if ($get_type_kp <>'') $where = addWhere($where, "type_kp = '".$get_type_kp."'");
  
  if ($get_product_type <>'') $where = addWhere($where, "type_product = '".$get_product_type."'");

  if ($get_KpCondition <>'') $where = addWhere($where, "KpCondition = '".$get_KpCondition."'");
  
  if ($get_name_zakazchik <>'') $where = addWhere($where, "NameCustomer like '%".$get_name_zakazchik."%'");
  
  if ($get_adres_postavki <>'') $where = addWhere($where, "adress like '%".$get_adres_postavki."%'");

  if ($get_date_start<>'') $where = addWhere($where, "KpData >='".$get_date_start."'");

  if ($get_date_end<>'') $where = addWhere($where, "KpData <='".$get_date_end."'");

  // }
if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
else {
  $sql .= " ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
}



$sql =" WHERE KpData > '2023-01-01' AND KpSum > 200000 AND type_product = 1 AND 
        (adress LIKE 'красноя%' 
    OR  adress LIKE 'новосиб%'
    OR  adress LIKE 'владивос%'
    OR  adress LIKE 'екатерин%'
    OR  adress LIKE 'свердлов%'
    OR  adress LIKE 'братск%'
    OR  adress LIKE 'кемерово%'
    OR  adress LIKE 'кузбас%'
    OR  adress LIKE 'омск%'
    OR  adress LIKE 'хмао%'
    OR  adress LIKE 'янао%'
    OR  adress LIKE 'тюмен%'
    OR  adress LIKE 'иркутск%'
    OR  adress LIKE 'саха%'
    OR  adress LIKE 'благовещ%'
    OR  adress LIKE 'хабаров%'
    OR  adress LIKE 'удэ%'
    OR  adress LIKE 'челяб%'
    OR  adress LIKE 'ханты%'
    OR  adress LIKE 'уренгой%'
    OR  adress LIKE 'бийск%'
    OR  adress LIKE 'бийск%'

    OR  adress LIKE 'курган%')
    
    
    ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";












if (isset($get_type_kp)) {
$get_value_type_kp = GetOneValueKptype($pdo,$get_type_kp);
$smarty->assign('get_value_type_kp', $get_value_type_kp);
} else {
  $smarty->assign('get_value_type_kp', '');  
}
$smarty->display('info_filtr.tpl');

include_once 'functions/setup_param_main_table.php'; // настраиваем всек данные для шаблона
include_once 'sub_programs/page_number.php'; // выводим номера страниц на таблице



$smarty->display('info_setup_filtr.tpl');
if ($kpCount == 0) { // Если нет КП по фильтру по выводим ошибку
  $smarty->assign('alarm_message', 'Нет КП по выбранным параметрам, возможно КП уже закрыто');
    //   $smarty->assign('back_adress', $_SERVER['HTTP_REFERER']);
    //   $smarty->display('alarm_message.tpl');
} else { // если есть хоть 1 КП, то выводим его
  $smarty->display('main_table.tpl');
  include 'sub_programs/page_number.php'; // выводим номера страниц на таблице
}
