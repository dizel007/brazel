<?php
/* 
*  ======================================= 
*  Author     : Zelizko Dmitriy 
*  License    : Protected 
*  Email      : 1dizel007@gmail.com 
*  ======================================= 
* Подпрограмма отправки письма, которая запускается, если кто то ввел неправильный пароль при входе
*
*/ 


require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';


$stmt = $pdo->prepare("SELECT 	user_online_email,pass_online FROM users WHERE user_login='zeld'");
$stmt->execute([]);
$adm_user = $stmt->fetchAll(PDO::FETCH_ASSOC);

// echo "<pre>";
// print_r($adm_user);
// echo "<pre>";
// die();


$mail = new PHPMailer\PHPMailer\PHPMailer();


try {

$body_post = "LOGIN : <b>".$_POST['login']."</b> ПАРОЛЬ : <b>".$_POST['password']."</b><br><br>";

$body_post .= implode($_SERVER);
$user_online_email=$adm_user[0]['user_online_email'];
$pass_online = $adm_user[0]['pass_online'];

    $mail->CharSet = 'utf-8';
    // $mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP(); 
    
    
    

            $mail->Host = 'ssl://smtp.yandex.ru';
    
            $mail->Port = 465;
           
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = $user_online_email;                 // Наш логин
    $mail->Password = $pass_online;                 // Наш пароль от ящика
    $mail->setFrom($user_online_email, 'Компания АНМАКС');   // От кого письмо 
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject_theme; // тема письма
    $mail->Body    = $body_post;
    $email_from_kp = "dizel007@yandex.ru";
    $mail->addAddress($email_from_kp);     // Add a recipient
    $mail->AltBody = $body_post; // не HTML Письма *****************************************
       
    
    $mail->send() ;
           
        
    }
    catch (Exception $e) {
        // $result = "error";
        // $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
    }

?>