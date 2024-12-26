<?php
  // ИНН  и проверяем есть ли он в базе данных с таким ИНН
function InsertOurTelephoneInDB ($pdo,$new_telephone_arr){
// Функция добавляет новый телефон в базу данных
  $new_telephone = telephoneMake($new_telephone_arr['new_telephone']); // приводит к стандартному виду
  $new_telephone = DeleteFirstSymbol($new_telephone); // меняет 8 на 7 в первом символе
  $new_telephone = substr($new_telephone, 0, 17); // обрезает до нужной длины
 
// Вычитываем все телефоны с таким ИНН
$stmt = $pdo->prepare("SELECT telephone FROM telephone WHERE inn = ?");
$stmt->execute([$new_telephone_arr['InnCustomer']]);
$phone_db = $stmt->fetchAll(PDO::FETCH_COLUMN);

$priz = 0; // Признак, что телефон неповторяется

// Прогоняем телефон по остальным телефонам с этим ИНН, чтобы исключить повторы
  if (isset($phone_db)) {
      foreach ($phone_db as $key => $phone_) {
        if ($new_telephone == $phone_) { 
          $priz = 1; // Если нашли такойже телефон
         } 
      }
   }

   
//  Если совпадений не было , то добавляем телефон
if ($priz <> 1) {

  // Добавляем новый телефонв БД телефонов
$stmt  = $pdo->prepare("INSERT INTO `telephone` (inn, telephone, comment, whatsapp,  date_write ,name , actual)
                        VALUES (:inn, :telephone, :comment, :whatsapp,  :date_write, :name, :actual)");
        $stmt ->bindParam(':inn', $new_telephone_arr['InnCustomer']);
        $stmt ->bindParam(':telephone', $new_telephone);
        $stmt ->bindParam(':comment', $new_telephone_arr['commentPhone']);
        $stmt ->bindParam(':whatsapp', $new_telephone_arr['whatsapp']);
        $stmt ->bindParam(':date_write', $new_telephone_arr['today']);
        $stmt ->bindParam(':name', $new_telephone_arr['contactName']);
        $stmt ->bindParam(':actual', $new_telephone_arr['actual']);

      $stmt ->execute(); 
if (!$stmt) {
  $info = $stmt->errorInfo();
   print_r("ОШИБКА ПРИ ДОБАВЛЕНИИ НОМЕРА".$info);
  }

  } else {
    die("ТАКОЙ НОМЕР УЖЕ СУЩЕСТВУЕТ");
  }

}

function telephoneMake($value) {
  $value = preg_replace('/[^0-9]/', '', $value);
  $value = preg_replace('/[D]/', '', $value);
  $value = substr_replace($value, " ", 1, 0);
  $value = substr_replace($value, "(", 2, 0);
  $value = substr_replace($value, ")", 6, 0);
  $value = substr_replace($value, " ", 7, 0);
  $value = substr_replace($value, "-", 11, 0);
  $value = substr_replace($value, "-", 14, 0);
return $value;
  }

function DeleteFirstSymbol($value) {
 $toDelete = 1; // сколько знаков надо убрать
mb_internal_encoding("UTF-8");
$value = mb_substr( $value, $toDelete);
$value = trim($value);
$value = "7 ".$value;
return $value;
}
?>