<?php
 /******************************************************************************************************************
  *************  Функция по взаимодействию с АМО **************************************************** 
  ********************************************************************************************************************/

 function post_query_in_amo($access_token, $subdomain , $method , $data) {
// echo "<br>post_query_in_amo<br>";
    $headers = [
       'Content-Type: application/json',
       'Authorization: Bearer ' . $access_token,
   ];
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
 curl_setopt($curl, CURLOPT_URL, "https://$subdomain.amocrm.ru".$method);
 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
 curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
 curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
 $out = curl_exec($curl);
 $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 $code = (int) $code;
 $errors = [
     301 => 'Moved permanently.',
     400 => 'Переданы некорректные данные. Подробности доступны в теле ответа',
     401 => 'Пользователь не авторизован',
     403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
     404 => 'Not found.',
     500 => 'Internal server error.',
     502 => 'Bad gateway.',
     503 => 'Service unavailable.'
 ];
 
 $arr_result = json_decode($out, true);
 
//  echo "<pre>";
//  print_r($arr_result);
 
 if ($code < 200 || $code > 204) {
    echo "<br><br>";
    echo "<pre>";
    print_r($arr_result);
    die( "Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error') );
 }
 
 return $arr_result;
 }
 
 /******************************************************************************************************************
  *************  Функция по взаимодействию с АМО **************************************************** 
  ********************************************************************************************************************/

  function send_patch_in_amo($access_token, $subdomain , $method , $data) {

    $headers = [
       'Content-Type: application/json',
       'Authorization: Bearer ' . $access_token,
   ];
 $curl = curl_init();
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
 curl_setopt($curl, CURLOPT_URL, "https://$subdomain.amocrm.ru".$method);
 curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
 curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
 curl_setopt($curl, CURLOPT_HEADER, false);
 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
 $out = curl_exec($curl);
 $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 $code = (int) $code;
 $errors = [
     301 => 'Moved permanently.',
     400 => 'Переданы некорректные данные. Подробности доступны в теле ответа',
     401 => 'Пользователь не авторизован',
     403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
     404 => 'Not found.',
     500 => 'Internal server error.',
     502 => 'Bad gateway.',
     503 => 'Service unavailable.'
 ];
 
 $arr_result = json_decode($out, true);
//  echo "<pre>";
//  print_r($arr_result);

 if ($code < 200 || $code > 204) {
    echo "<br><br>";
     echo "<pre>";
 print_r($arr_result);
    die( "Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error') );
 }
 

 return $arr_result;
 }
 

 /******************************************************************************************************************
  *************  Функция по взаимодействию с АМО **************************************************** 
  ********************************************************************************************************************/

  function get_query_in_amo($access_token, $subdomain , $method) {
  //  echo "<br>function send_query_in_amos<br>";
       $headers = [
          'Content-Type: application/json',
          'Authorization: Bearer ' . $access_token,
      ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
    curl_setopt($curl, CURLOPT_URL, "https://$subdomain.amocrm.ru".$method);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    $out = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $code = (int) $code;
    $errors = [
        301 => 'Moved permanently.',
        400 => 'Переданы некорректные данные. Подробности доступны в теле ответа',
        401 => 'Пользователь не авторизован',
        403 => 'The account is blocked, for repeatedly exceeding the number of requests per second.',
        404 => 'Not found.',
        500 => 'Internal server error.',
        502 => 'Bad gateway.',
        503 => 'Service unavailable.'
    ];
    
    $arr_result = json_decode($out, true);
    // echo "<pre>";
    // print_r($arr_result);
    
    if ($code < 200 || $code > 204) {
       echo "<br><br>";
    
       echo "<pre>";
       print_r($arr_result);
       die( "Error $code. " . (isset($errors[$code]) ? $errors[$code] : 'Undefined error') );
    }
    
    return $arr_result;
    }