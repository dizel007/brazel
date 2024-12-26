<?php

function check_by_sell($pdo, $InnCustomer) {
//  если этот признак снимает в этом КП или его просто не было
// то проверяем, если ли в других КП с этим ИНН этот признак 
if (($InnCustomer <> '') AND ($InnCustomer <> 0)) {
    $stmt = $pdo->prepare("SELECT * FROM `reestrkp` WHERE `KpCondition`= 'Купили у нас' AND `InnCustomer`= ?");
    $stmt->execute([$InnCustomer]);
    $my_inn_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data_arr = ['InnCustomer'=> $InnCustomer,];
    
    
    if (isset($my_inn_arr[0]['id'])) {
      $sql = "UPDATE `reestrkp` SET `second_sell`= 1 WHERE InnCustomer=:InnCustomer";
      $stmt= $pdo->prepare($sql);
       $stmt->execute($data_arr);

      $sql = "UPDATE `inncompany` SET `sell_comp`= 1 WHERE `inn`=:InnCustomer";
      $stmt= $pdo->prepare($sql);
       $stmt->execute($data_arr);


    } else {
      $sql = "UPDATE `reestrkp` SET `second_sell`= 0 WHERE InnCustomer=:InnCustomer";
      $stmt= $pdo->prepare($sql);
       $stmt->execute($data_arr);
      
      $sql = "UPDATE `inncompany` SET `sell_comp`= 0 WHERE `inn`=:InnCustomer";
      $stmt= $pdo->prepare($sql);
      $stmt->execute($data_arr);
   }
}
}
