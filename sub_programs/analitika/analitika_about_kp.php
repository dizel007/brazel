<?php

$id= $_GET['id']; // id KP
/** вычитываем данные по изменениям в КП */
$stmt = $pdo->prepare("SELECT * FROM `reports` WHERE 	id_item = $id");
$stmt->execute([]);
$arr_with_all_changes = $stmt->fetchAll(PDO::FETCH_ASSOC);



/** вычитываем данные по самому КП */
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` WHERE 	id = $id");
$stmt->execute([]);
$arr_with_info_kp= $stmt->fetchAll(PDO::FETCH_ASSOC);
$LinkKp = $arr_with_info_kp[0]['LinkKp'];
$cor_kol_kp = $arr_with_info_kp[0]['cor_kol_kp'];

$LinkKp = substr($LinkKp,0, -5);

if ($cor_kol_kp >0 ) {
$LinkKp = substr($LinkKp, 0,-strlen($cor_kol_kp));
}



$LinkKp_first = $LinkKp.".pdf"; // самое первое КП


if (!file_exists($LinkKp_first)) 
{
  $LinkKp_first=''; 
}

/** смотрим, если ледит файл на сервере то выведем ссылку для него */
for ($i=1; $i<=$cor_kol_kp; $i++)
      
if (file_exists($LinkKp.$i.".pdf" )) {
  $arr_LinkKp[] = $LinkKp.$i.".pdf";
} else {
  $arr_LinkKp[]='';
}
$i22=0;
foreach ($arr_with_all_changes as $value) {

  // информация о создании КП
  if ($value['what_change'] == 8) {
    $start_info_kp = $value;
    
  }

  if ($value['what_change'] == 9) {
    $change_data_kp[] = $value;
  }


  if ($value['what_change'] == 1) {
    $pos=0;
    $temp_text = $value['comment_change'];
    // echo "ORIG=".$temp_text."<br>";
    $temp_text = str_replace('коммент :', '' ,$temp_text);
    $temp_text = str_replace('@!', '' ,$temp_text);
    $temp_text = trim($temp_text);
    $arr_temp_text[$i22] = explode("||+",$temp_text);

    
 
    $value['comment_change']  = $arr_temp_text[$i22];
    $change_in_kp[] = $value;
    $i22++;
  }


  // информация об отправленных письмах 
  if ($value['what_change'] == 7) {
    // $value['comment_change'] = str_replace('Отправлено сообщение с сайта на адрес : ', '' ,$value['comment_change']);
    $start_emales[] = $value;
  }

}
$k1=0;
foreach ($change_in_kp  as &$arr_value) {

     foreach ($arr_value as $key=>&$value){
    
            if  ($key == 'comment_change'){
              $i=0;
                foreach ($value as &$comment) {
                 if ((trim($comment) == ';') OR (trim($comment) =='')){
                    unset($change_in_kp[$k1]['comment_change'][$i]);
                  }
                 $i++;   
               }
      } 
  }
  $k1++;
}

// echo "<pre>";
// print_r($change_in_kp);
// echo "<pre>";
// die();
// echo "<pre>";
// print_r($arr_with_all_changes);
// echo "<pre>";
// die();

$smarty->assign('start_info_kp' , @$start_info_kp);


@$change_in_kp = array_reverse(@$change_in_kp);
$smarty->assign('change_in_kp' , @$change_in_kp); // Изменния в КП
$smarty->assign('change_data_kp' , @$change_data_kp); // Изменния в КП

$smarty->assign('LinkKp_first' , @$LinkKp_first); // Ссылка на нулевое КП

$smarty->assign('start_emales' , @$start_emales);

$smarty->assign('arr_LinkKp' , @$arr_LinkKp);
$smarty->assign('cor_kol_kp' , @$cor_kol_kp);

// $smarty->assign('arr_temp_text' , @$arr_temp_text); // массив комментариев с разбитием по сторкам
$smarty->display('reports/reports_about_kp.tpl');
// die('DIE reports_about_kp.php');
