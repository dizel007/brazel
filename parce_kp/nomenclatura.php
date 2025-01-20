<?php

require_once '../connect_db.php';

(isset($_GET['words'])) ? $words = htmlspecialchars(trim($_GET['words'])) : $words = '';

// тупо убираем двойные пробелы
for ($i22 = 0; $i22 < 100; $i22++) {
  $words = str_replace('  ', ' ', $words);
}

(isset($_GET['kolvo_find'])) ? $kolvo_find = htmlspecialchars($_GET['kolvo_find']) : $kolvo_find = '';
(isset($_GET['FinishContract'])) ? $FinishContract = 1 : $FinishContract = 0;
(isset($_GET['dateStart'])) ? $dateStart = $_GET['dateStart'] : $dateStart = '';
(isset($_GET['dateStop'])) ? $dateStop = $_GET['dateStop'] : $dateStop = date('Y-m-d');
(@$_GET['dateStop'] == '') ? $dateStop = date('Y-m-d') : $r = 1;


echo <<<HTML
<form action="nomenclatura.php" method="get">
<label for="words">слова для поиска</label>
<input required type="text" name="words" value="$words">

<label for="kolvo_find"> Кол-во</label>
<input type="number" name="kolvo_find" value="$kolvo_find">

<label for="FinishContract">Искать в Закрытых КП</label>
<input type="checkbox" name="FinishContract">

<br><br>
<label for="dateStart">Дата начала</label>
<input type="date" name="dateStart">

<label for="dateStop">Дата окончания</label>
<input type="date" name="dateStop">


<input type="submit"  value="Отправить запрос">
</form>
<br>
HTML;
($words == '') ? die('Введите слова для поиска') : $words = $words;

// echo $dateStart;
// echo $dateStop;
// echo $FinishContract;
$where = "";

if ($FinishContract  == '0') { // если ищем только в открытых КП
  $where = "AND `FinishContract` =:FinishContract";
  $stmt = $pdo->prepare("SELECT *  FROM reestrkp 
  WHERE `KpData` >=:dateStart AND `KpData` <=:dateStop $where");

  $stmt->execute(array(
    ':dateStart' => $dateStart,
    ':dateStop' => $dateStop,
    ':FinishContract' => $FinishContract,
  ));
} else { // если ищем по всме КП и закрытым тоже
  $stmt = $pdo->prepare("SELECT *  FROM reestrkp 
    WHERE `KpData` >=:dateStart AND `KpData` <=:dateStop");

  $stmt->execute(array(
    ':dateStart' => $dateStart,
    ':dateStop' => $dateStop,

  ));
}


$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);


// echo "<pre>";
// print_r($arr);
// die();

$i=0;



// echo "<pre>";
foreach ($arr as $value) {

  if ($value['json_file'] == '') {
    $link_json_file = $value['LinkKp'];
    /// Преобразуем ссылку с эксель файла на ссылку json файла
    $json_kp_file = str_replace('EXCEL/', 'JSON_KP/',  $link_json_file);
    $json_kp_file = "../" . substr($json_kp_file, 0, -4) . "json";
  } else {
    $json_kp_file = '../JSON_KP/' . $value['json_file'] . $value['cor_kol_kp'] . ".json";
  }

  /////////////////////////////////// перебираем все файлы из выбранных КП (если они есть )
  // echo "i = $i * $json_kp_file<br>";

  if (file_exists($json_kp_file)) { 
    $temp_products_json = json_decode(file_get_contents($json_kp_file), true);
    // Если в JSON нет товаров то пропускаем
if (!isset($temp_products_json['products'])) {
  continue;
}
    foreach ($temp_products_json['products'] as $product_one) {
      $name = '**'.$product_one['name']; // добавляем звездочки для поиска косяк изза русского шрифта. без  звездочек не ищет первое слово
      

      $ed_izm = $product_one['ed_izm'];
      $kolvo = $product_one['kol'];
      $kolvo = str_replace(' ', '', $kolvo);
      $kolvo = str_replace(',', '.', $kolvo);
  
      // die();
      // делаем проверку на вхождение нащих слов в наименование товара


      if ($words != '') {

        if (find_words_in_nomenclature($words, $name, $kolvo_find, $kolvo)) {
          $LinkKp = $value['LinkKp'];
          $priz_name_kp = 1;
          $name = str_replace('**', '', $name); // убираем звездочки для поиска косяк изза русского шрифта. без  звездочек не ищет первое слово
          // массив для вывода на экран
          $prods[$value['id']][] =
            array(
              'name'  => $name,
              'kol' => $kolvo,
              'ed_izm' => $ed_izm,
              'LinkKp' => $value['LinkKp'],
            );

          // массив для шаблонизатора
          $prods_all[$value['id']][] =
            array(
              'name'  => $name,
              'kol' => $kolvo,
              'ed_izm' => $ed_izm,
              'LinkKp' => $value['LinkKp'],
              'KpNumber' => $value['KpNumber'],
              'KpData' => $value['KpData'],
              'adress' => $value['adress'],
              'id' => $value['id'],
              'Responsible' => $value['Responsible'],
              'InnCustomer' => $value['InnCustomer'],
              'NameCustomer' => $value['NameCustomer'],
              'type_product' => $value['type_product'],
              'type_kp' => $value['type_kp'],


            );
        
      }
    }
    }

    $i++;
  } // конец ифа, если файл существует
  
};
// echo "<pre>";
// print_r($prods_all);
// die();



// if ((isset($prods_all)) OR ((count(@$prods_all)) == 0)) {
if ((!isset($prods_all))) {
  die('Нет данных для вывода');
}
echo "Количество найденных КП :" . count(@$prods_all);

$prods_all = mod_words_strong($words, $prods_all); // Подчеркиваем найденные слова


//  echo "<pre>";
//  print_r($prods_all);
//  echo "<pre>";

$smarty->assign('prods_all', $prods_all);
$smarty->assign('pageName', 'Поиск продукции по номенклатуре');

$smarty->display('../templates/find_nomeclaturu.tpl');



function mod_words($words)
{ // функция приводит строку к стандартному виду
  // $temp_words = "*".$words;
  $temp_words = mb_strtolower($words);
  $temp_words = str_replace(' ', '', $temp_words);
  $temp_words = str_replace('–', '-', $temp_words);
  $temp_words = str_replace(array("\n", "\r"), '', $temp_words);

  return $temp_words;
}


function find_words_in_nomenclature($words, $name, $kolvo_find, $kolvo)
{ // функция ищет вхождение всех слов поиска в строке наименования
  $result = false;
  $count_inputs = 0; // сколько уникальных вхождений
  $find_arr = explode(' ', $words);
  // $count_find_arr = count($find_arr) - 1;
  // for ($i=0; $count_find_arr; $i++) {
  //   if ($find_arr[$i] == '') {
  //     unset($find_arr[$i]);
  //     $count_find_arr--;
  //   }
  // }


  $arr_count = count($find_arr);
  foreach ($find_arr as $item) {
    if (strpos(mod_words($name), mod_words($item))) {
      $count_inputs++;
    }
  }
  if ($count_inputs == $arr_count) {
    $result = true;
  }
  // проверяем соответствие количества товара, если оно забано
  if (($kolvo_find <> 0) and ($kolvo_find != $kolvo)) {
    $result = false;
  }
  return $result;
}



function mod_words_strong($words, &$prods_all)
{ // функция выделяет слова жирным приводит строку к стандартному виду
  $words = mb_strtolower($words);
  $find_arr_words = explode(' ', $words);

  foreach ($prods_all as &$items) {
    foreach ($items as &$one_item) {
      // $one_item['name'] = substr($one_item['name'], 1);


      foreach ($find_arr_words as $f_word) {

        $one_item['name'] = str_replace($f_word, "<b><u>" . $f_word . "</u></b>", mb_strtolower($one_item['name']));
      }
    }
  }

  return $prods_all;
}
