<?php
// ************************** Тут купленных КП за период **********************

$sql ="";
$where = "";
 
  if ($get_responsible <>'') $where = addWhere($where, "Responsible = '".$get_responsible."'");
  if ($get_type_kp <>'') $where = addWhere($where, "type_kp = '".$get_type_kp."'");
  if ($get_date_start<>'') $where = addWhere($where, "date_sell >='".$get_date_start."'");
  if ($get_date_end<>'') $where = addWhere($where, "date_sell <='".$get_date_end."'");
  if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
    else {
  $sql .= "AND ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
      }

// Вычитываем все проданные за Период КП
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` $sql");
$stmt->execute([]);
$arr_all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// разбиваем все по пользователям
foreach ($active_user_login as $value){
   $key = key($active_user_login); // перебираем всех пользователей по ключу
   foreach ($arr_all_reports as $temp) {
  if ($value == $temp['Responsible']) {
       // считаем количество проданных ОБЪЕКТНЫХ КП за период 
      $array_sold_kp[$key]['KpSum'] = @$array_sold_kp[$key]['KpSum'] + $temp['KpSum']; // количество 
  if (($temp['KpCondition'] == 'Купили у нас') and ($temp['type_kp'] == 6))     {
      $array_sold_kp[$key]['idKp_obj'] = @$array_sold_kp[$key]['idKp_obj'].$temp['id'].";"; // количество 
      $array_sold_kp[$key]['KpSum_obj'] = @$array_sold_kp[$key]['KpSum_obj'] + $temp['KpSum']; // количество 
      $array_sold_kp[$key]['KpCount_obj'] = @$array_sold_kp[$key]['KpCount_obj'] + 1; // количество 
  }
// считаем количество проданных НЕобъЕКТНЫХ КП за период 
    if (($temp['KpCondition'] == 'Купили у нас') and ($temp['type_kp'] <> 6))     {
      $array_sold_kp[$key]['idKp_other'] = @$array_sold_kp[$key]['idKp_other'].$temp['id'].";"; // количество 
      $array_sold_kp[$key]['KpSum_other'] = @$array_sold_kp[$key]['KpSum_other'] + $temp['KpSum']; // количество 
      $array_sold_kp[$key]['KpCount_other'] = @$array_sold_kp[$key]['KpCount_other'] + 1; // количество 
      
    }

   }
  } 
  
       next($active_user_login);      
}  // Конец перебора пользователей 

// Формируем массив ИТОГО 

if (isset($array_sold_kp)){
  foreach ($array_sold_kp as &$value) {
    @$itog_sold_kp['KpCount_obj'] = $itog_sold_kp['KpCount_obj'] + $value['KpCount_obj'];
    @$itog_sold_kp['Summa_obj'] = $itog_sold_kp['Summa_obj'] + $value['KpSum_obj'];
    @$itog_sold_kp['idKp_obj'] = $itog_sold_kp['idKp_obj'].$value['idKp_obj'];

    @$itog_sold_kp['KpCount_other'] = $itog_sold_kp['KpCount_other'] + $value['KpCount_other'];
    @$itog_sold_kp['Summa_other'] = $itog_sold_kp['Summa_other'] + $value['KpSum_other'];
    @$itog_sold_kp['idKp_other'] = $itog_sold_kp['idKp_other'].$value['idKp_other'];

    @$itog_sold_kp['Summa'] = $itog_sold_kp['Summa'] + $value['KpSum'];
   }
   $itog_sold_kp['idKp_obj'] = rtrim($itog_sold_kp['idKp_obj'],';');
   $itog_sold_kp['idKp_other'] = rtrim($itog_sold_kp['idKp_other'],';');
   

  }



  // echo ($itog_sold_kp['idKp']);
// echo "<pre>";
// print_r($array_sold_kp);
// echo "<pre>";
//  if (isset($array_sold_kp_text))

// Удаляем последний ";" из перечня КП
if (isset($array_sold_kp)){
foreach ($array_sold_kp as &$value) {
  $value['idKp_obj'] = rtrim(@$value['idKp_obj'],';');
  $value['idKp_other'] = rtrim(@$value['idKp_other'],';');
 }
}
 
    
$smarty->assign('array_sold_kp', @$array_sold_kp);   
$smarty->assign('itog_sold_kp', @$itog_sold_kp);       
       

