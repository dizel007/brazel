<?php
$now=date('Y-m-d');
$smarty->assign('now' , $now);
$yesturday = date('Y-m-d', strtotime($now . '-1 day'));
$smarty->assign('yesturday' , $yesturday);
$last_week = date('Y-m-d', strtotime($now . '-7 day'));
$smarty->assign('last_week' , $last_week);
$last_month = date('Y-m-d', strtotime($now . '-30 day'));
$smarty->assign('last_month' , $last_month);

include_once 'functions/full_get.php'; // считваем все GET данные

/* Данные для ввода даты в шаблинизатор  */
($get_date_start=='')?$get_date_start=$now: $get_date_start=$get_date_start;
($get_date_end=='')?$get_date_end=$now: $get_date_end=$get_date_end;
$smarty->assign('get_date_start', $get_date_start);
$smarty->assign('get_date_end', $get_date_end);
$smarty->assign('arr_with_all_active_users', $arr_with_all_active_users);

if (isset($_GET['user_update'])) {
    $user_login = $_GET['user_update'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE `user_login`= '$user_login'");
    $stmt->execute();
    $arr_b = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // проверяем есть ли юхер с таким логином
    if (isset($arr_b[0])) {
        $arr_update_user  = $arr_b[0];
        // echo "<pre>" ;
        // print_r( $arr_update_user);
        $smarty->assign('arr_update_user', $arr_update_user);
        
        $smarty->display('setup_one_user_with_login.tpl');    
     
    } else { // если не нашил юхера по update_user
    
    $smarty->display('setup_one_user.tpl');
    }  

// если нет update_userra
} else {
    
    $smarty->display('setup_one_user.tpl');   

}



