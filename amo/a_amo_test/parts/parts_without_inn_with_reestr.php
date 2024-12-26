<?php

    echo "<br>Компания БЕЗ ИНН : $id КП Добавляем ТОЛЬКО СДЕЛКУ<br>";
// ************************* начинае мсоздавать компанию 
// echo "<br> Создание компании  ********************************************<br>";
  echo  $name_company = $j_id['NameCustomer']; // Наименование компании


// ************************* Достаем нашу сделку по ID *******************************************
$stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = $id");
$stmt->execute([]);
$arr_sdelki = $stmt->fetchAll(PDO::FETCH_ASSOC);



/*******************************************************************
*  ***** Если у сделки нет ИНН то создае только сделку
**************************************************************** */
$sdelki  = $arr_sdelki[0];

$name_sdelka = "№".$sdelki['KpNumber']." от " .$sdelki['KpData'] ." ($name_company)";
echo "<br>$name_sdelka Название сделки СДЕЛКУ<br>";
$link_to_change_kp = 'https://brazel.ru/?transition=30&id='.$sdelki['id'];
$link_to_see_excel = 'https://brazel.ru/'.$sdelki['LinkKp'];
$price_sdelka = (int)($sdelki['KpSum']);

$pipeline_id_2 = MAIN_PIPELINE_ID; // БЕЗ ИНН ТОЛЬКО В ОБЩУЮ ПАПКУ 

$id_sdelka = make_new_sdelka_SIMPLE($connect_data, $sdelki, $pipeline_id_2);

echo "<br> ******* СОЗДАЛИ СДЕЛКУ ID = $id_sdelka **********************<br>";

// ************** цепляем ЗАДАЧА к сделке  (если она есть)
if ($sdelki['FinishContract'] == 0)  {
make_new_task($connect_data, $sdelki, $id_sdelka);
}
// ********************  Добавляем товары только в открытую сделку  ***********************************************

if ($sdelki['FinishContract'] == 0)  {

 // Получаем список товаров из КП


$link_excel_kp_tovar = '../../'. $sdelki['LinkKp']; // ссылка на EXCEL файл с номенклатурой
$link_json_kp_tovar = str_replace("EXCEL","JSON_KP", $link_excel_kp_tovar) ;
$link_json_kp_tovar = substr($link_json_kp_tovar,0,-5); // ссылка на JSON файл с номенклатурой
$link_json_kp_tovar = $link_json_kp_tovar.'.json';// ссылка на JSON файл с номенклатурой
echo "<br>".$link_json_kp_tovar."<br>";



if (file_exists($link_json_kp_tovar)) {
    echo "<br>*********** НАШЛИ JSON ФАЙЛ *****************<br>";
    $arr_tovari = parce_json_kp($link_json_kp_tovar); // получаем перечень товаров из jSON файла
    add_tovar_to_sdelka ($connect_data, $arr_tovari, $id_sdelka) ; // Добавляем товары  к сделкам и добавляем в массив товаров ID товаров
    add_id_tovar_in_json ($link_json_kp_tovar, $arr_tovari); // ДОбавляем массив товаров с ID товарам с JSON файл
    print_r($arr_tovari);
    

} elseif (file_exists($link_excel_kp_tovar)) {
    echo "<br>*********** НАШЛИ  EXCEL ФАЙЛ *****************<br>";
    $arr_tovari = parce_excel_kp($link_excel_kp_tovar);
    
    // print_r($arr_tovari);
    // die(';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;');

    add_tovar_to_sdelka ($connect_data, $arr_tovari, $id_sdelka) ;
} else {
    echo "<br>*********** ОТСУТСТВУЕТ ФАЙЛ *****************<br>";
}
   
  }
/// Добавляем примечание к сделке
  add_note_to_sdelka ($connect_data, $sdelki, $id_sdelka);

/// Добавляем название закупки (тендера) к сделке

if ($type_kp == 6) { // Только для объектных КП
  if (file_exists($link_json_kp_tovar)){
      echo "<br> ***** ДОБАВЛЯЕМ НАИМЕНОВАНИЕ ЗАКУПКИ<br>";
      $name_ojbect = parce_json_kp_return_name_object($link_json_kp_tovar);
      add_object_name_in_deal ($connect_data, $id_sdelka, $name_ojbect);
  } else {
      echo "<br> ***** НЕ СМОГЛИ ДОБАВИТЬ НАЗВАНИЕ ЗАКУПКИ<br>";
  }
}

// обновляем id амо сделки в реестре
echo "<br>*********** UPDATE REESTR AMO_ID_LEAD *****************<br>";
  update_amo_id_in_my_reesrt ($pdo, $id_sdelka, $sdelki);
