<?php
// Получаем и формируем все переменные из _GET запроса

// ************* получаем переменную об Тип запроса typeQuery **************************************
if (isset($_GET['typeQuery'])) {
  $typeQuery = $_GET['typeQuery'];
} else {
  $typeQuery = '';
}
$smarty->assign("typeQuery", $typeQuery);

// ************* получаем переменную о выводе закрытых КП **************************************
if (isset($_GET['get_FinishContract'])) {
  $get_FinishContract = $_GET['get_FinishContract'];
} else {
  $get_FinishContract = 0;
}
$smarty->assign("get_FinishContract", $get_FinishContract);

// ************* получаем переменную о Номере КП **************************************
if (isset($_GET['get_nomerKP'])) {
  $get_nomerKP = $_GET['get_nomerKP'];
} else {
  $get_nomerKP = '';
 }
$get_nomerKP = htmlspecialchars($get_nomerKP);
$smarty->assign("get_nomerKP", $get_nomerKP);

// echo "get_nomerKP=".$get_nomerKP."==<br>";


// ************* получаем переменную дата начала и окончания срока **************************************
if (isset($_GET['get_date_start'])) {
  $get_date_start = $_GET['get_date_start'];
} else {
  $get_date_start = '';
}
$smarty->assign("get_date_start", $get_date_start);

if (isset($_GET['get_date_end'])) {
  $get_date_end = $_GET['get_date_end'];
} else {
  $get_date_end = '';
}
$smarty->assign("get_date_end", $get_date_end);

// ************* получаем переменную об ИНН  **************************************
if (isset($_GET['get_inn'])) {
  $get_inn = $_GET['get_inn'];
} else {
  $get_inn = '';
}
$get_inn = htmlspecialchars($get_inn);
$smarty->assign("get_inn", $get_inn);
// ************* получаем переменную об ID RP  **************************************
if (isset($_GET['get_id_kp'])) {
  $get_id_kp = $_GET['get_id_kp'];
} else {
  $get_id_kp = '';
}
$get_id_kp = htmlspecialchars($get_id_kp);
$smarty->assign("get_id_kp", $get_id_kp);

// ************* получаем переменную об Ответственном  **************************************
if (isset($_GET['get_responsible'])) {
  $get_responsible = $_GET['get_responsible'];

  $temp = GetUserByUser_login($pdo,$get_responsible);// получаем руское имя ответственного
  @$get_name_responsible = $temp[0]['user_name']; // получаем руское имя ответственного

} else {
  $get_responsible = '';
}
$smarty->assign("get_responsible", $get_responsible);
$smarty->assign("get_name_responsible", @$get_name_responsible);

// ************* получаем переменную о типе КП  **************************************
if (isset($_GET['get_type_kp'])) {
  $get_type_kp = $_GET['get_type_kp'];
} else {
  $get_type_kp = '';
}
$smarty->assign("get_type_kp", $get_type_kp);


// ************* получаем переменную об Наименование Заказчика  **************************************
if (isset($_GET['get_name_zakazchik'])) {
  $get_name_zakazchik = $_GET['get_name_zakazchik'];
} else {
  $get_name_zakazchik = '';
}
$get_name_zakazchik = htmlspecialchars($get_name_zakazchik);
$smarty->assign("get_name_zakazchik", $get_name_zakazchik);

// ************* получаем переменную об Адрес поставкт  **************************************
if (isset($_GET['get_adres_postavki'])) {
  $get_adres_postavki = $_GET['get_adres_postavki'];
} else {
  $get_adres_postavki = '';
}
$get_adres_postavki = htmlspecialchars($get_adres_postavki);
$smarty->assign("get_adres_postavki", $get_adres_postavki);



// ****************** Формируем GEt запрос без номера страницы  **************************************

$url_param = $_SERVER['QUERY_STRING'];
$url_param_test = explode('&', $url_param);

foreach ($url_param_test as $value) {
  if ((strpos($value, 'page_number')) === false){
    $url_param_new[] = $value;
  }
}
$url_param = implode('&', $url_param_new); 
$smarty->assign("url_param", $url_param);
// ******************* ВЫЧИТЫВАЕМ номер старниц **************************

if (isset($_GET['page_number'])) {
  $page_number = $_GET['page_number'];
} else {
  $page_number = 1;
}
$smarty->assign("page_number", $page_number);

// ******************* ВЫЧИТЫВАЕМ id КП     **************************
if (isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  $id = '';
}
$id = htmlspecialchars($id);
$smarty->assign("id", $id);

// ******************* ВЫЧИТЫВАЕМ id_phone Для правки телефона     **************************
if (isset($_GET['id_phone'])) {
  $id_phone = $_GET['id_phone'];

} else {
  $id_phone = '';
}
$id_phone = htmlspecialchars($id_phone);
$smarty->assign("id_phone", $id_phone);

// ******************* ВЫЧИТЫВАЕМ id_email Для правки телефона     **************************
if (isset($_GET['id_email'])) {
  $id_email = $_GET['id_email'];

} else {
  $id_email = '';
}
$id_email = htmlspecialchars($id_email);
$smarty->assign("id_email", $id_email);

// ******************* ВЫЧИТЫВАЕМ номер страницы  **************************
// количество строк на странице

// количество строк на странице
if (isset($_GET['pageNumber'])) {
  $pageNumber = $_GET['pageNumber'];
} else {
  $pageNumber=1;
}

// Для аналитики выведем GET о состоянии КП ***
if (isset($_GET['get_KpCondition'])) {
  $get_KpCondition = $_GET['get_KpCondition'];
} else {
  $get_KpCondition='';
}
$smarty->assign("get_KpCondition", $get_KpCondition);

// ************* получаем переменную о типа продукции **************************************
if (isset($_GET['get_product_type'])) {
  if ($_GET['get_product_type'] == 0) {
    $_GET['get_product_type']=''; // сбрысываем это параметр
  }
  $get_product_type = $_GET['get_product_type'];
  $temp = GetTypeProductByValue ($pdo,$get_product_type);// получаем наименование типа товара по 
  @$get_product_type_name = $temp[0]; // получаем руское имя ответственного
} else {
  $get_product_type = '';
  $get_product_type_name = '';
}
$smarty->assign("get_product_type", $get_product_type);
$smarty->assign("get_product_type_name", $get_product_type_name);


// ************* получаем дану КП когда они были проданы **************************************

if (isset($_GET['get_date_sell_start'])) {
  $get_date_sell_start = $_GET['get_date_sell_start'];
}else {
  $get_date_sell_start='';
}


if (isset($_GET['get_date_sell_end'])) {
  $get_date_sell_end = $_GET['get_date_sell_end'];
}else {
  $get_date_sell_end='';
}
$smarty->assign("get_date_sell_start", $get_date_sell_start);
$smarty->assign("get_date_sell_end", $get_date_sell_end);