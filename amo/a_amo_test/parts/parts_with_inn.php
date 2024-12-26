<?php

echo "<br>Компания с ИНН : $inn отсутствует в базе. Добавляем<br>";

// ************************* начинае мсоздавать компанию 
// echo "<br> Создание компании  ********************************************<br>";
    $name_company = $j_inn['NameCustomer']; // Наименование компании
    $company_id = make_simple_company ($connect_data, $name_company);
echo "<br>company_id = $company_id<br>";
// ************************* Добавляем ИНН
    $result_inn = change_company_custom_fields_INN ($connect_data, $company_id, $inn, ID_INN_COMPANY);

// ************************* Добавляем Телефоны ************************************************************
//******************************************************************************************************** */
// echo "<br> Добавляем Телефоны  ********************************************<br>";
    $stmt = $pdo->prepare("SELECT telephone, actual, name FROM telephone WHERE inn = $inn");
    $stmt->execute([]);
    $arr_phone = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Перебираем все телефоны который нужно добавить
    foreach ($arr_phone as $j_phone) {
    $phone = mb_eregi_replace('[^0-9]', '', $j_phone['telephone']);
    $phone_type = make_rigth_phone_type($j_phone['actual']);
    change_company_custom_fields_PHONE ($connect_data, $company_id, $phone , $phone_type);

// ***********************  Создаем контакт, если есть Имя у телефона ******************************************

// echo "<br> Создаем контакт, если есть Имя у телефона  ********************************************<br>";

        $name_contact = $j_phone['name'];
        if ($name_contact != '') {
        $id_contact = make_new_contact ($connect_data, $name_contact, $phone);
/// ****************************** привязываем Контакт к компании ********************************       
        connect_contact_to_company ($connect_data, $id_contact, $company_id);
       }
     }

// ************************************* Добавляем EMAILS ************************************************
//******************************************************************************************************** */


// echo "<br> Добавляем EMAILS  ********************************************<br>";

// вычитываем из моей базы все ЕМАЙЛ по этому ИНН

    $stmt = $pdo->prepare("SELECT email, actual FROM email WHERE inn = $inn");
    $stmt->execute([]);
    $arr_email = $stmt->fetchAll(PDO::FETCH_ASSOC);

// перебираем все Емафлы и если нет такого инн в АМО, то добавляем его
    foreach ($arr_email as $j_email) {
        $email = $j_email['email'];
        $email_type = make_rigth_email_type($j_email['actual']);
        $result_change_email = change_company_custom_fields_EMAIL ($connect_data, $company_id, $email , $email_type);
    }

/******************************************************************************************************************************
************************************************* Добавляем сделки к компаниям *******************************************
******************************************************************************************************************************/
// echo "<br> Добавляем сделки к компаниям  ********************************************<br>";
// вычитываем все КП по этому ИНН
    $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE InnCustomer = $inn");
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
    // make_new_task($connect_data, $sdelki, $id_sdelka);
} 
// ********************  Добавляем товары только в открытую сделку  ***********************************************

if ($sdelki['FinishContract'] == 0)  {

// Получаем список товаров из КП


$link_excel_kp_tovar = ''. $sdelki['LinkKp']; // ссылка на EXCEL файл с номенклатурой

echo $link_excel_kp_tovar."<br>";

if (file_exists($link_excel_kp_tovar)) {
    echo "<br>*********** НАШЛИ ФАЙЛ *****************<br>";
    $arr_tovari = parce_excel_kp($link_excel_kp_tovar);
    print_r($arr_tovari);
    add_tovar_to_sdelka ($connect_data, $arr_tovari, $id_sdelka) ;
} else {
    echo "<br>*********** ОТСУТСТВУЕТ ФАЙЛ *****************<br>";
}
 
}
/// Добавляем примечание к сделке
add_note_to_sdelka ($connect_data, $sdelki, $id_sdelka);

// обновляем id амо сделки в реестре
update_amo_id_in_my_reesrt ($pdo, $id_sdelka, $sdelki);

} // конец цикла по перебору КП