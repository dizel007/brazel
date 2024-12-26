<?php

$sql ="";
$where = "";
// if ($typeQuery <> '') {
  if ($get_date_sell_start <>'') $where = addWhere($where, "date_sell >='".$get_date_sell_start."'");
  if ($get_date_sell_end <>'') $where = addWhere($where, "date_sell <='".$get_date_sell_end."'");


  if ($get_FinishContract  == '0') $where = addWhere($where, "FinishContract =".$get_FinishContract);

  if ($get_nomerKP <>'') $where = addWhere($where, "KpNumber =".$get_nomerKP);
  
  if ($get_inn <> '' ) $where = addWhere($where, "InnCustomer =".$get_inn);

  if ($get_responsible <>'') $where = addWhere($where, "Responsible = '".$get_responsible."'");

  if ($get_id_kp <>'') $where = addWhere($where, "idKp = '".$get_id_kp."'");
 
  if ($get_type_kp <>'') $where = addWhere($where, "type_kp = '".$get_type_kp."'");
  
  if ($get_product_type <>'') $where = addWhere($where, "type_product = '".$get_product_type."'");

  if ($get_KpCondition <>'') $where = addWhere($where, "KpCondition = '".$get_KpCondition."'");
  
  if ($get_name_zakazchik <>'') $where = addWhere($where, "NameCustomer like '%".$get_name_zakazchik."%'");
  
  if ($get_adres_postavki <>'') $where = addWhere($where, "adress like '%".$get_adres_postavki."%'");

  if ($get_date_start<>'') $where = addWhere($where, "KpData >='".$get_date_start."'");

  if ($get_date_end<>'') $where = addWhere($where, "KpData <='".$get_date_end."'");

  // }
if ($where) {$sql .= " WHERE $where"." ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC";}
else {
  $sql .= " ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC"; 
}

// echo "<br>".$sql."(**** DELETE ****)<br>";

// die();




