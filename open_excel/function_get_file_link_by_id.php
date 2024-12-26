<?php

function get_filelink_kp_by_id ($pdo, $id) {

    $kp_data_t = GetKPById($pdo,$id);
    $kp_data = $kp_data_t[0];
    
    if ($kp_data['json_file'] == '') {
        $link_json_file = $kp_data['LinkKp'];
        /// Преобразуем ссылку с эксель файла на ссылку json файла
        $json_kp_file = str_replace( 'EXCEL/' , 'JSON_KP/',  $link_json_file);
        $json_kp_file = "../".substr($json_kp_file, 0, -4)."json";;
        
    } else {
        if ($kp_data['cor_kol_kp'] == 0) {
            $kp_data['cor_kol_kp'] = '';
        } 
        $json_kp_file = '../JSON_KP/' . $kp_data['json_file'] . $kp_data['cor_kol_kp'] . ".json";
    }
return $json_kp_file;
}