<?php
@$author = $_GET['author'];
@$date_start = $_GET['date_start'];
@$date_end = $_GET['date_end'];
@$what_change = $_GET['what_change'];

 switch ($what_change){
          case 9: 
            {
              $what_change1 = 9;
              $what_change2 = 9;
              break;
          }
          case 2: {
            $what_change1 = 2;
            $what_change2 = 6;
            break;
          }


 }
$stmt = $pdo->prepare("SELECT * FROM `reports` WHERE `author`=:author AND `date_change`>=:date_start AND `date_change`<=:date_end AND `what_change`>=:what_change1 AND `what_change`<=:what_change2 ORDER BY `time_change` DESC");
$stmt->execute(array('author' => $author,
                      'date_start' => $date_start,
                      'date_end' => $date_end,
                      'what_change1' => $what_change1,
                      'what_change2' => $what_change2,
                      
)
);
$arr_select_changes = $stmt->fetchAll(PDO::FETCH_ASSOC);


// ****************** перебираем каждое КП, чтобы дополнить массив номером и датой КП и прочей херней
$i=0;
foreach ($arr_select_changes as &$value) {
  if ($value['id_item'] == 0 ) {
    unset($arr_select_changes[$i]);

  }
  $i++;

  
}
$arr_select_changes = array_values($arr_select_changes);



foreach ($arr_select_changes as &$value) {

  $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = ?");
  $stmt->execute([$value['id_item']]);
  $arr_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $value['name'] = $arr_id[0]['name'];
      $value['adress'] = $arr_id[0]['adress'];
      $value['what_change_com'] = '';
      if ($what_change  == 9) $value['what_change_com'] = "Создана новая Компания";

      if ($value['what_change']  == 2) $value['what_change_com'] = "Изменены данные о компания";
      if ($value['what_change']  == 3) $value['what_change_com'] = "Изменен телефон";
      if ($value['what_change']  == 4) $value['what_change_com'] = "Добавлен телефон";
      if ($value['what_change']  == 5) $value['what_change_com'] = "Изменен email";
      if ($value['what_change']  == 6) $value['what_change_com'] = "Добавлен email";


//  Находим ID КП Заказчика, чтобы прицепить ссылку на него из аналитики
      $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE InnCustomer = ?");
      $stmt->execute([$value['id_item']]);
      $arr_id_kp = $stmt->fetchAll(PDO::FETCH_ASSOC);

     if (@$arr_id_kp[0]['id'] <> '') {
      $value['id_kp'] = $arr_id_kp[0]['id'];
        } else {
          $value['id_kp']='';
        }
}
// ORDER BY id DESC LIMIT 1

// echo "<pre>";
// print_r($arr_select_changes);
// echo "<pre>";
// die();


$smarty->assign ('arr_select_changes', $arr_select_changes);
// echo "<pre>";
// print_r($arr_select_changes);
// echo "<pre>";
// die();


$smarty->display('reports/reports_show_new_comp.tpl');

