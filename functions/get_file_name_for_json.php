<?php



function get_file_name_for_json_file($value) {

    if ($value['json_file'] == '') {
        $link_for_kp = $value['LinkKp'];
        /// Преобразуем ссылку с эксель файла на ссылку json файла
        $link_for_kp = str_replace('EXCEL/', '',  $link_for_kp);
        $link_for_kp = "" . substr($link_for_kp, 0, -5);
      } else {
        $link_for_kp = $value['json_file'] . $value['cor_kol_kp'];
      }
return $link_for_kp;
}