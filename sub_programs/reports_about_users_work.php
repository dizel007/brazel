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
include_once 'functions/form_select.php'; // Настраиваем SQL запрос


$smarty->assign('transitionForForm' , 71); //  Задаем тип перехода при нажатии на кнопки обновить
$smarty->display('info_filtr.tpl');
/* Данные для ввода даты в шаблинизатор  */
($get_date_start=='')?$get_date_start=$now: $get_date_start=$get_date_start;
($get_date_end=='')?$get_date_end=$now: $get_date_end=$get_date_end;
$smarty->assign('get_date_start', $get_date_start);
$smarty->assign('get_date_end', $get_date_end);

// echo "<pre>";
// print_r($arr_users);
// echo "<pre>";

// ************************** Тут купленных КП за период **********************

$sql ="";
$where = "";
 
  if ($get_responsible <>'') $where = addWhere($where, "Responsible = '".$get_responsible."'");
  if ($get_type_kp     <>'') $where = addWhere($where, "type_kp = '".$get_type_kp."'");
  if ($get_date_start  <>'') $where = addWhere($where, "KpData >='".$get_date_start."'");
  if ($get_date_end    <>'') $where = addWhere($where, "KpData <='".$get_date_end."'");
  if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
    else {
  $sql .= "AND ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
      }

// Вычитываем все проданные за Период КП
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` $sql");
$stmt->execute([]);
$arr_all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<pre>";
// print_r($arr_all_reports);

// Если есть хоть одно КП то начинаем формировать массивы
if(isset($arr_all_reports)){
    // Массивы по каждому сотруднику
foreach ($arr_all_reports as $item) {
    $arr_users_works[$item['Responsible']][] = $item;
    unset($item);
}
if(isset($arr_users_works)){
// Обработанный массивы по каждому сотруднику
foreach ($arr_users_works as $user=>$arr_users) {
    $user == ''? $user ='не назначен':$user =$user ;
    $arr_full_user_info[$user]['close_kp'] = 0;
    $arr_full_user_info[$user]['kp_one_million'] = 0;
    $arr_full_user_info[$user]['kp_three_million'] = 0;
    $summa_all_kp = 0;
    foreach ($arr_users as $arr_kp_data) {
        
        $arr_full_user_info[$user]['count_kp'] = @$arr_full_user_info[$user]['count_kp'] + 1;
        $arr_full_user_info[$user]['summa_al_kp'] = @$arr_full_user_info[$user]['summa_al_kp'] + $arr_kp_data['KpSum'];
        // количество закрытых КП 
        if ($arr_kp_data['FinishContract'] == 1) {
            $arr_full_user_info[$user]['close_kp'] = $arr_full_user_info[$user]['close_kp'] + 1;
        }

        // количество КП больше 1 млн
        if (($arr_kp_data['KpSum'] >= 1000000) && ($arr_kp_data['KpSum'] < 3000000)){
            $arr_full_user_info[$user]['kp_one_million'] = $arr_full_user_info[$user]['kp_one_million'] + 1;
            $arr_kp_1_mln[] = $arr_kp_data['id'];
        }
        // количество КП больше 3 млн
        if ($arr_kp_data['KpSum'] >= 3000000){
            $arr_full_user_info[$user]['kp_three_million'] = $arr_full_user_info[$user]['kp_three_million'] + 1;
            $arr_kp_3_mln[] = $arr_kp_data['id'];
        }
                

        $arr_kp[] = $arr_kp_data['id'];

     }  
     $arr_full_user_info[$user]['id'] = implode( ';', $arr_kp); //  список ID кп каждого польвателя
     isset($arr_kp_1_mln)?$arr_full_user_info[$user]['id_1_mln'] = implode( ';', $arr_kp_1_mln):$arr_full_user_info[$user]['id_1_mln']='' ;//  список ID кп каждого польвателя
     isset($arr_kp_3_mln)?$arr_full_user_info[$user]['id_3_mln'] = implode( ';', $arr_kp_3_mln):$arr_full_user_info[$user]['id_3_mln']='' ;//  список ID кп каждого польвателя

     unset($arr_kp);
     unset($arr_kp_1_mln);
     unset($arr_kp_3_mln);

}
//
}
}
// print_r($arr_full_user_info);
// print_r($arr_users_works);

// die();

   
$smarty->assign('arr_full_user_info', @$arr_full_user_info);   
$smarty->display('table_reports_users_work.tpl');
       

