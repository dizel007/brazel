<?php
//  формируем SQL запрос в зависимости от предыдущего запроса  ******************************
function addWhere($where, $add, $and = true) {
  if ($where) {
    if ($and) $where .= " AND $add";
    else $where .= " OR $add";
  }
  else $where = $add;
  return $where;
}