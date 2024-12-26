<?php
 /******************************************************************************************************************
  *************  Функция создания массива данных для создания СДЕЛКИ ************************* 
  ********************************************************************************************************************/
  Function Make_simple_sdelka ($sdelki, $pipeline_id){

    if ($sdelki['InnCustomer'] != 0) { // если есть ИНН
    $name_sdelka = "№".$sdelki['KpNumber']." от " .$sdelki['KpData'];
    } else { // если нет ИНН то дописывает Название компании
    $name_sdelka = "№".$sdelki['KpNumber']." от " .$sdelki['KpData'] ." (".$sdelki['NameCustomer'].")";
    }


    $link_to_change_kp = 'https://brazel.ru/?transition=30&id='.$sdelki['id'];
    $link_to_see_excel = 'https://brazel.ru/'.$sdelki['LinkKp']; // сыслка на ЕКСЕЛЬ файд
    $link_by_id_kp = 'https://brazel.ru/?transition=10&id='.$sdelki['id']; // ссылка на КП и чтобы компанию выводило
    $price_sdelka = (int)($sdelki['KpSum']);

    //   В зависимости от ВОронки подбираем состояние сделки
    if ($sdelki['type_kp'] == 6) {
      $arr_status = get_status_kp_OBJ($sdelki);
      
    } else {
      $arr_status = get_status_kp($sdelki);
    }
    // Назодим ответственного по сделке
    $responsible_user_id = get_responsible($sdelki);
    $id_kp = $sdelki['id'];
    $id_kontur_kp = $sdelki['idKp'];
    date_default_timezone_set('Europe/Moscow');
    $time = date("h:i:s");
    $currentTime = strtotime($sdelki['KpData'].$time); // переводим время с 1980 года
    $link_kontur_eis =  $sdelki['konturLink'];


    $data_temp[] = array (
        "name" => $name_sdelka,
        "price" => $price_sdelka,
        "responsible_user_id" => $responsible_user_id,
        "created_at" => $currentTime,
        "pipeline_id" => $pipeline_id,
        "status_id" => $arr_status['status_sdelki'],
        "custom_fields_values" => array(
            array ("field_id" => LINK_FOR_CHANGE_KP,
                   "values" => array(array ("value" => $link_to_change_kp)) // ссылка на корректировку КП
                    ),
            array ("field_id" => 474717,
                  "values" => array(array ("value" => $link_to_see_excel)) // ссылка на екскль КП
                  ),
            array ("field_id" => ID_KP,
            "values" => array(array ("value" => $id_kp)) // id в старом реестре
                ),
            array ("field_id" => ID_KONTUR_KP,
             "values" => array(array ("value" => $id_kontur_kp)) // if на контур
               ), 
            array ("field_id" => LINK_ON_KP_IN_OLD_REESTR,
            "values" => array(array ("value" => $link_by_id_kp)) // Ссылка на само КП в реестре
              ) ,
           array ("field_id" => LINK_ON_KONTUR_OR_EIS,
             "values" => array(array ("value" => $link_kontur_eis)) // Ссылка на само КП в реестре
            )       
                  
            ));
     $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    echo "<br>$data<br>";

    return  $data;
    }

 /******************************************************************************************************************
  *************  Функция изменить сумму СДЕЛКИ ************************* 
  ********************************************************************************************************************/
  Function change_price_sdelka ($id_sdelka, $price_sdelka){

    $data_temp[] = array (
        "id" => $id_sdelka,
        "price" => $price_sdelka
  );
    
    $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    
    return  $data;
    }


  /******************************************************************************************************************
  *************  Функция создания массива данных для создания СДЕЛКИ ************************* 
  ********************************************************************************************************************/
  function make_simple_company ($connect_data, $name_company){
    $data_temp[]  =  array("name" => $name_company);
    $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    $result_company_query = post_query_in_amo( $connect_data['access_token'] , $connect_data['subdomain'] , "/api/v4/companies" , $data);
    $company_id = $result_company_query['_embedded']['companies'][0]['id'];
    return  $company_id;
    }


  /******************************************************************************************************************
  *************  Функция смены воронки  ************************* 
  ********************************************************************************************************************/
  function change_pipeline_sdelka ($id_sdelka, $pipeline_id){
    $data_temp[] = array(
      "id" => $id_sdelka,
      "pipeline_id" => $pipeline_id
      
    );
   
    $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    return  $data;
    }

    
 /******************************************************************************************************************
  *************  Изменяем ИНН в компании  ************************* 
  ********************************************************************************************************************/
  function change_company_custom_fields_INN ($connect_data, $company_id, $inn,$id_inn_company){
  $data_temp[] =  array   (
          "id" => $company_id,
          "custom_fields_values" => array(
/// ************************** ИНН **********************
            array (
                  "field_id" => $id_inn_company,
                  "values" => array ( array (                       
                         "value" => $inn
          
            )
         )
      )
   )
);
$data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
$result = send_patch_in_amo($connect_data['access_token'] , $connect_data['subdomain'],"/api/v4/companies" , $data);
return  $result;
}

  /******************************************************************************************************************
  *************  Функция создания КОНТАКТА ************************* 
  ********************************************************************************************************************/
  function make_new_contact ($connect_data, $name_contact, $phone_contact){
    $data_temp[] = array (
      "first_name" => $name_contact,
      "custom_fields_values" => array (
// ************************* Должностьб ***************************
          array ("field_id" => DOP_CONTACT_FILED_INFO,
             "values" => array (array("value" => "Перенесен с реестра"))),
// ************************* Должностьб ***************************
          array ("field_code" => "PHONE",
                "values" => array (array("value" => $phone_contact,
                                          "enum_code" => "WORKDD")))
               ));
    $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    $result_contact_query = post_query_in_amo($connect_data['access_token'] , $connect_data['subdomain'], '/api/v4/contacts' , $data);
    $id_contact = $result_contact_query['_embedded']['contacts'][0]['id'];

    return  $id_contact;
}

  /******************************************************************************************************************
  *************  Функция соединения КОНТАКТА  к  компании ************************* 
  ********************************************************************************************************************/
  function connect_contact_to_company ($connect_data, $id_contact, $company_id){
    $data_temp =  array( array(   
      "to_entity_id" => $id_contact,
      "to_entity_type" => "contacts"
          )
      );
      $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
      $result = post_query_in_amo($connect_data['access_token'] , $connect_data['subdomain'], "/api/v4/companies/".$company_id."/link" , $data);

    return  $result;
}




 /******************************************************************************************************************
  *************  Изменяем NAME в компании  ************************* 
  ********************************************************************************************************************/
  function change_company_custom_fields_NAME ($company_id, $name){
    $data_temp[] =  array   (
            "id" => $company_id,
            "name" => $name,

  );
    
  
  $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
     return  $data;
  }
  
   /******************************************************************************************************************
  *************  Добавляем телефон в компании  ************************* 
  ********************************************************************************************************************/
  function change_company_custom_fields_PHONE ($connect_data, $company_id, $phone, $phone_type){
// запрагиваем все телефоны этой компании
    $arr_id_company = get_query_in_amo($connect_data['access_token'], $connect_data['subdomain'] , "/api/v4/companies/".$company_id);
    
// Находим из массива доп полей, массив с телефонами
    foreach ($arr_id_company['custom_fields_values'] as $items) {
      if ($items['field_code'] == 'PHONE') {
        $phones = $items;
      }
    }
// Смотрим, есть наш телефон в списке или нет
  $priznak_obnovlenia = 777;
  if (isset($phones['values'])){ // проверяем есть ли вообще телефоны 
      foreach ($phones['values'] as $j_phones) {
        if ($j_phones['value'] == $phone) {
          $priznak_obnovlenia = 0;
          break;
        }
      }
  }
// если нет телефона в списке, то добавляем его 
  if ($priznak_obnovlenia == 777) {
      $phones['values'][] = array (                       
        "value" => $phone,
        "enum_code" => $phone_type
        );
      }
    $data_temp[] =  array   (
      "id" => $company_id,
      "custom_fields_values" => array(
/// ************************** PHONE **********************
                array (
                      "field_code" => "PHONE",
                      "values" =>  $phones['values']
                      )
            )
                );
 $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
 
 $result = send_patch_in_amo($connect_data['access_token'], $connect_data['subdomain'], "/api/v4/companies", $data);
 return  $result;
  }
/******************************************************************************************************************
  *************  Добавляем EMAIL в компании  ************************* 
  ********************************************************************************************************************/
  function change_company_custom_fields_EMAIL ($connect_data, $company_id, $email, $type_email){

    // Вычитываем все ЕМАЙЛы этой компании из АМО
     $arr_id_company = get_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], "/api/v4/companies/".$company_id);
 
// Находим из массива доп полей, массив с email
    foreach ($arr_id_company['custom_fields_values'] as $items) {
      if ($items['field_code'] == 'EMAIL') {
        $emails = $items;
      }
    }

// Смотрим, есть наш email в списке или нет
    $priznak_obnovlenia = 777;
    if (isset($emails['values'])){ // проверяем есть ли вообще email 
        foreach ($emails['values'] as $j_emails) {
          if ($j_emails['value'] == $email) {
            $priznak_obnovlenia = 0;
            break;
          }
        }
    }
// если нет email в списке, то добавляем его 
    if ($priznak_obnovlenia == 777) {
        $emails['values'][] = array (                       
          "value" => $email,
          "enum_code" => $type_email
          );
        }
      $data_temp[] =  array   (
        "id" => $company_id,
        "custom_fields_values" => array(
/// ************************** EMAIL **********************
                array (
                      "field_code" => "EMAIL",
                      "values" =>  $emails['values'],
                      
                      )
            )
                );
 $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
 $result = send_patch_in_amo($connect_data['access_token'], $connect_data['subdomain'], "/api/v4/companies" , $data);

   return  $result;
}


  
 /******************************************************************************************************************
  *************  Поиск компании по ИНН ************************* 
  ********************************************************************************************************************/
  function find_company_by_inn ($connect_data, $inn) {
  $method = "/api/v4/companies?query=".$inn; 

$res = get_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], $method);
$data_company='';

if (isset($res)) { // Если есть хоть одна компания Проверям есть ли там ИНН
    foreach ($res['_embedded']['companies'] as $companies){
      foreach ($companies['custom_fields_values'] as $companies_fields) {
        if (isset($companies_fields['field_name'])){
          if ($companies_fields['field_name'] == 'ИНН') {
            $inn_company = $companies_fields['values'][0]['value'];
            $data_company = $companies;
            break;
          }
        }
      }
    }
}
if (isset($inn_company))  {
  return $data_company;  
} else {
return null;

}
}


/******************************************************************************************************
 *   Разбираем актуальные статутсы телефонов
 /*******************************************************************************************************/
function make_rigth_phone_type($phone_type) {

  if( $phone_type == 'Актуальный') {
     $rigth_type = 'WORKDD';
  } else if( $phone_type == 'Неактуальный') {
     $rigth_type = 'OTHER';
  } else if( $phone_type == 'Не звонить') {
     $rigth_type = 'OTHER';
  } else {
     $rigth_type = 'WORK';
  } 
 return $rigth_type;
 }
 /******************************************************************************************************
 *   Разбираем актуальные статутсы почты
 /*******************************************************************************************************/
 function make_rigth_email_type($email_type) {
 
     if( $email_type == 'Актуальная') {
        $rigth_type = 'WORK';
     } else if( $email_type == 'Неактуальная') {
        $rigth_type = 'OTHER';
     } else {
        $rigth_type = 'WORK';
     } 
    return $rigth_type;
    }


 /******************************************************************************************************************
  *************  Функция по добавлению КП в АМО  ************************* 
  ********************************************************************************************************************/
//   function make_new_sdelka_OBJECT($connect_data, $sdelki, $pipeline_id) {
//       echo "<br> {ОБЪЕКТНЫЕ} --  $pipeline_id <br>";
//       // формируем массив для созждания сделки
//     $data_sdelka = Make_simple_sdelka ($sdelki, $pipeline_id); 
//     // запуск функции по созданию сделки в АМО
//         $result_make_sdelka_in_amo = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], '/api/v4/leads' , $data_sdelka);
//         $id_sdelka = $result_make_sdelka_in_amo["_embedded"]["leads"][0]["id"]; // ID созданной сделки

//     return $id_sdelka;

//  }

  /******************************************************************************************************************
  *************  Функция по добавлению  КП в АМО  ************************* 
  ********************************************************************************************************************/
  function make_new_sdelka_SIMPLE($connect_data, $sdelki, $pipeline_id) {
// формируем массив для созждания сделки
    $data_sdelka = Make_simple_sdelka ($sdelki, $pipeline_id); ; 
// запуск функции по созданию сделки в АМО
    $result_make_sdelka_in_amo = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'],'/api/v4/leads' , $data_sdelka);
    $id_sdelka = $result_make_sdelka_in_amo["_embedded"]["leads"][0]["id"];
 
   return $id_sdelka;

}


  /******************************************************************************************************************
  *************  Функция создания массива данных для создания СДЕЛКИ ************************* 
  ********************************************************************************************************************/
  function connect_sdelka_to_company ($connect_data, $id_sdelka, $company_id){
    $data_temp =  array( array(   
      "to_entity_id" => $id_sdelka,
      "to_entity_type" => "leads"
      ));
      
  $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
  $result = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], "/api/v4/companies/".$company_id."/link" , $data);
  return  $result;
  }


 /******************************************************************************************************************
  *************  Функция по созданию ЗАДАЧИ и прицепить ее к сделке  в АМО  ************************* 
  ********************************************************************************************************************/
  function make_new_task($connect_data, $sdelki, $id_sdelka) {

    $DateNextCall = $sdelki['DateNextCall'];
    if ($sdelki['FinishContract'] == 0)  {
        if ($DateNextCall != '0000-00-00') {
              $currentTime = strtotime($DateNextCall); // переводим время с 1980 года
              $responsible_user_id = get_responsible($sdelki);

              $data_temp[] = array (
                  "text" => "Звонок (API)",
                  "responsible_user_id" => $responsible_user_id,
                  "complete_till" => $currentTime, 
                  "entity_id" => $id_sdelka,
                  "entity_type" => "leads"
          );
          
          $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
          $result = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], "/api/v4/tasks" , $data);
          return $result; 
        }
     }
  return false;  

  }


   /******************************************************************************************************************
  *************  Функция по изменению данных в сделке  в АМО  ************************* 
  ********************************************************************************************************************/
  function change_status_sdelka_in_amo($connect_data, $sdelki, $id_sdelka, $pipeline_id) {

    $arr_status = get_status_kp($sdelki);
    echo "CHANEHR STATUS SDELKI<br>";
    echo $arr_status['status_sdelki']."<br>";


    $data_temp[] = array(
       "id" =>$id_sdelka,
       "status_id" => $arr_status['status_sdelki'],
       "pipeline_id" => $pipeline_id,
       "closed_at" => $arr_status['currentTime'],
     );
   
    $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
    // echo "<br>DATA = $data";
    $result = send_patch_in_amo($connect_data['access_token'], $connect_data['subdomain'] , '/api/v4/leads'  , $data);
 

  }

   /******************************************************************************************************************
  *************  Функция для получения статуса сделки  ************************* 
  ********************************************************************************************************************/
 function get_status_kp($sdelki) {
    $KpCondition = $sdelki['KpCondition'];
    $magager = $sdelki['Responsible'];
    $KpSendMail = $sdelki['email_count'];

    $Kpclosed = $sdelki['FinishContract'];
    $time_status_sell = $sdelki['date_sell'];
    $time_status_close = $sdelki['date_close'];

    if ($KpCondition == 'Купили у нас') {
      $status_sdelki = 142; // сделка состоялась
      $currentTime = strtotime($time_status_sell);
    } elseif ($Kpclosed == 1) {
      $status_sdelki = 143; // ЕСЛИ ЗАКРЫЛИ СДЕЛКУ БЕЗ УТОЧНЕНИЯ СТАТУСА
      $currentTime = strtotime($time_status_close);
    } elseif ($KpCondition == 'В работе') {
      $status_sdelki = 61225350; // КП отправлено 
      $currentTime = 0;
    } elseif ($KpSendMail  >= 1 ) {
      $status_sdelki = 61225350; // КП отправлено 
      $currentTime = 0;
    } else {
      $status_sdelki = 61225342;
      $currentTime = 0;
    }
   $arr_status['status_sdelki']  = $status_sdelki;
   $arr_status['currentTime']  = $currentTime;
      return  $arr_status;  
  }

   /******************************************************************************************************************
  *************  Функция для получения статуса ОБЪЕКТНОЙ сделки  ************************* 
  ********************************************************************************************************************/
 function get_status_kp_OBJ($sdelki) {
  $KpCondition = $sdelki['KpCondition'];
  $magager = $sdelki['Responsible'];
  $KpSendMail = $sdelki['email_count'];

  $Kpclosed = $sdelki['FinishContract'];
  $time_status_sell = $sdelki['date_sell'];
  $time_status_close = $sdelki['date_close'];

  if ($KpCondition == 'Купили у нас') {
    $status_sdelki = 142; // сделка состоялась
    $currentTime = strtotime($time_status_sell);
  } elseif ($Kpclosed == 1) {
    $status_sdelki = 143; // ЕСЛИ ЗАКРЫЛИ СДЕЛКУ БЕЗ УТОЧНЕНИЯ СТАТУСА
    $currentTime = strtotime($time_status_close);
  } elseif ($magager  != '' ) {
    $status_sdelki = 61313986; // Менеждер назначен 
    $currentTime = 0;
  } elseif ($KpCondition == 'В работе') {
    $status_sdelki = 61313982; // КП отправлено  
    $currentTime = 0;
  } elseif ($KpSendMail  >= 1 ) {
    $status_sdelki = 61313982; // КП отправлено 
    $currentTime = 0;
  

  } else {
    $status_sdelki = 61313978;
    $currentTime = 0;
  }
 $arr_status['status_sdelki']  = $status_sdelki;
 $arr_status['currentTime']  = $currentTime;
    return  $arr_status;  
}



// Находим ответственного по сделке 

function  get_responsible($sdelki) {
 
  $responsible = $sdelki['Responsible'];
  
  
     echo "<br>eeeeeeeeeeeeeee==".$responsible."==99999999999999999999999999999<br>";
     
     
  if ($responsible == 'Зелизко') {
    $responsible_user_id = ZELIZKO_DI;
  } elseif ($responsible == 'Горячев') {
    $responsible_user_id = GORIACHEV_A;
  } elseif ($responsible == 'Гуц') {
    $responsible_user_id = GUTS_A;
  } elseif ($responsible == 'Штыбко') {
    $responsible_user_id = SHTIBKO_I;
  } elseif ($responsible == 'Кулиев') {
    $responsible_user_id = KULIEV_R;
  } elseif ($responsible == 'Лобов') {
    $responsible_user_id = LOBOV_G;
  } elseif ($responsible == 'Кидалова') {
    $responsible_user_id = KIDALOVA_A;
  } elseif ($responsible == 'Никитина') {
    $responsible_user_id = NIKITINA_A;
  } else {
    $responsible_user_id = GUTS_A;
  }
      echo "<br>eeeeeeeeeeeeeee==".$responsible_user_id."==99999999999999999999999999999<br>";
return  $responsible_user_id;
}



   /******************************************************************************************************************
  *************  / Функция по добавлению товаров к сделке  ************************* 
  ********************************************************************************************************************/

function add_tovar_to_sdelka ($connect_data, &$arr_tovari, $id_sdelka) {
  foreach ($arr_tovari as &$tovar) {
    $new_ed_izm = make_rigth_ed_izm($tovar['ed_izm']); // стандартизируем единицы измерения

    $data_tovar [] = array(
        //*******************  Название товара   ************************************
                "name" => $tovar['name'], 
                "custom_fields_values" => array(
        // *******************  Артикул  товара *******************************************
                        array("field_id" => SKU_TOVAROV, // Цена  товара
                        "values" => array (array("value" =>  ""))
                        ),
          //*******************  Группв  товара ************************************
                    array("field_id" => GROUP_TOVAROV, 
                          "values" => array (array("value" => "Объектные"))
                    ),
        // *******************  Цена  товара *******************************************
                    array("field_id" => PRICE_TOVAROV, // Цена  товара
                          "values" => array (array("value" => $tovar['price']))
                         ),
        //*******************  Единица измерения  товара ************************************
                    array("field_id" => UNIT_TOVAROV, 
                          "values" => array (array("value" => $new_ed_izm))
                         )
                )
        );
        
        
        $data = json_encode($data_tovar, JSON_UNESCAPED_UNICODE);
        $method = "/api/v4/catalogs/".CATALOG_TOVARI."/elements" ;
        $res = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], $method , $data);
        $id_tovara = $res['_embedded']['elements'][0]['id'];
        
        // echo "<br>";
        // echo "<pre>";
        // print_r ($res);
        // echo "<br><br>";
       unset ($data_tovar); 
     
   

       $data_coonect_tovar =  array( array(   
            "to_entity_id" => $id_tovara,
            "to_entity_type" => "catalog_elements",
            "metadata"=> array (
                "quantity" => $tovar['kol'],
                "catalog_id" => CATALOG_TOVARI
                    )       
        
            ));
            
        $data_z = json_encode($data_coonect_tovar, JSON_UNESCAPED_UNICODE); // формируем данные чтобы зацепить товар к сделке
        $method = "/api/v4/leads/".$id_sdelka."/link";
        $res = post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], $method , $data_z); // цепляем товар к сделке
      // добавляем id в json файла КП
    $tovar['id'] = $id_tovara;
      }
}


/* **********************************************************************************************
* Функция добавления ID Товара в Json формат КП 
**************************************************************************************************/
function add_id_tovar_in_json ($link_json_file, $products){
  $temp = json_decode( file_get_contents($link_json_file), true); // берем на Json файл с данными КП
  $temp['products'] = $products; // обновляем продукты с ID товарами (возможно для дальнейшей корретироваки цены)
  file_put_contents($link_json_file, json_encode($temp, JSON_UNESCAPED_UNICODE)); // обновляем наш JSON файл с КП

}

function make_rigth_ed_izm($ed_izm) { // функция приведения в порядок единицы измерения
  $temp_ed_izm = strtolower($ed_izm); // все в нижний регистр
  $temp_ed_izm =mb_eregi_replace("[^a-zа-яё0-9 ]", '', $temp_ed_izm); // убираем все кроме букв и цифр


  if ($ed_izm == 'шт')             {$new_ed_izm = 'шт';}
  elseif ($ed_izm == 'шт.')        {$new_ed_izm = 'шт';}

  elseif ($ed_izm == 'кт')         {$new_ed_izm = 'комплект';}
  elseif ($ed_izm == 'кт.')        {$new_ed_izm = 'комплект';}
  elseif ($ed_izm == 'к-т')        {$new_ed_izm = 'комплект';}
  elseif ($ed_izm == 'к-т.')       {$new_ed_izm = 'комплект';}
  elseif ($ed_izm == 'комплект')   {$new_ed_izm = 'комплект';}
  elseif ($ed_izm == 'комплект.')  {$new_ed_izm = 'комплект';}

  elseif ($ed_izm == 'мп')         {$new_ed_izm = 'мп';}
  elseif ($ed_izm == 'мп.')        {$new_ed_izm = 'мп';}
  elseif ($ed_izm == 'пм.')        {$new_ed_izm = 'мп';}
  elseif ($ed_izm == 'мп')         {$new_ed_izm = 'мп';}
  elseif ($ed_izm == 'пм.')        {$new_ed_izm = 'мп';}
  elseif ($ed_izm == 'м')          {$new_ed_izm = 'м';}
  
  elseif ($ed_izm == 'м2')         {$new_ed_izm = 'м2';}
  elseif ($ed_izm == 'м3')         {$new_ed_izm = 'м3';}
  
  elseif ($ed_izm == 'т')          {$new_ed_izm = 'т';}
  elseif ($ed_izm == 'кг')         {$new_ed_izm = 'кг';}
  elseif ($ed_izm == 'кг.')        {$new_ed_izm = 'кг';}
  
  elseif ($ed_izm == 'л')          {$new_ed_izm = 'л';}
  elseif ($ed_izm == 'л.')         {$new_ed_izm = 'л';}
  else  {$new_ed_izm = 'шт';}

return $new_ed_izm;
}


   /******************************************************************************************************************
  *************  // Функция по добавлению примечания к сделке ************************* 
  ********************************************************************************************************************/
function add_note_to_sdelka ($connect_data, $sdelki, $id_sdelka) {
  // echo "<br> **** Примечания  *****<br>";
  if ($sdelki['Comment'] == '') { return false;} // если нет комментария то сразу уходим
  
  $method = "/api/v4/leads/".$id_sdelka."/notes";  // метод по доавлению примечания к сделке

    // unset($data_temp5);
    $comment = $sdelki['Comment'];
    $arr_comment = explode('||+', $comment); // массив с комментариями
    print_r($arr_comment);
    $arr_comment = array_reverse($arr_comment); // разворачиваем массив
     foreach ($arr_comment as $item_comment) {
      
          if ((strlen($item_comment) > 6)) {
                $item_comment = str_replace('@!', '', $item_comment);
                echo "<br>*****$item_comment******<br>";
                $data_temp5[] = array(
                    "note_type" => "common",
                    "params" => array("text" => $item_comment),
               );
          }
     } 
  //  echo "<br> **** DATA_TEMO_5 *****<br>"; 
  //  print_r($arr_comment);

  if (isset($data_temp5)) { // Проверяем есть ли хоть одно примечание 
    $data = json_encode($data_temp5, JSON_UNESCAPED_UNICODE);
    $res= post_query_in_amo($connect_data['access_token'], $connect_data['subdomain'], $method , $data);
  }
  // echo "<br> **** Примечания  вышли *****<br>";
}

/******************************************************************************************************************
*************  Функция, которая обновляет ID амо сделки в реестре  ************************************************ 
********************************************************************************************************************/
function update_amo_id_in_my_reesrt ($pdo, $id_sdelka, $sdelki) {
  $data_arr = [
    'id_amo_lead'=> $id_sdelka,
    'id' => $sdelki['id'],
  ];
  
$sql = "UPDATE reestrkp SET id_amo_lead=:id_amo_lead WHERE id=:id";
$stmt= $pdo->prepare($sql);
$stmt->execute($data_arr);
}


 /******************************************************************************************************************
  *************  Добавляем наименование объекта в сделке  ************************* 
  ********************************************************************************************************************/
  function add_object_name_in_deal ($connect_data, $id_sdelka, $object_name){
    
    


    $data_temp[] =  array   (
            "id" => $id_sdelka,
            "custom_fields_values" => array(
  /// ************************** ИНН **********************
              array (
                    "field_id" => 1594165,
                    "values" => array ( array (                       
                           "value" => $object_name
            
              )
           )
        )
     )
  );
  $data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
  $result = send_patch_in_amo($connect_data['access_token'] , $connect_data['subdomain'],"/api/v4/leads" , $data);
  return  $result;
  }