<?php
function InsertOurEmailInDB ($pdo,$new_email_arr){
  // Функция добавляет новый телефон в базу данных
    
  // $new_telephone = telephoneMake($new_telephone_arr['new_telephone']); // приводит к стандартному виду
  $new_email = $new_email_arr['new_email']; 
  // приводит к стандартному виду


  
if (preg_match("/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/i", $new_email))
      {
        //все ОК, email правильный
      }
    else
      {
        exit("ЕМАЙЛ (<b>".$new_email."</b>) НЕ ВАЛИДНЫЙ"); 
      //проверка email на правильность НЕ пройдена
      }

  // Вычитываем все телефоны с таким ИНН
  $stmt = $pdo->prepare("SELECT email FROM email WHERE inn = ?");
  $stmt->execute([$new_email_arr['InnCustomer']]);
  $email_db = $stmt->fetchAll(PDO::FETCH_COLUMN);
  
  $priz = 0; // Признак, что телефон неповторяется
  
  // Прогоняем email по остальным телефонам с этим ИНН, чтобы исключить повторы
    if (isset($email_db)) {
        foreach ($email_db as $key => $email_) {
          if ($new_email == $email_) { 
            $priz = 1; // Если нашли такойже email
           } 
        }
     }
  
  //  Если совпадений не было , то добавляем email
  if ($priz <> 1) {
  
    // Добавляем новый телефонв БД email
  $stmt  = $pdo->prepare("INSERT INTO `email` (inn, email, comment, date_write ,actual)
                          VALUES (:inn, :email, :comment, :date_write, :actual)");
          $stmt ->bindParam(':inn', $new_email_arr['InnCustomer']);
          $stmt ->bindParam(':email', $new_email);
          $stmt ->bindParam(':comment', $new_email_arr['commentPhone']);
          $stmt ->bindParam(':date_write', $new_email_arr['today']);
          $stmt ->bindParam(':actual', $new_email_arr['actual']);
  
        $stmt ->execute(); 
  if (!$stmt) {
    $info = $stmt->errorInfo();
     print_r("ОШИБКА ПРИ ДОБАВЛЕНИИ EMAIL".$info);
    }
  
    } else {
      die("ТАКОЙ EMAIL УЖЕ СУЩЕСТВУЕТ");
    }
  
  }