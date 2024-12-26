<?php
function SetPageNumbers ($smarty, $array_with_all_kp, $page_number) {
  $kolvo_pages=0; // количество страниц
  $start_item_on_page =0; // начальное КП 
  $end_item_on_page=0;
  
  // ************* Берем количество элементов нового массива
  isset($array_with_all_kp)?$kpCount = count($array_with_all_kp): $kpCount = 0;
  if ($kpCount <= 0) {
    die ("НЕТ ТОВАРА ПО ВЫБРАННЫМ ПАРАМЕТРАМ ( DIE  в парам_майн_тайбл )");
    }
  // количество элементов на странице
  $page_items = PAGE_ITEMS;
  //  целое количество страниц 
  $kolvo_pages = intdiv(($kpCount-1), $page_items);
  if ($page_number <= $kolvo_pages) {
     $kolvo_items = $page_items-1;}
   else  {
     $kolvo_items = ($kpCount-1)%$page_items;
    }  
  $start_item_on_page = $page_number * $page_items - $page_items;
  $end_item_on_page = $start_item_on_page +  $kolvo_items;
  
  // *******************   Отправляем в смарти кол-во элементов нового массива **************

  $smarty->assign("kolvo_pages", $kolvo_pages); // количество страниц
  $smarty->assign("start_item_on_page", $start_item_on_page); // начальное КП 
  $smarty->assign("end_item_on_page", $end_item_on_page); // конечноое КП на странице
  
  }

  function remove_key($key) {
    parse_str($_SERVER['QUERY_STRING'], $vars);
    $url = strtok($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '?') . http_build_query(array_diff_key($vars,array($key=>"")));
    return $url;
  }
  
  function removeDomain($url) {
    $withoutProtocolDelimiter = str_replace('//', '', $url);
    $withoutProtocolDelimiter = str_replace('index.php', '', $url);
    
    // echo "ppp=".$withoutProtocolDelimiter."<br>";
    $jjj = substr($withoutProtocolDelimiter, strpos($withoutProtocolDelimiter, '/') + 1);
    // echo "jjj=".$jjj."<br>";
    $jjj = "?".substr($jjj, strpos($jjj, '/') + 1);
    // echo "ooo=".$jjj."<br>";
    return $jjj;
  }