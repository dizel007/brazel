<?php
$arr_send_for_poisk = array(
    'what_find_perem' => 'search_email',
    'what_find' => 'Поиск по email',
    'transition' => 82,
);

$smarty->assign('arr_send_for_poisk', $arr_send_for_poisk);
$smarty->display('poiski/poisk_phone_or_email.tpl');


//113-76-94
if (isset($_GET['search_email'])) {
 //  $search_telephone=substr(preg_replace("/[^,.0-9]/", '', $_GET['search_telephone']),1);
   $search_email=htmlspecialchars($_GET['search_email']);


// ЕСЛИ вернулись в форму уже с номером телефона
if (strlen($search_email) >= 3 ) {

     // Ищем ИНН к которму привящан телефн
   $stmt = $pdo->prepare("SELECT email, inn FROM email");
   $stmt->execute([]);
   $arr_email = $stmt->fetchAll(PDO::FETCH_ASSOC);

$i=0;
   foreach ($arr_email as &$value) {
    $priz_inn=0; // признак, что такой ИНН уже есть в массиве, и нет смыслв еще раз его добавлять
    
     $value_new['email'] = "***".$value['email']."***"; 
     
     if  (strpos($value_new['email'], $search_email)) {

      // Проверяем может уже есть такой ИНН в массие 
      if (isset($search_arr_email)) {
         foreach ($search_arr_email as $temp_inn)
         {
            if ($value['inn'] == $temp_inn['inn']) {
              $priz_inn=1;
                          
            }
         } 
        }
        // если ИНН нет то добавим его
if ($priz_inn <> 1 ) {
  $search_arr_email[$i]['inn'] = $value['inn'];
  $search_arr_email[$i]['search_email_text'] = $value['email'];

  
}

      }


  $i++;
}
 
// echo "<pre>" ;
// var_dump($search_arr_email);
// echo "<pre>" ;

// ******************************  проверяем ечли ли хоть одна компания с таким номером
if (isset($search_arr_email)) { 
// Начинаем делать выборку по ИНН  компании с похожим телефоном 
$i=0;
foreach ($search_arr_email as $value)  {
    // echo $value['search_phone_number']."<br>";
    $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = ?");
    $stmt->execute([$value['inn']]);

    $arr_seacrh_comp_email = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $arr_seacrh_comp_email[0]['search_email_text'] = $value['search_email_text'];
// убираем лишнюю вложенность массива    
    $arr_seacrh_comp_email = call_user_func_array('array_merge', $arr_seacrh_comp_email);


    $arr_seacrh_comp_email_t[$i] = $arr_seacrh_comp_email;
$i++;
}


// $arr_seacrh_comp_tel_t = call_user_func_array('array_merge', $arr_seacrh_comp_tel);

// echo "<pre>" ;
// var_dump($arr_seacrh_comp_tel_t);
// echo "<pre>" ;
$smarty->assign('search_email', $_GET['search_email']);
$smarty->assign('arr_seacrh_comp_email_t', $arr_seacrh_comp_email_t);
$smarty->display('poiski/find_company_by_email.tpl');
} else {
  $smarty->assign('alarm_message_text', "Email по запросу ".$search_telephone. " не найден");
  $smarty->display('poiski/alarm_message.tpl');

}
} else {
  
  $smarty->assign('alarm_message_text', 'Запрос слишком короткий, минимум 3 символа в запросе');
  $smarty->display('poiski/alarm_message.tpl');

  
}
}


// $arr_send_for_poisk = array(
//     'what_find_perem' => 'search_email',
//     'what_find' => 'Поиск по email',
//     'transition' => 82,
// );

// $smarty->assign('arr_send_for_poisk', $arr_send_for_poisk);
// $smarty->display('poiski/poisk_phone_or_email.tpl');

