<?php
/*
Вычитываем из таблицы всех активных пользователей
*/


  $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `user_active` = 1 ");
  $stmt->execute([]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($arr as $value) {
    $active_user_logins_arr_smarty[]  = $value ['user_login'];
    $active_user_names_arr_smarty[]  = $value ['user_name'];
    $active_user_login[$value ['user_login']] = $value ['user_name'];
  }


  $count_users = count($active_user_names_arr_smarty);
  $smarty->assign('active_user_logins_arr_smarty', $active_user_logins_arr_smarty);
  $smarty->assign('active_user_names_arr_smarty', $active_user_names_arr_smarty);
  $smarty->assign('active_user_login', $active_user_login);
  $smarty->assign('count_users', $count_users);
// echo "<pre>";
// print_r($active_user_login);
// echo "<pre>";
// die();
