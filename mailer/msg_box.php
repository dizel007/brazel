<?php
require_once ("functions/get_file_name_for_json.php");

$ZakupName = "";
(!empty($_GET['InnCustomer']))? $InnCustomer = $_GET['InnCustomer']: $InnCustomer = '';

if (!empty($_GET['id'])) {
  $id = $_GET['id'];
}

$arr_emails = GetEmailByInn($pdo,$InnCustomer);

// количетво емайло в БД
$smarty->assign('arr_emails', $arr_emails);
$smarty->assign('count_arr_emails', count($arr_emails));

// находим по ID закупки наименование файла, который будем отправлять
$arr_kp = GetKPById($pdo,$id);

 // находим все КП к этому адресату 
if ($InnCustomer <>'') {
    $all_kp_by_our_id = GetKPByInn($pdo,$InnCustomer);
    // убираем наше КП
    foreach ($all_kp_by_our_id as $value) {
      if (($value['id'] <> $id) && ($value['FinishContract'] == 0)) {

        $temp = get_file_name_for_json_file($value); // получаем ссылку на JSON фалы
        $temp = $temp.".pdf";
        $temp_id = $value['id'];

        if (file_exists("EXCEL/". $temp)) { 
  
        $new_link_kp_by_our_id[] = $temp;
        $arr_id_dop_kp[]=$temp_id; // массив с ID  дополнительных КП которые выводидись
      }
      }
    }
}


/// Преобразуем ссылку с эксель файла на ссылку json файла
// echo "<pre>";
// print_r($new_link_kp_by_our_id);
// die();
$json_kp_file_temp = get_file_name_for_json_file($arr_kp[0]); // получаем ссылку на НАШ JSON фалы
$json_kp_file = "JSON_KP/".$json_kp_file_temp.".json";

// echo " 888888888888888888888 --- $json_kp_file";
// die();

if (file_exists($json_kp_file)) {

// получаем данные из JSON файла c КП
require_once ("functions/parce_json_kp_file.php");



// формируем путь к загружаемому файлу
$link_pdf = "EXCEL/".$json_kp_file_temp.".pdf";


// проверяемя существует ли файл на сервере
$real_file = file_exists($link_pdf);

// echo "<br> **$real_file**<br>";
// die();

$link_pdf_text = $json_kp_file_temp.".pdf"; // формируем для вывода на экран имя файла
$link_pdf_excel = $arr_kp[0]['LinkKp']; // делаем путь для ексель файла

$ZakupNameTemp = str_replace('"', '', $ZakupName);
$ZakupNameTemp = str_replace(' ', '%20', $ZakupNameTemp); // чтобы передавать длинные пути с пробелами
$link_pdf = str_replace(' ', '%20', $link_pdf); // чтобы передавать длинные пути с пробелами


$pos_N = strpos($ZakupName, "№");
$ZakupName = substr($ZakupName,$pos_N);

$smarty->assign('kp_name', $kp_name);
$smarty->assign('Zakazchik', $Zakazchik);
$smarty->assign('InnCustomer', $InnCustomer);
$smarty->assign('Email', $Email);
$smarty->assign('ZakupName', $ZakupName);
$smarty->assign('link_pdf', $link_pdf);
$smarty->assign('link_pdf_text', $link_pdf_text);
$smarty->assign('link_pdf_excel', $link_pdf_excel);
$smarty->assign('id', $id);
$smarty->assign('ZakupNameTemp', $ZakupNameTemp);
$smarty->assign('real_file', $real_file); // ПризнакЮ что есть ПДФ файл
$smarty->assign('type_kp', $arr_kp[0]['type_kp']); // отправляем тип КП, чтобы понять что в письме писать

    if (isset($new_link_kp_by_our_id)) {
    $smarty->assign('new_link_kp_by_our_id', $new_link_kp_by_our_id); // отправляем массив с другими КП
    $smarty->assign('arr_id_dop_kp', $arr_id_dop_kp); // отправляем массив id с другими КП
    $smarty->assign('count_dop_kp', count($new_link_kp_by_our_id)); // отправляем массив с другими КПcount_dop_kp
    } 

$smarty->display('send_mail.tpl');
} else {
  // При отсутствии ЕКСЕЛЬ файла
  $smarty->assign('alarm_message', 'Нет JSON файла c КП');
  $smarty->assign('back_adress', $_SERVER['HTTP_REFERER']);
  $smarty->display('alarm_message.tpl');
}
// echo "<pre>";
// print_r($arr_kp);
// echo "<pre>";

?>