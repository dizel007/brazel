<?php
select_overdue_kp_now($smarty, $pdo, $userdata['user_name']);
select_overdue_kp_all($smarty, $pdo, $userdata['user_name']); 


function select_overdue_kp_now($smarty, $pdo, $user) {
  $date_now = date('Y-m-d');
  
  
  $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE Responsible =:Responsible AND DateNextCall <>'0000-00-00' AND DateNextCall =:date_now AND FinishContract = 0 ORDER BY KpData DESC");
  $stmt->execute(['date_now' => $date_now,
                  'Responsible' => $user]);
  $arr_overdue_now = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $smarty->assign('arr_overdue_now', $arr_overdue_now); 
  
  return $arr_overdue_now;
  
}


function select_overdue_kp_all($smarty, $pdo, $user) {
  $date_now = date('Y-m-d');

  $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE Responsible =:Responsible AND DateNextCall <>'0000-00-00' AND DateNextCall <:date_now AND FinishContract = 0 ORDER BY KpData DESC");
  $stmt->execute(['date_now' => $date_now,
                'Responsible' => $user]);
  $arr_overdue_all = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  $smarty->assign('arr_overdue_all', $arr_overdue_all); 

 return $arr_overdue_all; 
}
