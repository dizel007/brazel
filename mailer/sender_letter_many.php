<?php

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

require_once("../connect_db.php"); // Заполняем наши переменные
require_once("../pdo_connect_db/select_functions.php"); // Подлючачем функции для работы с БД
require_once("modul/get_data.php"); // Заполняем наши переменные


$id=$_POST["id"];


// echo "<pre>";
// print_r($_POST);
// // print_r($_FILES);

// echo "<pre>";
// die();


@$count_dop_kp =  $_POST["count_dop_kp"];

// формируем список дополнительных КП
for ($i1 = 0; $i1 < $count_dop_kp; $i1++) {
    $index = "dop_kp_".$i1;
if (isset($_POST["$index"])) {
    $new_dop_kp[]=$_POST["dop_kp_".$i1];
}
}
// сомтрим нужно ли цеплять каталог
// if (isset ($_POST['catalog_present']) )
// {$catalog_present = $_POST['catalog_present'];}
// else {
//     $catalog_present = 0;    
// }
// // сомтрим нужно ли цеплять каталог по бордам
// if (isset ($_POST['catalog_bordur']) )
// {$catalog_bordur = $_POST['catalog_bordur'];}
// else {
//     $catalog_bordur = 0;    
// }
// // сомтрим нужно ли цеплять каталог по бордам
// if (isset ($_POST['catalog_inox']) )
// {$catalog_inox = $_POST['catalog_inox'];}
// else {
//     $catalog_inox = 0;    
// }



$Files_count = 0;
$i=0;

$active_user = GetUserByUser_login($pdo,$user_mail);

// Если у нас НЕ БЫЛ подгружен файл то загружаем файлы на сервер и добавим дальше их в письмо
if ($_FILES['upload_file']['name'][0] <> "") {
        for ($i=0; $i < count($_FILES['upload_file']['name']); $i++ ){
        $uploadfile = "../EXCEL/" . basename($_FILES['upload_file']['name'][$i]);
        $file_name = basename($_FILES['upload_file']['name'][$i]);
        $link_pppdf[$i] = "../EXCEL/". basename($_FILES['upload_file']['name'][$i]);

            if (move_uploaded_file($_FILES['upload_file']['tmp_name'][$i], $uploadfile)) {
                // echo "Файл корректен и был успешно загружен.\n";
                $Files_count++;
                if ($Files_count == count($_FILES['upload_file']['name'])) {
                    //   header("Location: ../index.php?fullload=777"); exit();
                    } 
                } else {
                echo '<pre>';
                    echo "Некоторая отладочная информация:\n";
                    print_r($_FILES);
                echo "</pre>";
            }
      }
}

// Настройки PHPMailer

$mail = new PHPMailer\PHPMailer\PHPMailer();


try {






$mail->CharSet = 'utf-8';
// $mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP(); 



if (strpos($active_user[0]['user_online_email'], 'anmaks.ru' ))
{
        // $mail->Port = 25;  // TIMEWeb
        // $mail->Host = 'smtp.timeweb.ru';  // TimeWeb
        // $mail->Host = 'ssl://smtp.timeweb.ru';
        $mail->Host = 'ssl://smtp.yandex.ru';

        $mail->Port = 465;

        // die('ddd');
        // $imap_setup=777; // Признак, что на почту нужно положить отправленное письмо
} else {
        $mail->Port = 25;  // NETANGELS
        $mail->Host = 'mail.netangels.ru';  // Specify main and backup SMTP servers
        // $imap_setup=0; // Признак, что на почту нужно положить отправленное письмо
    
}

$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $active_user[0]['user_online_email'];                 // Наш логин
$mail->Password = $active_user[0]['pass_online'];                 // Наш пароль от ящика
//
// $mail->Port = 25;  // TIMEWeb
// $mail->Port = 25;  // NETANGELS

$mail->setFrom($active_user[0]['user_online_email'], 'Компания АНМАКС');   // От кого письмо 

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject_theme; // тема письма
$mail->Body    = $body_post;
$mail->addAddress($email_from_kp);     // Add a recipient



$mail->AltBody = $body_post; // не HTML Письма *****************************************

$comment_change_temp = '';
// ******************************** если файл уже был на сервере
if (isset($link_pdf)) {
    $mail->addAttachment("../".$link_pdf);
    $comment_change_temp = (substr($link_pdf ,6))."<br>";
    $files_arr[]=substr($link_pdf ,6); // список файлов отправленных

}
// ************************* Цепляем файлы с КП  *************************************
if ($_FILES['upload_file']['name'][0] <> "") { 
   for ($i=0; $i < count($link_pppdf); $i++) {
      $mail->addAttachment($link_pppdf[$i]);
      $comment_change_temp = $comment_change_temp.substr($link_pppdf[$i] , 9)."<br>";         // Add ttachments
      $files_arr[]=substr($link_pppdf[$i] , 9); // список файлов отправленных
                 // Add attachments
     }
   } 
 
// ************************* Цепляем Дополнительне КП  *************************************
   if (isset($new_dop_kp)) { 
        foreach ($new_dop_kp as $dop_kp) {
            $mail->addAttachment('../EXCEL/'.$dop_kp);
            $files_arr[]=$dop_kp; // список файлов отправленных         
            $comment_change_temp = $comment_change_temp.$dop_kp."<br>";
            
        }
      }


// ************************* Цепляем Презентацию *************************************
if ($_POST['catalog']>0) {
 switch($_POST['catalog']){
 case 1: {
    $mail->addAttachment('../catalogs/ANMAKS_2023_business_card.pdf');
    break;
 }
 case 2: {
    $mail->addAttachment('../catalogs/anmaks_bord_catalog_2023_compressed.pdf');
    break;
 }
 case 3: {
    $mail->addAttachment('../catalogs/anmaks_inox_2023.pdf'); 
    break;
 }
 case 4: {
    $mail->addAttachment('../catalogs/anmaks_clean.pdf'); 
    break;
 }

 }
}
//     if ($catalog_present == 1) { 
//          $mail->addAttachment('../catalogs/ANMAKS_2023_business_card.pdf');         // Add attachments
//         }
// // ************************* Цепляем каталог бордюров ************************************* 
//     if ($catalog_bordur == 1) { 
//         $mail->addAttachment('../catalogs/anmaks_bord_catalog_2023_compressed.pdf');         // Add attachments
//         }
// // ************************* Цепляем каталог бордюров ************************************* 
// if ($catalog_inox == 1) { 
//     $mail->addAttachment('../catalogs/anmaks_inox_ 2023.pdf');         // Add attachments
//     }


    if ($mail->send()) 
        {
            $result = "НОРМА";
            // echo "СООБЩЕНИЕ ОТПРАВЛЕНО на адрес : ". $email_from_kp;
            $status ="OK";
            $id_item = $id;
            $what_change = 7;  // 7 - значит отправка почты
            $comment_change = "Отправлен Email на адрес : ". $email_from_kp."<br>"; 
            // Цепляем, что отправили
            // если файл уже был на сервере
            $comment_change = $comment_change.'Файлы в составе письма :'."<br>";
            $comment_change = $comment_change.$comment_change_temp;

            $author = $user_mail;
              
            require "../pdo_connect_db/insert_reports.php"; 
            require "../pdo_connect_db/update_email_count_in_reestr.php";


            // if ($imap_setup == 777) {
            //     require_once 'imap.php'; // делаем вставку пиьсма в почтовый ящик для Imap
            // }


            header('Location: ../index.php?transition=24&id='.$id);


        } else {
            $result = "ОШИБКА!!!!";
            echo "ОШИБКА ОТПРАВКИ";
            $status ="$mail->ErrorInfo";

            $id_item = $id;
            $what_change = 7;  // 7 - значит отправка почты
            $comment_change = "ОШИБКА отправки на адрес : ". $email_from_kp;
            
            $author = $user_mail;
              
            require "../pdo_connect_db/insert_reports.php";
        }
  

    
  
        // require_once ("modul/mail_logger.php"); // логирование отправки





}
 catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}
echo json_encode(["result" => $result, "status" => $status]);

?>