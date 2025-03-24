<?php
/********************************************************************************************************
  ********  Убираем ссылку на контур линк. Оставляем только номер закупки    **************
 ******************************************************************************************************/



require_once "../connect_db.php";
// Обновляем данные в талиблице. 


$stmt = $pdo->prepare("SELECT * FROM inncompany WHERE inn = $InnCustomer");
$stmt->execute([]);
$old_inn_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);




// НЕ ГОТОВО

die();



function update_link_kontur_zakupki ($link_kontur) {
  $zak_gov_link = str_replace('https://zakupki.kontur.ru/' , 'zakupki.gov.ru/epz/order/notice/ea20/view/common-info.html?regNumber=', $link_kontur );


 $sql = "UPDATE inncompany SET contactFace=:contactFace,
                              comment=:comment
                        WHERE inn=:inn";
$stmt= $pdo->prepare($sql);
$stmt->execute($data_arr);



}


$db_comment="";
      if ($old_inn_arr[0]['contactFace'] != $contactFace) { $db_comment.="конт.лицо :".$contactFace.";";}
      if ($old_inn_arr[0]['comment'] != $comment)    { $db_comment.=" комент :".$comment.";";}
// Если нет изменений, то ничего писать не будем
if ($db_comment <> "") {     
    $id_item = $InnCustomer;
    $what_change = 2; 
    $comment_change = $db_comment; 
    $author = $userdata['user_login'];
    require "insert_reports.php";
  }
header ("Location: ../?transition=10&id=".$id."&InnCustomer=".$InnCustomer);  // перенаправление на нужную страницу
exit();    // прерываем работу скрипта, чтобы забыл о прошлом

?>
