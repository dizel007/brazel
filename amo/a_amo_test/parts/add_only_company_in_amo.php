<?php

echo "<br>Компания с ИНН : $inn отсутствует в базе. Добавляем<br>";

// ************************* начинае мсоздавать компанию 
// echo "<br> Создание компании  ********************************************<br>";
    $name_company = $j_inn['name']; // Наименование компании
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



 // конец цикла по перебору КП