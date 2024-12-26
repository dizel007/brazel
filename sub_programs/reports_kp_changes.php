<?php
$get_FinishContract =1; // ставим 1 чтобы выбрать все КП в том числе закрытые
include_once 'functions/form_select.php'; // Настраиваем SQL запрос

$stmt = $pdo->prepare("SELECT * FROM `reestrkp` $sql");
$stmt->execute([]);
$arr_all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);


// echo "<pre>";
// print_r($arr_all_reports);
// echo "<pre>";



// ****************** Тут делаем выборку КП по дате созжания  ***************

foreach ($active_user_names_arr_smarty as $value){
  foreach ($arr_all_reports as $temp) {
         if ($value == $temp['Responsible']) {
        // считаем количество новых КП за период
                   $array_new_kp[] = $temp['id'];
        // считаем количество новых КП за период не взятых в работу
                  if (($temp['FinishContract']  == '0') && ($temp['KpCondition'] == ''))  {
                    $array_new_kp_need_wowk[] = $temp['id'];
                  }
        // считаем количество новых КП за период взятых в работу
                  if (($temp['FinishContract']  == '0') && ($temp['KpCondition'] == 'В работе'))     {
                    $array_new_kp_work[] = $temp['id'];
                  }
        // считаем количество просроченных КП за период 
                  if (($temp['DateNextCall'] <> '0000-00-00') && ($temp['DateNextCall'] <= $now))     {
                    $array_needcall_kp[] = $temp['id'];
                   }
        // считаем количество закрытых КП за период 
                  if (($temp['FinishContract']  == '1') && ($temp['KpCondition'] <> 'Купили у нас'))     {
                    $array_close_kp_period[] = $temp['id'];
                    }

                  }
         }  
      
// новые КП для каждого пользователя
      if (isset ($array_new_kp))  {
      $kol_new_kp[$value] = count($array_new_kp);
      unset($array_new_kp); // удаляем для каждого пользователя
      }  else {
      $kol_new_kp[$value]=0;
      }

    

// новые КП, которые не взялив работу для каждого пользователя
    if (isset ($array_new_kp_need_wowk))  {
      $kol_new_kp_need_work[$value] = count($array_new_kp_need_wowk);
      unset($array_new_kp_need_wowk); // удаляем для каждого пользователя
    }  else {
      $kol_new_kp_need_work[$value]=0;
    }
// просолченные КП,  для каждого пользователя
if (isset ($array_needcall_kp))  {
  $kol_needcall_kp[$value] = count($array_needcall_kp);
  unset($array_needcall_kp); // удаляем для каждого пользователя
}  else {
  $kol_needcall_kp[$value]=0;
}
// КП которые взяли в работу для каждого пользователя за период
    if (isset ($array_new_kp_work))  {
      $kol_new_kp_work[$value] = count($array_new_kp_work);
      unset($array_new_kp_work); // удаляем для каждого пользователя
    }  else {
      $kol_new_kp_work[$value]=0;
    }

// КП зыкрытые для каждого пользователя за период
    if (isset ($array_close_kp_period))  {
      $kol_close_kp_period[$value] = count($array_close_kp_period);
      unset($array_close_kp_period); // удаляем для каждого пользователя
    }  else {
      $kol_close_kp_period[$value]=0;
    }

}

// echo "<pre>";
// print_r($array_new_kp_need_wowk);
// echo "<pre>";
// die();






// отправляем количество новых КП с изменениями индекс сотрудник 
$smarty->assign('kol_new_kp', @$kol_new_kp);
// отправляем количество новых КП не взятых в работу с изменениями индекс сотрудник 
$smarty->assign('kol_new_kp_need_work', @$kol_new_kp_need_work);
// отправляем количество новых КП не взятых в работу с изменениями индекс сотрудник 
$smarty->assign('kol_new_kp_work', @$kol_new_kp_work);
// отправляем количество просроченных КП за период с изменениями индекс сотрудник 
$smarty->assign('kol_needcall_kp', @$kol_needcall_kp);
// отправляем количество закрытых КП за период с изменениями индекс сотрудник 
$smarty->assign('kol_close_kp_period', @$kol_close_kp_period);

// ************************** Тут купленных КП за период **********************

$sql ="";
$where = "";
  if ($get_FinishContract  == '0') $where = addWhere($where, "FinishContract =".$get_FinishContract);

  if ($get_responsible <>'') $where = addWhere($where, "Responsible = '".$get_responsible."'");
  
  if ($get_type_kp <>'') $where = addWhere($where, "type_kp = '".$get_type_kp."'");
  
  if ($get_date_start<>'') $where = addWhere($where, "date_sell >='".$get_date_start."'");

  if ($get_date_end<>'') $where = addWhere($where, "date_sell <='".$get_date_end."'");

if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
else {
  $sql .= " ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
}

$stmt = $pdo->prepare("SELECT * FROM `reestrkp` $sql");
$stmt->execute([]);
$arr_all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($arr_all_reports);
// echo "<pre>";
// die();

foreach ($active_user_names_arr_smarty as $value){
  foreach ($arr_all_reports as $temp) {
         if ($value == $temp['Responsible']) {
        // считаем количество проданных КП за период 
                    if ($temp['KpCondition'] == 'Купили у нас')     {
                      $array_sold_kp[] = $temp['id']; // количество проданнных КП по юзерам
                      $perem_sum_sold_kp = @$perem_sum_sold_kp + $temp['KpSum']; // сумма прод КП по юзерам
                      //Тут создаим массив с 
                    }
        // считаем сумму проданных КП за период 
                    if ($temp['KpCondition'] == 'Купили у нас')     {
                      
                    }



                  }
         } 
   // КП которые продали каждого пользователя за период
   if (isset ($array_sold_kp))  {
    $kol_sold_kp[$value] = count($array_sold_kp);
    unset($array_sold_kp); // удаляем для каждого пользователя
  }  else {
    $kol_sold_kp[$value]=0;
  }
// Сумма проданных КП для  каждого пользователя за период
  if (isset ($perem_sum_sold_kp))  {
    $sum_sold_kp[$value] = $perem_sum_sold_kp;
    unset($perem_sum_sold_kp); // удаляем для каждого пользователя
  }  else {
    $sum_sold_kp[$value]=0;
  }
   
} // конец цикла по перебору юзеров





// отправляем количество проданных КП с изменениями индекс сотрудник 
$smarty->assign('kol_sold_kp', @$kol_sold_kp);

// отправляем сумму проданных КП с изменениями индекс сотрудник 
$smarty->assign('sum_sold_kp', @$sum_sold_kp);


