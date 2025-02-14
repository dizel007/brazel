<?php
require_once("../connect_db.php");
$err = [];


$date_write =date('Y-m-d');

// echo "<pre>";
// print_r($_POST);
$user_id = $_POST['user_id'];


  $stmt = $pdo->prepare("SELECT * FROM users WHERE `user_id` = $user_id");
  $stmt->execute();

  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $user_login = $arr[0]['user_login']; // 



// ****************************************   Проверяем и обновляем пароли
$z = 0;
($_POST['password'] != '')? $password = $_POST['password']: $z = 1;
($_POST['repaet_password'] != '')? $repaet_password = $_POST['repaet_password']: $z = 1;

// если пароли есть, то обновляем их
if ($z == 0) {

    if ($password !== $repaet_password) { 
            $err[] = "Пароли не совпадают";
        } else {
    // Убераем лишние пробелы и делаем двойное хеширование
    $password_new = md5(md5(trim($password)));
    $data_arr = [
        'user_password'=> $password_new,
        'date_write'=> $date_write,
        'user_id' => $user_id
      ];

    $sql = "UPDATE users SET user_password=:user_password, date_write=:date_write WHERE user_id=:user_id";
        $stmt= $pdo->prepare($sql);
        
        if (!$stmt ->execute($data_arr))
        { 
            echo "<pre>";
            print_r($stmt->ErrorInfo()); 
            die("<br>Померли обновлении пароля");
        }


}

}




// Обновляем телефон пользователя 
if ($_POST['user_mobile_phone']!='')  {

    $user_mobile_phone = $_POST['user_mobile_phone'];
    $data_arr = [
        'user_mobile_phone'=> $user_mobile_phone,
        'date_write'=> $date_write,
        'user_id' => $user_id
      ];

    $sql = "UPDATE users SET user_mobile_phone=:user_mobile_phone, date_write=:date_write WHERE user_id=:user_id";
        $stmt= $pdo->prepare($sql);
 
        if (!$stmt ->execute($data_arr))
        { 
            print_r($stmt->ErrorInfo()); 
            die("<br>Померли обновлении телефона");
        }



} 
// Обновляем почту пользователя 
 if ($_POST['user_email']!='') {

  $user_email = $_POST['user_email'];
  $data_arr = [
      'user_email'=> $user_email,
      'date_write'=> $date_write,
      'user_id' => $user_id
    ];


    echo "<pre>";
      print_r($data_arr);


  $sql = "UPDATE users SET user_email=:user_email, date_write=:date_write WHERE user_id=:user_id";
      $stmt= $pdo->prepare($sql);

      if (!$stmt ->execute($data_arr))
      { 
          print_r($stmt->ErrorInfo()); 
          die("<br>Померли обновлении почты");
      }

 }


 //  Уходим в реестре
 header("Location: ../index.php?transition=6&user_update=".$user_login); exit();