<?php


require_once __DIR__ . '/phpqrcode/qrlib.php';

$qr_file_name = md5(rand(0, 100000000)).".png";
$qr_telephon = preg_replace("/[^,.0-9]/", '', $user_responsible_arr[0]['user_mobile_phone']);
// $whatsapp_link = 'whatsapp://send?phone='.$qr_telephon;
$tg_link = 'https://t.me/+'.$qr_telephon;

QRcode::png($tg_link, '../NEW_KP/'.$qr_file_name, 'Q' , '2' ,'1', false);
