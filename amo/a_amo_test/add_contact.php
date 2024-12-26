<?php
require_once 'access.php';
require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;

$data_temp[] = array (
        "first_name" => "Петр",
        "last_name" => "Смирнов",
        "custom_fields_values" => array (
// ************************* Должностьб ***************************
            array (
               "field_id" => 2236877,
               "values" => array ( 
                            array(
                                 "value" => "Перенесен с реестра"
                                 )
                )
                            ),
// ************************* Должностьб ***************************
array (
    "field_code" => "PHONE",
    "values" => array ( 
                 array(
                      "value" => "78632747304",
                      "enum_code" => "WORK"
                      )
     )
    )
  )
);
$data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
$method = '/api/v4/contacts' ;
$res = post_query_in_amo($access_token, $subdomain , $method , $data);


echo "<pre>";
print_r($res);