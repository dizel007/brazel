<?php
require_once 'access.php';
// require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;


$method = "/api/v4/leads/2755251/notes"; 
$timestamp = '2023-04-19';
$currentTime = strtotime($timestamp );

$data_temp5[] = array(
    // "entity_id" => 2755251,
    "note_type" => "common",
    "params" => array("text" => "FIRAT_990888"),
             );
$data_temp5[] = array(
// "entity_id" => 2755251,
"note_type" => "common",
"params" => array("text" => "FIRAT_6662888"),
            );             
$data = json_encode($data_temp5, JSON_UNESCAPED_UNICODE);

echo $data;
$res= post_query_in_amo($access_token, $subdomain , $method , $data);



echo "<pre>";
print_r($res);

