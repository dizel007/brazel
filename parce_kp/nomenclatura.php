<?php
require_once '../PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require_once '../connect_db.php';

(isset($_GET['words']))?$words=trim($_GET['words']):$words='';
for ($i22=0; $i22<100; $i22++) {
$words = str_replace('  ', ' ', $words); // тупо убираем двойные пробелы
}

(isset($_GET['kolvo_find']))?$kolvo_find=$_GET['kolvo_find']:$kolvo_find='';
(isset($_GET['FinishContract']))?$FinishContract=1:$FinishContract=0;
(isset($_GET['dateStart']))?$dateStart=$_GET['dateStart']:$dateStart='';
(isset($_GET['dateStop']))?$dateStop=$_GET['dateStop']:$dateStop=date('Y-m-d');
(@$_GET['dateStop'] == '')?$dateStop=date('Y-m-d'):$r=1;


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
($words=='')?die('Введите слова для поиска'):$words=$words;

// echo $dateStart;
// echo $dateStop;
// echo $FinishContract;
$where = "";

  if ($FinishContract  == '0') { // если ищем только в открытых КП
  $where = "AND `FinishContract` =:FinishContract";
  $stmt = $pdo->prepare("SELECT *  FROM reestrkp 
  WHERE `KpData` >=:dateStart AND `KpData` <=:dateStop $where");

   $stmt->execute(array(':dateStart' => $dateStart,
                         ':dateStop' => $dateStop,
                   ':FinishContract' => $FinishContract,
    ));

  } else { // если ищем по всме КП и закрытым тоже
    $stmt = $pdo->prepare("SELECT *  FROM reestrkp 
    WHERE `KpData` >=:dateStart AND `KpData` <=:dateStop");
  
     $stmt->execute(array(':dateStart' => $dateStart,
                           ':dateStop' => $dateStop,
      
      ));

      
  }
  
   
  $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($arr as $value ){
  $LinkKp = "../".$value['LinkKp'];
  if ($LinkKp == "../excel/") { $LinkKp ='';} // костыль чтобы не парсил папку

  if (file_exists($LinkKp)) { // если по ссылке есть файл с КП, то парсим его
      $xls = PHPExcel_IOFactory::load($LinkKp );
      $xls->setActiveSheetIndex(0);
      $sheet = $xls->getActiveSheet();
      $i=19;
      $stop = 0;
      $priz_name_kp=0;

while ($stop <> 1 ) {
  $stop = 0;

  $name = $sheet->getCellByColumnAndRow(3, $i)->getValue();

  if ($name == '') {
    $stop =1;
    break;
  }
  $name = "*".$name; //  костыль из-за кодирвки, почему то в рус языке первый символ игнориться в поиске строка в строке
  $ed_izm = $sheet->getCellByColumnAndRow(8, $i)->getValue();
  $kolvo = $sheet->getCellByColumnAndRow(10, $i)->getValue();
  $kolvo = str_replace(' ','',$kolvo);
  $kolvo = str_replace(',','.',$kolvo);

  // делаем проверку на вхождение нащих слов в наименование товара
  if ($words != '') {
    if (find_words_in_nomenclature($words, $name, $kolvo_find, $kolvo))  {
      $LinkKp = $value['LinkKp'];
      $priz_name_kp=1;
      
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

$i++;
}
  unset($prods);
} 
};


// if ((isset($prods_all)) OR ((count(@$prods_all)) == 0)) {
if ((!isset($prods_all))) {
  die('Нет данных для вывода');
}
echo "Количество найденных КП :".count(@$prods_all);

$prods_all = mod_words_strong($words, $prods_all); // Подчеркиваем найденные слова


//  echo "<pre>";
//  print_r($prods_all);
//  echo "<pre>";

$smarty->assign('prods_all', $prods_all);
$smarty->assign('pageName', 'Поиск продукции по номенклатуре');

$smarty ->display('../templates/find_nomeclaturu.tpl');



function mod_words($words) { // функция приводит строку к стандартному виду
  $temp_words = mb_strtolower($words);
  $temp_words = str_replace(' ', '', $temp_words);
  $temp_words = str_replace('–', '-', $temp_words);
  $temp_words = str_replace(array("\n","\r"), '', $temp_words);
 
  return $temp_words;
}


function find_words_in_nomenclature($words, $name, $kolvo_find, $kolvo) { // функция ищет вхождение всех слов поиска в строке наименования
$result = false;
$count_inputs=0; // сколько уникальных вхождений
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
  if (strpos(mod_words($name),mod_words($item))) {
    $count_inputs++;
  }
}
if ($count_inputs == $arr_count) {
  $result = true;
}
// проверяем соответствие количества товара, если оно забано
if (($kolvo_find <> 0) AND ($kolvo_find != $kolvo)) {
  $result = false;
}
  return $result;
}



function mod_words_strong($words, &$prods_all) { // функция выделяет слова жирным приводит строку к стандартному виду
$words = mb_strtolower($words);
$find_arr_words = explode(' ', $words); 

  foreach ($prods_all as &$items) {
    foreach ($items as &$one_item) {
      $one_item['name'] = substr($one_item['name'], 1);
      
     
      foreach ($find_arr_words as $f_word) {
    
        $one_item['name'] = str_replace($f_word, "<b><u>".$f_word."</u></b>", mb_strtolower($one_item['name']));
       
      }
    }
  }

  return $prods_all;
}


