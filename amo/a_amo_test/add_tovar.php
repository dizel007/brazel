<?php
require_once 'access.php';
require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
require_once 'amo_setup.php';

$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;

$data_temp [] = array(
//*******************  Название товара   ************************************
        "name" => "Лоток для воды 88876655555555", 
        "custom_fields_values" => array(
// *******************  Артикул  товара *******************************************
                array("field_id" => SKU_TOVAROV, // Цена  товара
                "values" => array (array("value" => "824040-з"))
                ),

 //*******************  Группв  товара ************************************
            array("field_id" => GROUP_TOVAROV, 
                  "values" => array (array("value" => "Объектные"))
            ),
// *******************  Цена  товара *******************************************
            array("field_id" => PRICE_TOVAROV, // Цена  товара
                  "values" => array (array("value" => 0))
                 ),
//*******************  Единица измерения  товара ************************************
            array("field_id" => UNIT_TOVAROV, 
                  "values" => array (array("value" => "шт"))
                 )
        )
);


$data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);
$method = "/api/v4/catalogs/".CATALOG_TOVARI."/elements" ;
$res = post_query_in_amo($access_token, $subdomain , $method , $data);
$id_tovara = $res['_embedded']['elements'][0]['id'];

echo "<br><br>";
echo $id_tovara;
echo "<br><br>";

die();
$data_temp =  array( array(   
    "to_entity_id" => $id_tovara,
    "to_entity_type" => "catalog_elements",
    "metadata"=> array (
        "quantity" => 100,
        "catalog_id" => 12549
            )       

    ));
    
$data = json_encode($data_temp, JSON_UNESCAPED_UNICODE);

$method = "/api/v4/leads/39542327/link";

$res = post_query_in_amo($access_token, $subdomain , $method , $data);

echo "<pre>";
print_r($res);




