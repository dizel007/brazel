<?php
$arr_send_for_poisk = array(
  'what_find_perem' => 'search_telephone',
  'what_find' => 'Поиск по телефону',
  'transition' => 81,
);

$smarty->assign('arr_send_for_poisk', $arr_send_for_poisk);
$smarty->display('poiski/poisk_phone_or_email.tpl');

//113-76-94
if (isset($_GET['search_telephone'])) {
 //  $search_telephone=substr(preg_replace("/[^,.0-9]/", '', $_GET['search_telephone']),1);
   $search_telephone=htmlspecialchars(preg_replace("/[^,.0-9]/", '', $_GET['search_telephone']));


// ЕСЛИ вернулись в форму уже с номером телефона
if (strlen($search_telephone) >= 4 ) {

  //  $search_telephone=substr(preg_replace("/[^,.0-9]/", '', $_GET['search_telephone']),1);
  //  $search_telephone=htmlspecialchars(preg_replace("/[^,.0-9]/", '', $_GET['search_telephone']));
    
      
            
    

      // если введен полный номер, то впереди ставим 7 (принудительно)
   if (strlen($search_telephone) == 11) {
   $search_telephone=substr( $search_telephone,1);
  //  $search_telephone = "7". $search_telephone;
  }



     // Ищем ИНН к которму привящан телефн
   $stmt = $pdo->prepare("SELECT telephone, inn FROM telephone");
   $stmt->execute([]);
   $arr_tel = $stmt->fetchAll(PDO::FETCH_ASSOC);


$i=0;
   foreach ($arr_tel as &$value) {
    $priz_inn=0; // признак, что такой ИНН уже есть в массиве, и нет смыслв еще раз его добавлять
    
     $value_new['telephone'] = "***".(preg_replace("/[^,.0-9]/", '', $value['telephone']))."***"; 
     
     if  (strpos($value_new['telephone'], $search_telephone)) {

      // Проверяем может уже есть такой ИНН в массие 
      if (isset($search_arr_phone)) {
         foreach ($search_arr_phone as $temp_inn)
         {
            if ($value['inn'] == $temp_inn['inn']) {
              $priz_inn=1;
                          
            }
         } 
        }
        // если ИНН нет то добавим его
if ($priz_inn <> 1 ) {
  $search_arr_phone[$i]['inn'] = $value['inn'];
  $search_arr_phone[$i]['search_phone_number'] = $value['telephone'];

  
}

      }


  $i++;
}
    
// ******************************  проверяем ечли ли хоть одна компания с таким номером
if (isset($search_arr_phone)) { 
// Начинаем делать выборку по ИНН  компании с похожим телефоном 
$i=0;
foreach ($search_arr_phone as $value)  {
    // echo $value['search_phone_number']."<br>";
    $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = ?");
    $stmt->execute([$value['inn']]);

    $arr_seacrh_comp_tel = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arr_seacrh_comp_tel[0]['search_phone_number'] = $value['search_phone_number'];
// убираем лишнюю вложенность массива    
    $arr_seacrh_comp_tel = call_user_func_array('array_merge', $arr_seacrh_comp_tel);


    $arr_seacrh_comp_tel_t[$i] = $arr_seacrh_comp_tel;
$i++;
}


// $arr_seacrh_comp_tel_t = call_user_func_array('array_merge', $arr_seacrh_comp_tel);

// echo "<pre>" ;
// var_dump($arr_seacrh_comp_tel_t);
// echo "<pre>" ;
$smarty->assign('search_telephone', $_GET['search_telephone']);
$smarty->assign('arr_seacrh_comp_tel_t', $arr_seacrh_comp_tel_t);
$smarty->display('poiski/find_company_by_telephone.tpl');
} else {
  $smarty->assign('alarm_message_text', "Телефонный номер по запросу ".$search_telephone. " не найден");
  $smarty->display('poiski/alarm_message.tpl');

}
} else {
  
  $smarty->assign('alarm_message_text', 'Запрос слишком короткий, минимум 4 цифры в запросе');
  $smarty->display('poiski/alarm_message.tpl');

  
}
}

// $arr_send_for_poisk = array(
//   'what_find_perem' => 'search_telephone',
//   'what_find' => 'Поиск по телефону',
//   'transition' => 81,
// );

// $smarty->assign('arr_send_for_poisk', $arr_send_for_poisk);
// $smarty->display('poiski/poisk_phone_or_email.tpl');

