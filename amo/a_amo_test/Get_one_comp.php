<?php
require_once 'access.php';
require_once 'amo_setup.php';

// require_once 'parts/functions.php';
require_once 'parts/functions_amo.php';
$connect_data['access_token'] = $access_token ;
$connect_data['subdomain'] = $subdomain;


$res = get_query_in_amo($access_token, $subdomain , "/api/v4/catalogs/".CATALOG_TOVARI."/elements");

echo "<pre>";
print_r($res);

