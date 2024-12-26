<?php
require_once 'access.php';
// require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;


$method = "/api/v4/leads"; 
$timestamp = '2023-04-19';
$currentTime = strtotime($timestamp );

$data_temp5[] = array(
  "id" => 39277193,
  "status_id" => 60740610,
  "closed_at" => $currentTime
   
);
$data = json_encode($data_temp5, JSON_UNESCAPED_UNICODE);

echo $data;
$res= send_patch_in_amo($access_token, $subdomain , $method , $data);



echo "<pre>";
print_r($res);

