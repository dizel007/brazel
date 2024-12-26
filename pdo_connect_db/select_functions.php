<?php

//  Получаем список КП
function GetAllProducts($pdo,$table_name) {
    $stmt = $pdo->prepare("SELECT * FROM $table_name ORDER BY KpData DESC LIMIT 100");
    $stmt->execute([]);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}
//  Получаем список активных пользователей
function GetAllUsers($pdo,$table_name) {
  $stmt = $pdo->prepare("SELECT * FROM $table_name WHERE `user_active` = 1 ");
  $stmt->execute([]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $arr;
}
// Запрос выборочных КП
function GetSelectedKP($pdo,$sql) {
  $stmt = $pdo->prepare("SELECT * FROM reestrkp".$sql);
  $stmt->execute([]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
  }
  
//  Получаем КП по id
function GetKPById($pdo,$id) {
    $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE id = ?");
    $stmt->execute([$id]);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $arr;
  }
  //  Получаем пользователя по user_login
function GetUserByUser_login($pdo,$user_login) {
  $stmt = $pdo->prepare("SELECT * FROM users WHERE user_login = ?");
  $stmt->execute([$user_login]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}

//  ********************************* Получаем КП по ИНН *******************************
  function GetKPByInn($pdo,$inn) {
    $stmt = $pdo->prepare("SELECT * FROM reestrkp WHERE InnCustomer = ? ORDER BY KpData DESC , CHAR_LENGTH(`KpNumber`) DESC, KpNumber DESC");
    $stmt->execute([$inn]);
    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $arr;
  }

//  Получаем Компанию по ИНН
function GetCompanyByInn($pdo,$inn) {
  $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = ?");
  $stmt->execute([$inn]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}

//  Получаем телефоны по ИНН
function GetTelephoneByInn($pdo,$inn) {
  $stmt = $pdo->prepare("SELECT * FROM telephone WHERE inn = ?");
  $stmt->execute([$inn]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}

//  Получаем Емайл по ИНН
function GetEmailByInn($pdo,$inn) {
  $stmt = $pdo->prepare("SELECT * FROM email WHERE inn = ?");
  $stmt->execute([$inn]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}

function GetAllParametrs($products,$param) {
  foreach ($products as $value) {
    $arr[] = (int)($value["$param"]);
  }
  $arr = array_unique($arr);
  asort($arr);
 return $arr;
}

function GetOneParamsProducts($pdo,$table_name,$value) {
  $stmt = $pdo->prepare("SELECT `name` FROM $table_name WHERE `value` = '$value' ");
  $stmt->execute([]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $param=$arr[0]['name'];
 return $param;
}

function GetOneItem($pdo,$id) {
  $stmt = $pdo->prepare("SELECT * FROM catalog WHERE `id` = ?");
  $stmt->execute([
    $id,
      ]);
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $arr;
}

// ******************* (SMARTY)Получаем Тип продукции по VALUE
function GetTypeProductByValue($pdo, $get_product_type) {
  $stmt = $pdo->prepare("SELECT name FROM type_product WHERE value = ?");
  $stmt->execute([$get_product_type]);
  $arr = $stmt->fetchAll(PDO::FETCH_COLUMN);
  return $arr;
}


// ******************* (SMARTY)Получаем Все активные value из таблицы типы КП
function GetOneValueKptype($pdo,$get_type_kp) {
  $stmt = $pdo->prepare("SELECT type FROM type_kp WHERE value = ?");
  $stmt->execute([$get_type_kp]);
  $arr = $stmt->fetchAll(PDO::FETCH_COLUMN);
  return $arr[0];
}

?>