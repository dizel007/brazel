<?php

// ******************* (SMARTY) Получаем активные СОСТОЯНИЯ КП (condition_kp) ******************
  $stmt = $pdo->prepare("SELECT conditionkp FROM condition_kp WHERE active = 1");
  $stmt->execute();
  $AllKpConditions = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $smarty->assign('AllKpConditions', $AllKpConditions);

// ******************* (SMARTY)Получаем Все активные ТИПЫ КП (объектные , почта звонок ....)
  $stmt = $pdo->prepare("SELECT type FROM type_kp WHERE active = 1 ORDER BY `value` DESC");
  $stmt->execute();
  $AllKptype = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $smarty->assign('AllKptype', $AllKptype);
// ******************* (SMARTY)Получаем Все активные ЗНАЧЕНИЯ (value) из таблицы ТИПЫ КП *****
  $stmt = $pdo->prepare("SELECT value FROM type_kp WHERE active = 1 ORDER BY `value` DESC");
  $stmt->execute();
  $AllValuesKptype = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $smarty->assign('AllValuesKptype', $AllValuesKptype);


// ******************* (SMARTY)Получаем Все активные value из таблицы типы продукции
  $stmt = $pdo->prepare("SELECT value FROM type_product WHERE active = 1 ORDER BY `value` DESC");
  $stmt->execute();
  $AllProductTypesValue = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $smarty->assign('AllProductTypesValue', $AllProductTypesValue);

// получаем все активные типы продукции (дренаж, пласт, борд, мет. борт ....)

// ******************* Получаем Все активные типы продукции 
  $stmt = $pdo->prepare("SELECT name FROM type_product WHERE active = 1 ORDER BY `value` DESC");
  $stmt->execute();
  $AllProductTypesName = $stmt->fetchAll(PDO::FETCH_COLUMN);
  $smarty->assign('AllProductTypesName', $AllProductTypesName);

  // echo "<pre>";
  // print_r($AllProductTypesValue);
  // echo "<pre>";







