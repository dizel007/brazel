<?php
function setup_SQL_query_analitika ($get_responsible, $get_date_start, $get_date_end){
 $sql ="";
$where = "";
// Если нет никаких дат, то ставим дату сегодняшняя
if (($get_date_start == '') &&  ($get_date_end =='')) {
  $now=date('Y-m-d');
  $get_date_start = $now;
  $get_date_end = $now;
} 
// формируем SQL запрос
  if ($get_responsible <>'') $where = addWhere($where, "author = '".$get_responsible."'");
  
  if ($get_date_start<>'') $where = addWhere($where, "date_change >='".$get_date_start."'");

  if ($get_date_end<>'') $where = addWhere($where, "date_change <='".$get_date_end."'");

  // }
if ($where) {$sql .= " WHERE $where"." ORDER BY date_change DESC";}
else {
  $sql .= " ORDER BY date_change DESC"; 
}

return $sql;
}