<?php

if (!empty($_POST['id'])) {
  $id = $_POST['id'];
} 
if (!empty($_POST['Zakazchik'])) {
  $Zakazchik = $_POST['Zakazchik'];
  $Zakazchik = str_replace('%20',' ', $Zakazchik); // чтобы передавать длинные пути с пробелами
} 

if (!empty($_POST['email_from_kp'])) {
    $email_from_kp = $_POST['email_from_kp'];
  } 
  
if (!empty($_POST['email_from_kp_new'])) {
    $email_from_kp_new = $_POST['email_from_kp_new'];
    $email_from_kp_new = str_replace(' ','', $email_from_kp_new); // удаляем случайные пробелы
}
// если не выбран ни один Емайл
if ((empty($_POST['email_from_kp'])) and (empty($_POST['email_from_kp_new'])))
 {
  die("EMAIL  не выбран!!!!!!");
};

if (!empty($_POST['subject_theme'])) {
  $subject_theme = $_POST['subject_theme'];
}

if (!empty($_POST['link_pdf'])) {
    $link_pdf = $_POST['link_pdf'];
    $link_pdf = str_replace('%20', ' ', $link_pdf);
  }

  /// Имя пользователя
  if (!empty($_POST['user_mail'])) {
    $user_mail = $_POST['user_mail'];
  }
// Наименование закупки
if (!empty($_POST['ZakupName'])) {
    $ZakupName = $_POST['ZakupName'];
  }
// текст письма
if (!empty($_POST['bodypost'])) {
    $body_post = $_POST['bodypost'];


(isset($_POST['certifikat']))?$certifikat='<br><br>'.$_POST['certifikat']:$certifikat='';
(isset($_POST['better_offer']))?$better_offer= '<br><br>'.$_POST['better_offer']:$better_offer='';




    $dop_2_last='</b>'.$certifikat. $better_offer.
    '<br><br>
    С уважением<br>'.$userdata['ful_name'].'<br>'.$userdata['user_phone'].'<br>'.
    $userdata['user_mobile_phone'].'<br>'.$userdata['user_email'].'<br>'.
    '<a href="https://anmaks.ru">https://anmaks.ru</a><br>'.
    '<img border=0 src="https://tradestorm.ru/images/tovarlogo.jpg" alt="products_and_logo" useMap=#FPMap0>';
    
    // $body_post='<b>Добрый день!</b><br><br><b>'.$_POST['bodypost'].$dop_2_last;
    $body_post="<html>".$_POST['bodypost'].$dop_2_last."</html>";

  }
 
if (!empty($email_from_kp_new)) {
  $email_from_kp = $email_from_kp_new;
}

?>