<?php

$realDate = date("m.d.y");
$realDate=strtotime($realDate);
$tempDate = '';
$smarty->assign("realDate" , $realDate);
$smarty->assign("tempDate" , $tempDate);

// Если Есть ИНН заходим сюда после проверки ИНН
if (isset($_GET['InnCustomer'])) {
    $input_inn = $_GET['InnCustomer'];
    $smarty->assign("input_inn", $input_inn); // суем введенный ИНН в шаблон
  
    // вычитываем все по введенному ИНН
    $stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = :inn");
    $stmt->execute(array('inn' => $input_inn));
    $arr_inn_comp = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $smarty->assign("arr_inn_comp", $arr_inn_comp); 
    // вычитываем телефоны и почты, если существует ИНН
    if (isset($arr_inn_comp[0])) {
        $inn = $arr_inn_comp[0]['inn'];
//  Телефоны с БД
// ***************************************************  Телефоны с БД
// Выбираем сначала актуалыные
$stmt = $pdo->prepare("SELECT telephone FROM telephone WHERE inn = :inn AND actual =:actual1 ORDER BY 	date_write DESC");
$stmt->execute(array ('inn' => $inn,
                      'actual1' => 'Актуальный',
                      ));
$arr_inn_tel[] = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Потом все остальные которые не закрытые 
$stmt = $pdo->prepare("SELECT telephone FROM telephone WHERE inn = :inn AND actual <>:actual1 AND actual <>:actual2 AND actual <>:actual3 ORDER BY 	date_write DESC");
$stmt->execute(array('inn' => $inn,
                   'actual1' => 'Неактуальный',
                   'actual2' => 'Не звонить',
                   'actual3' => 'Актуальный'));
$arr_inn_tel[] = $stmt->fetchAll(PDO::FETCH_COLUMN);
// формируем массив, где сначала актаульные потом остальные
foreach ($arr_inn_tel as $value) {
    foreach ($value as $item) {
        $new_arr_inn_tel[]=$item;
          }
    }
// если есть телефоны, то оставляем два самых важных
if (isset($new_arr_inn_tel)){

    for ($i=0; $i<count($new_arr_inn_tel);$i++) {
        $new2_arr_inn_tel[$i] = $new_arr_inn_tel[$i];
        if ($i == 1) break;
    }
$tel_comp =implode(", ", $new2_arr_inn_tel); 

} else {
   $tel_comp =''; 
}

$smarty->assign("tel_comp" , $tel_comp);



//  ************************************  *** **  Почты из БД
// Выбираем сначала актуалыные
$stmt = $pdo->prepare("SELECT email FROM email WHERE inn = :inn AND actual =:actual1 ORDER BY date_write DESC");
$stmt->execute(array ('inn' => $inn,
                    'actual1' => 'Актуальная',
                    ));
$arr_inn_email[] = $stmt->fetchAll(PDO::FETCH_COLUMN);
// Потом все остальные которые не закрытые 
$stmt = $pdo->prepare("SELECT email FROM email WHERE inn = :inn AND actual <>:actual AND actual <>:actual1 ORDER BY date_write DESC");
$stmt->execute(array('inn' => $inn,
                   'actual' => 'Неактуальная',
                   'actual1' => 'Актуальная'));
 $arr_inn_email[] = $stmt->fetchAll(PDO::FETCH_COLUMN);

// формируем массив, где сначала актаульные потом остальные
foreach ($arr_inn_email as $value) {
foreach ($value as $item) {
$new_arr_inn_email[]=$item;
  }
}
// если есть телефоны, то оставляем два самых важных
if (isset($new_arr_inn_email)){

for ($i=0; $i<count($new_arr_inn_email);$i++) {
$new2_arr_inn_email[$i] = $new_arr_inn_email[$i];
if ($i == 1) break;
}
$email_comp =implode(", ", $new2_arr_inn_email); 

} else {
$email_comp =''; 
}

$smarty->assign("email_comp" , $email_comp);


    } else {
        // если нет такого ИНН, то формируем признак
    }
}
// подтянем данные с сайта контур
isset($_GET['KonturLink'])?$KonturLink=$_GET['KonturLink']:$KonturLink='';

// $temp = strpos($KonturLink,'https://zakupki.kontur.ru/');
// echo $temp;
// die();
if ($KonturLink <> ''){
       if (strpos($KonturLink,'https://zakupki.kontur.ru/') === false) {
        $alarm_message = "Поиск работает только на сайте Контура. Данный URL:<br><b>".$KonturLink."<br></b> не валидный!!";
        $smarty->assign("alarm_message" , $alarm_message);
        $smarty->assign("back_adress" , $_SERVER['HTTP_REFERER']);
        $smarty->display('alarm_message.tpl');
// echo "<pre>"        ;
// print_r($_SERVER);
// echo "<pre>"        ;
        Die();
       } else {
                require_once ("parsers/parser_kontur_query.php");
                $smarty->assign("tender_data" , $tender_data);
              }
}




    
$smarty->display('make_new_obj_kp.tpl');




