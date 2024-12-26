<?php

// *************************  Выбор несколько КП по ID
if (@$_GET['ids'] <> ''){
$id_arr = explode(";", $_GET['ids']);
 
// выбираем все По ID по фильтру
foreach ($id_arr as $id_value) {

  $array_with_all_kp_temp1 = GetKPById($pdo,$id_value);
  $array_with_all_kp_temp[] = $array_with_all_kp_temp1[0];
}
    $get_FinishContract = 1; //   когда выводим по ID  то выводим и закрытые КП
    if (count($array_with_all_kp_temp) == '') {
    die (' НЕТ ДАННЫХ ДЛЯ ВЫВОДА КП по ID');
     }
// Выбор одного  КП по ID   
} elseif ($id <> '') {

  $array_with_all_kp_temp1 = GetKPById($pdo,$id);
  $array_with_all_kp_temp[] = $array_with_all_kp_temp1[0];

} 

else {
// выбираем все КП по фильтру

    $array_with_all_kp_temp = GetSelectedKP($pdo,$sql);
    if (count($array_with_all_kp_temp) == '') {
      // $smarty->assign('alarm_message', 'Нет КП по выбранным параметрам');
      // $smarty->assign('back_adress', 'Нет КП по выбранным параметрам');
      // $smarty->display('alarm_message.tpl');
    }
}

// echo "<pre>";
// print_r($array_with_all_kp_temp);
// echo "<pre>";




$i=0;
$i1=0;

foreach ($array_with_all_kp_temp as $value) {
  // ************* Проверяем нужно ли выводить закрытые КП *********************
  $Show_close_Contracts = $get_FinishContract;
  if (($array_with_all_kp_temp[$i1]['FinishContract'] == 1) && ($Show_close_Contracts <> 1) && ($id == ''))
  { 
    $i1++;
    continue;
  
  } else {
      $array_with_all_kp[$i] = $array_with_all_kp_temp[$i1];
      $i++;
      $i1++;
    }
  }

  // echo "<pre>";
  // print_r($array_with_all_kp);
  // echo "<pre>";

if (isset($array_with_all_kp)) {
SetPageNumbers ($smarty, $array_with_all_kp, $pageNumber);
SetParametrsTable ($smarty, $array_with_all_kp);

}
isset($array_with_all_kp)?$kpCount = count($array_with_all_kp): $kpCount =0;

$smarty->assign("kpCount", $kpCount);   // количество элементов

// **************************
