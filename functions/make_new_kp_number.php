<?php
// доставем из базы новый номер КП
function make_new_kp_number($pdo) {
  $stmt = $pdo->prepare("SELECT last_kp_number FROM `sys_setup`");
  $stmt->execute();
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $KpNumber = $arr[0]['last_kp_number'] + 1;
return $KpNumber;
}

function update_kp_number_in_db ($pdo, $KpNumber) {
// die($KpNumber);
$stmt = $pdo->prepare("UPDATE `sys_setup` SET `last_kp_number` = :KpNumber");
$stmt->execute(array('KpNumber' => $KpNumber));
// die($KpNumber);
return 1;
}
// обновляем новый номер КП в БД
