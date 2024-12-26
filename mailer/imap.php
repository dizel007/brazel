<?php
    $path = "{imap.timeweb.ru:993/imap/ssl}";
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
if ($imapStream) {

    $dmy=date("d-M-Y H:i:s");

    // $boundary = "------=".md5(uniqid(rand()));
    $boundary = "--".md5(uniqid(time()));


    // foreach ($files_arr as &$value) {
    //     $value1 = "EXCEL\"".$value;
    //     $attachment = chunk_split(base64_encode($value1));
    // }
    
   
    $user_who_send_emal = $active_user[0]['user_online_email'];
    

    $msg = ("From: $user_who_send_emal\r\n"
        . "To: $email_from_kp\r\n"
        . "Date: $dmy\r\n"
        . "Subject: $subject_theme\r\n"
        . "MIME-Version: 1.0\r\n"
        . "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n"
        . "\r\n\r\n"
        . "--$boundary\r\n"
        . "Content-Type: text/html;\r\n\tcharset=\"UTF-8\"\r\n"
        . "Content-Transfer-Encoding: 8bit \r\n"
        . "\r\n\r\n"
        . "$body_post\r\n"
        . "\r\n\r\n");
        
       
for ($i=0;$i <count($files_arr);$i++) {
    $filename = $files_arr[$i];
    // $attachment = chunk_split(base64_encode("..\EXCEL".$filename));

     $msg.= ("--$boundary\r\n"
           ."Content-Transfer-Encoding: base64\r\n"
           ."Content-Disposition: attachment; filename=\"$filename\"\r\n"
           ."\r\n\r\n\r\n"
           ."$boundary\r\n\r\n");
}
        
  
    

    imap_append($imapStream, $path, $msg);
    imap_close($imapStream);
}