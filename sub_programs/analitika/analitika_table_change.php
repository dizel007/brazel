<?php

include_once 'functions/form_select_analitika.php'; // Настраиваем SQL запрос

$sql = setup_SQL_query_analitika ($get_responsible, $get_date_start, $get_date_end);

// находим всех активных пользователей за этот промежуток времени
$stmt = $pdo->prepare("SELECT author FROM reports $sql");
$stmt->execute([]);
$arr_users = $stmt->fetchAll(PDO::FETCH_COLUMN);

$arr_users = array_unique($arr_users, SORT_STRING);
$smarty->assign('arr_users' , $arr_users);

$stmt = $pdo->prepare("SELECT * FROM reports $sql");
$stmt->execute([]);
$arr_all_reports = $stmt->fetchAll(PDO::FETCH_ASSOC);





// echo "<pre>";
// print_r($arr_all_reports);
// echo "<pre>";
// die();

// формируем массив на каждого пользователя
foreach ($arr_users as $value){
  // if ($value == '') continue; // убираем косяк, когда нет пользователя **************************
  
   foreach ($arr_all_reports as $temp) {
          if ($value == $temp['author']) {
            // $arr_user["$value"][] = $temp;
// создаем массив с изменениями в КП
            if ($temp['what_change'] == 1) {
              $array_change_kp[] = $temp['id_item'];
               }
// создаем массив с изменениями ДАННЫХ в КП
      if ($temp['what_change'] == 12) {
        $array_change_data_kp[] = $temp['id_item'];
        }

// создаем массив с новыми КП   
            if ($temp['what_change'] == 8) {
              $array_new_kp[] = $temp['id_item'];
                 }
// создаем массив с новыми Компаниями   
                if ($temp['what_change'] == 9) {
                  $array_new_comp[] = $temp['id_item'];
                   }

// создаем массив с отправленными емайла  
            if ($temp['what_change'] == 7) {
              $array_send_mail[] = $temp['id_item'];
               }
  // создаем массив с изменениями в компании 
            if (($temp['what_change'] == 2) ||
                ($temp['what_change'] == 3) ||
                ($temp['what_change'] == 4) ||
                ($temp['what_change'] == 5) ||
                ($temp['what_change'] == 6) ) {
            $array_change_comp[] = $temp['id'];

              }

          }  
       }
// если есть данные, что юзер изменял КП, то пишем сколько КП изменилось для каждого пользователя
   if (isset ($array_change_kp))  {
    $kol_change_kp[$value] = count($array_change_kp);
    $kol_change_unique_kp[$value] = count(array_unique($array_change_kp, SORT_STRING));

    $arr_change_kp_user[$value] = implode(";",array_unique($array_change_kp, SORT_STRING)); // массив с ИД КП

    unset($array_change_kp); // удаляем для каждого пользователя
   }  else {
    $kol_change_kp[$value]=0;
    $kol_change_unique_kp[$value] =0;
   }

// если есть КП где **ИЗМЕНЯЛИСЬ ДАННЫЕ В КП**  то пишем сколько КП изменилось для каждого пользователя
if (isset ($array_change_data_kp))  {
  $kol_change_kp_data[$value] = count($array_change_data_kp);
  $kol_change_unique_kp_data[$value] = count(array_unique($array_change_data_kp, SORT_STRING));

  $arr_change_data_kp_user[$value] = implode(";",array_unique($array_change_data_kp, SORT_STRING)); // массив с ИД КП

  unset($array_change_data_kp); // удаляем для каждого пользователя
 }  else {
  $kol_change_kp_data[$value]=0;
  $kol_change_unique_kp_data[$value] =0;
 }




// если есть данные, что юзер создавал новые КП
if (isset ($array_new_kp))  {
  $kol_new_kp[$value] = count($array_new_kp);
  $arr_new_kp_user[$value] = implode(";",$array_new_kp); // массив с ИД КП
  unset($array_new_kp); // удаляем для каждого пользователя
 } else {
  $kol_new_kp[$value]=0;
 }

 // если есть данные, что юзер создавал новые компании
if (isset ($array_new_comp))  {
  $kol_new_comp[$value] = count($array_new_comp);
  unset($array_new_comp); // удаляем для каждого пользователя
 } else {
  $kol_new_comp[$value]=0;
 }
// если есть данные, что юзер отправлял письма с сайта, то пишем сколько раз отправил каждый юзер
if (isset ($array_send_mail))  {
  $kol_send_mail[$value] = count($array_send_mail);
  // $array_send_mail_user[$value] = implode(";",$array_send_mail); // массив с ИД отправленных писем
  unset($array_send_mail); // удаляем для каждого пользователя
 } else {
  $kol_send_mail[$value]=0;
 }
// если есть данные, что юзер изменял данные о компании, то пишем сколько изменений сделал каждый пользователб
if (isset ($array_change_comp))  {
  $kol_change_comp[$value] = count($array_change_comp);
  $array_change_comp_user[$value] = implode(";",array_unique($array_change_comp, SORT_STRING)); // массив с ИД КП

  unset($array_change_comp); // удаляем для каждого пользователя
 } else {
  $kol_change_comp[$value]=0;
 }
}


// отправляем количество КП с изменениями индекс сотрудник 
$smarty->assign('kol_change_kp', @$kol_change_kp);
$smarty->assign('arr_change_kp_user', @$arr_change_kp_user);

// отправляем количество КП в которых были ИЗМЕНЕНЫ ДАННЫЕ индекс сотрудник 
$smarty->assign('kol_change_unique_kp_data', @$kol_change_unique_kp_data);
$smarty->assign('arr_change_data_kp_user', @$arr_change_data_kp_user);


// отправляем количество новых КП индекс сотрудник 
$smarty->assign('kol_new_kp', @$kol_new_kp);
$smarty->assign('arr_new_kp_user', @$arr_new_kp_user);


// отправляем количество созданных новых компаний индекс сотрудник 
$smarty->assign('kol_new_comp', @$kol_new_comp);




// отправляем количество уникальных КП с изменениями--  индекс сотрудник 
$smarty->assign('kol_change_unique_kp', @$kol_change_unique_kp);
// отправляем количество отправленных емацлов  индекс сотрудник 
$smarty->assign('kol_send_mail', @$kol_send_mail);
// отправляем количество изменений данных о компаний с изменениями индекс сотрудник 
$smarty->assign('kol_change_comp', @$kol_change_comp);
$smarty->assign('array_change_comp_user', @$array_change_comp_user);

// echo "<pre>";
// print_r($kol_change_unique_kp_data);
// echo "<pre>";
// die();
