<?php

$page_items = PAGE_ITEMS;
$pageCount= $kpCount/$page_items; // 
$pageCount = ceil($pageCount); // округление ввех
$url = remove_key("pageNumber"); // удаляем из URL ключ с номером страницы
$url = removeDomain($url); // удаляем из URL  наименование сайта

/// Выводим номера страниц если больше одной 
if ($pageCount>1) {
echo "<div class=\"pageNumber\">";
for ($i=0; $i<$pageCount; $i++){
  $i1 = $i+1;
      if ($i1 == $pageNumber) {
      echo "<a class=\"bigNumber\" href=\"$url&pageNumber=$i1\">$i1 </a>";
      } else {
      echo "<a class=\"normalNumber\" href=\"$url&pageNumber=$i1\">$i1 </a>";
      }
}
echo "</div>";
}



?>