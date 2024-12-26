<?php
@$author = $_GET['author'];
@$date_start = $_GET['date_start'];
@$date_end = $_GET['date_end'];
@$what_change = $_GET['what_change'];


$stmt = $pdo->prepare("SELECT * FROM `reports` WHERE `author`=:author AND `date_change`>=:date_start AND `date_change`<=:date_end AND `what_change`=:what_change ORDER BY `time_change` DESC");
$stmt->execute(array('author' => $author,
                      'date_start' => $date_start,
                      'date_end' => $date_end,
                      'what_change' => $what_change,
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

  $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = ?");
  $stmt->execute([$value['id_item']]);
  $arr_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $value['KpNumber'] = $arr_id[0]['KpNumber'];
      $value['KpData'] = $arr_id[0]['KpData'];
      $value['InnCustomer'] = $arr_id[0]['InnCustomer'];
      $value['NameCustomer'] = $arr_id[0]['NameCustomer'];
      $value['Responsible'] = $arr_id[0]['Responsible'];
      $value['KpSum'] = number_format($arr_id[0]['KpSum'],0);

}

$smarty->assign ('arr_select_changes', $arr_select_changes);
// echo "<pre>";
// print_r($arr_select_changes);
// echo "<pre>";
// die();


$smarty->display('reports/reports_show_changes.tpl');

