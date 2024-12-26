<?php

echo "<br>Компания с ИНН : $inn есть в базе. Добавляем только сделку<br>";

// ************************* начинае мсоздавать компанию 
// echo "<br> Создание компании  ********************************************<br>";
    $name_company = $j_id['NameCustomer']; // Наименование компании
    $company_id = $inn_our_company['id'];
echo "<br>company_id = $company_id<br>";
echo "<br>id = $id<br>";

/******************************************************************************************************************************
************************************************* Добавляем сделки к компаниям *******************************************
******************************************************************************************************************************/
// echo "<br> Добавляем сделки к компаниям  ********************************************<br>";
// вычитываем все КП по этому ИНН
    $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = $id");
    $stmt->execute([]);
    $arr_sdelki = $stmt->fetchAll(PDO::FETCH_ASSOC);



// перебираем все КП и добавляем их в АМО
    foreach ($arr_sdelki as $sdelki) {
        $type_kp = $sdelki['type_kp'];
        if ($type_kp == 6) {
            $pipeline_id = OBJECT_PIPELINE_ID; // id воронки ОБЪЕКТНЫЕ
            echo "<br> {ОБЪЕКТНЫЕ} --  $pipeline_id <br>";
        }else {
            $pipeline_id = MAIN_PIPELINE_ID; // id воронки ВХОДЯЩИЕ ОБРАЩЕНИЯ
            echo "<br>{ВХОДЯЩИЕ ОБРАЩЕНИЯ} --  $pipeline_id <br>";
        }
        $id_sdelka = make_new_sdelka_SIMPLE($connect_data, $sdelki, $pipeline_id);
   
// цепляем сделку к компании
// echo "<br> цепляем сделку к компании  ********************************************<br>";
    connect_sdelka_to_company ($connect_data, $id_sdelka, $company_id);

// ************** цепляем ЗАДАЧА к сделке  (если она есть)
// echo "<br> цепляем задачу к сделке  (если она есть)  ********************************************<br>";
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
update_amo_id_in_my_reesrt ($pdo, $id_sdelka, $sdelki);

} // конец цикла по перебору КП