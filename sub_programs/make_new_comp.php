<?php

// Если Есть ИНН заходим сюда после проверки ИНН
isset($_GET['id'])?$id=$_GET['id']:$id='';

isset($_GET['back_transition'])?$back_transition=$_GET['back_transition']:$back_transition='';
$smarty->assign("back_transition" , $back_transition);
if (isset($_GET['InnCustomer'])) {
  $input_inn = $_GET['InnCustomer'];
  
    // вычитываем все по введенному ИНН
    $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = :inn");
    $stmt->execute(array('inn' => $input_inn));
    $arr_inn_comp = $stmt->fetchAll(PDO::FETCH_ASSOC);
     // вычитываем телефоны и почты, если существует ИНН
    if (isset($arr_inn_comp[0])) {
      // Echo "Такая компания уже существует!";
      DIE('<br>***DIE ***Такая компания уже существует!СТОП по Вводу ИНН!!!');
    } else {
      // Если нет такой компании то передаем в форму шаблона ИНН
      $smarty->assign("input_inn", $input_inn); // суем введенный ИНН в шаблон
    }
}

// die('TUTA');

// require_once "pdo_connect_db/select_functions.php";
// require_once "smarty_docs/_include_folder_files.php";

    $pageName='Добавление новой компании по ИНН ';
    $smarty->assign("pageName", $pageName);
    $smarty->assign("id", $id); // ID нужно если прицепляем ИНН к КП
    
    $smarty->display('make_new_comp.tpl');




