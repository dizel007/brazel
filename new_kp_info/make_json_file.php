<?php
function make_json_kp_file($products, $comparr, $user_responsible_arr, $hight_string)
{


//     echo "<pre>";
// print_r($comparr);
// die();



    $summa_kp = 0;

    foreach ($products as $prods) {
        $summa_kp +=  $prods['kol'] * $prods['price']; // рассчет суммы КП
    }

    $array['products'] = $products;
    $array['dop_info'] = $comparr;
    $array['user'] = $user_responsible_arr[0]['user_login'];
    $array['summa'] = $summa_kp;
    $array['hight_string'] = $hight_string;

    $json = json_encode($array, JSON_UNESCAPED_UNICODE);
    $json_link_filekp = "../JSON_KP/" . $comparr['json_file_next'] . ".json";
    file_put_contents($json_link_filekp, $json);


    return $summa_kp;
};
