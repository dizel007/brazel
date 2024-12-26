<?php
// ************************** Тут купленных КП за период **********************

$sql ="";
$where = "";
  $where = addWhere($where, "FinishContract=1");
  $where = addWhere($where, "KpCondition <>'Купили у нас'");
  if ($get_date_start<>'') $where = addWhere($where, "date_close >='".$get_date_start."'");
  if ($get_date_end<>'') $where = addWhere($where, "date_close <='".$get_date_end."'");
  if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
    else {
  $sql .= "AND ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
      }


// Вычитываем все проданные за Период КП
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` $sql");
$stmt->execute([]);
$arr_all_close = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($arr_all_close);
// echo "<pre>";

// die();
// разбиваем все по пользователям
foreach ($active_user_login as $value){
   $key = key($active_user_login); // перебираем всех пользователей по ключу
   foreach ($arr_all_close as $temp) {
  if ($value == $temp['Responsible']) {
    // die();
       // считаем количество закрыт  КП за период 
       // делаем сортировку по типу закрытия 
        if ($temp['KpCondition'] == 'Уже купили') {
          $array_close_kp[$key]['idKp_alr_buy'] = @$array_close_kp[$key]['idKp_alr_buy'].$temp['id'].";"; // количество 
          $array_close_kp[$key]['KpCount_alr_buy'] = @$array_close_kp[$key]['KpCount_alr_buy'] + 1; // количество 

        } elseif ($temp['KpCondition'] == 'Не требуется'){
          $array_close_kp[$key]['idKp_not_need'] = @$array_close_kp[$key]['idKp_not_need'].$temp['id'].";"; // количество 
          $array_close_kp[$key]['KpCount_not_need'] = @$array_close_kp[$key]['KpCount_not_need'] + 1; // количество 
        } else {
            $array_close_kp[$key]['idKp_not_know'] = @$array_close_kp[$key]['idKp_not_know'].$temp['id'].";"; // количество 
           $array_close_kp[$key]['KpCount_not_know'] = @$array_close_kp[$key]['KpCount_not_know'] + 1; // количество 
        }
    }
  } 
next($active_user_login);      
}  // Конец перебора пользователей 





// Формируем массив ИТОГО 

if (isset($array_close_kp)){
  foreach ($array_close_kp as $value) {
    @$itog_close_kp['KpCount_alr_buy'] = $itog_close_kp['KpCount_alr_buy'] + $value['KpCount_alr_buy'];
    @$itog_close_kp['KpCount_not_need'] = $itog_close_kp['KpCount_not_need'] + $value['KpCount_not_need'];
    @$itog_close_kp['KpCount_not_know'] = $itog_close_kp['KpCount_not_know'] + $value['KpCount_not_know'];

    @$itog_close_kp['idKp_alr_buy'] = $itog_close_kp['idKp_alr_buy'].$value['idKp_alr_buy'];
    @$itog_close_kp['idKp_not_need'] = $itog_close_kp['idKp_not_need'].$value['idKp_not_need'];
    @$itog_close_kp['idKp_not_know'] = $itog_close_kp['idKp_not_know'].$value['idKp_not_know'];
   }
   $itog_close_kp['idKp_alr_buy']  = rtrim($itog_close_kp['idKp_alr_buy'],';');
   $itog_close_kp['idKp_not_need'] = rtrim($itog_close_kp['idKp_not_need'],';');
   $itog_close_kp['idKp_not_know'] = rtrim($itog_close_kp['idKp_not_know'],';');
   

  }
  // echo "<pre>";
  // var_dump($array_close_kp);
  // echo "<pre>";
  // die();


  // echo ($itog_sold_kp['idKp']);

// die();
//  if (isset($array_sold_kp_text))

// Удаляем последний ";" из перечня КП
if (isset($array_close_kp)){
foreach ($array_close_kp as $value1) {
  $value1['idKp_alr_buy'] = rtrim(@$value1['idKp_alr_buy'],';');
  $value1['idKp_not_need'] = rtrim(@$value1['idKp_not_need'],';');
  $value1['idKp_not_know'] = rtrim(@$value1['idKp_not_know'],';');
  
 }
}
 
// echo "<pre>";
// var_dump($array_close_kp);
// echo "<pre>";
    
$smarty->assign('array_close_kp', @$array_close_kp);   
$smarty->assign('itog_close_kp', @$itog_close_kp);       
      
