<?php

require_once ("main_info.php");


// ************************************** PDO ***********************************
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';
require_once 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

require_once 'PHPExcel-1.8/fpdf/fpdf.php'; // библиотккеа для создания ПДф файилов


 
      try {  
        $pdo = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $user, $password);
        $pdo->exec('SET NAMES utf8');
        } catch (PDOException $e) {
          print "Has errors: " . $e->getMessage();  die();
        }

// *************   проверяем зашел ли пользователь с паролем  ****************************************

if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) // Проверяем зарегистрирован ли пользователь
{   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_hash='" . $_COOKIE['hash'] . "' LIMIT 1");
    $stmt->execute([]);
    $userdata_temp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // $userdata = call_user_func_array('array_merge', $userdata); // Уменьшаем уровень вложенности массива  
$userdata =  $userdata_temp[0];       


// ***************   проверяем введеный хэш пароля с тем, что храниться в БД  ***************************
    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id']))
    {
        header("Location: login.php"); exit();
    }
  } else {
    header("Location: login.php"); exit();
  }

// *******************   Обновляем каждый раз Куку  *******************************
$hash= $_COOKIE['hash'];
$user_id_cook = $_COOKIE['id'];
setcookie("id", $user_id_cook, time() + 60 * 60 * 24, "/");
setcookie("hash", $hash, time() + 60 * 60 * 24, "/", null, null, true); 
 

// ***************************** Подключаем смарти **************************************
date_default_timezone_set('Europe/Moscow');
require 'libs/Smarty.class.php';
$smarty = new Smarty;
$smarty->force_compile = true;
$smarty->debugging =  false; // старт консоли отладчика
$smarty->caching = true;
$smarty->cache_lifetime = 120;
// **************************************
$typeQuery ="";
$smarty->assign('typeQuery', $typeQuery); // загружаем эту переменную чтобы в модальных окнах не было ошибок
$get_value_type_kp='';
$smarty->assign('get_value_type_kp', $get_value_type_kp); // загружаем эту переменную чтобы в модальных окнах не было ошибок

?>
