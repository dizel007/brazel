<?php
function SetParametrsTable ($smarty, $array_with_all_kp) {

  $i=0;
  $realDate = date("m.d.y"); // Сегодняшняя дата
  $realDate=strtotime($realDate);
  // *********  НАЧИНАЕМ АНАЛИЗИРОВАТЬ МАССИВ С КП **************************
  foreach ($array_with_all_kp as $value) {
  // ************* Проверяем нужно ли выводить закрытые КП *********************
 
    // *************    делаем нормальный вывод комментария **************************
  // $Comment = (string)$arr_name[$i]['Comment'];
  $Comment = substr($value['Comment'], 2, strlen($value['Comment'])); // удаляем первые два символа комментария
  $Comment  = str_replace( "@!", "<br><hr>" , $Comment); // 
  $array_with_all_kp[$i]['Comment']  = str_replace( "||+", ";" , $Comment);
  // 
  // *************    Убираем нули , если не задана дата сл Звонка **************************
  if ($array_with_all_kp[$i]['DateNextCall'] == "0000-00-00") {
  $array_with_all_kp[$i]['DateNextCall'] = '';
  }
  // *************    Убираем нули , если не задана дата Окончания контакта **************************
  // if ($array_with_all_kp[$i]['dateFinishContract'] == "0000-00-00") {
  //   $array_with_all_kp[$i]['dateFinishContract'] = '';
  //   }

  // *************    Форматируем суммы  **************************
  $array_with_all_kp[$i]['KpSum'] = number_format($array_with_all_kp[$i]['KpSum']);
  $array_with_all_kp[$i]['TenderSum'] = number_format($array_with_all_kp[$i]['TenderSum']);

  // ************* делаем ссылку для скачивания PDF и EXCEL 
  // если cor_kol_kp = 0 то убираем 0
($array_with_all_kp[$i]['cor_kol_kp'] == 0)? $cor_kol_kp = '':$cor_kol_kp = $array_with_all_kp[$i]['cor_kol_kp'];

/// ДЕЛАЕМ КОСТЫЛЬ, что если нет JSON ссылки, то хцодим на ЕКСЕЛЬ сссылки
if ($array_with_all_kp[$i]['json_file'] == '') {
      $LinkKp[$i] = $array_with_all_kp[$i]['LinkKp'] ;

      $t_2 = str_replace( 'EXCEL/' , 'JSON_KP/',  $LinkKp[$i]);
      $t_2 = substr($t_2, 0, -4)."json";;
      $LinkJsonFile[$i] = substr($t_2, 0, -4)."json";
      $exist_excel_file[$i] = file_exists($t_2);
      $LinkKpPdf[$i] = substr($LinkKp[$i], 0, -4)."pdf";
      $exist_pdf_file[$i] =file_exists($LinkKpPdf[$i]); // Проверяем есть ли ПДФ файл
} else {
      $LinkKp[$i] = "JSON_KP/" . $array_with_all_kp[$i]['json_file'] . $cor_kol_kp.".json";
      $LinkKpPdf[$i] = "EXCEL/" . $array_with_all_kp[$i]['json_file'] . $cor_kol_kp.".pdf";
      $exist_excel_file[$i] = file_exists( $LinkKp[$i]); // проверяем есть ли JSON файл, чтобы потом сделать EXCEL из него

      $array_with_all_kp[$i]['LinkKp'] = "EXCEL/" . $array_with_all_kp[$i]['json_file'] . $cor_kol_kp.".xlsx";

   // делаем ссылку для скачивания JSON файла
      $LinkJsonFile[$i] = "JSON_KP/" . $array_with_all_kp[$i]['json_file'] . $cor_kol_kp.".json";
      $exist_pdf_file[$i] =file_exists($LinkJsonFile[$i]); // Проверяем есть ли ПДФ файл
  }

    
//  echo   $LinkJsonFile[$i] ."<br>";
  


  // ************** Проверяем актуальность КП (Если не актуально то закрасим серым цветом)
  $statusKpClass[$i]='';      // нужен при следующей проверке
  $DateNextCallTable[$i]=''; // нужен при следующей проверке
      if ($array_with_all_kp[$i]['StatusKp'] == "КП сформировано" ||
      $array_with_all_kp[$i]['FinishContract'] == 1 || 
      $array_with_all_kp[$i]['KpCondition'] =="Не требуется" || 
      $array_with_all_kp[$i]['KpCondition'] =="Уже купили")  
        {  //// красим цветом статус КП
                $statusKpClass[$i] = "BlinkColor";
        }  

  //  ************* Проверяем дату следующего звонка ... Если пора звонить, то красим в Красный (если КП актуально)
  $tempDate = ($array_with_all_kp[$i]['DateNextCall']);
  $tempDate=strtotime($tempDate);

  // проверяем не нуливая ли дата (пустую Дату не красим в КРасный цвет)
  if (date('Y-m-d', $tempDate) <> '')  
    {  
          if (($tempDate < $realDate) && ($statusKpClass[$i] <> "BlinkColor")){
            $DateNextCallTable[$i] = "alarmcolor";
          } else { 
            $DateNextCallTable[$i] = "";  
          }
    }  else {
        $DateNextCallTable[$i] = "";  
        }

  // ************* **  /// ЕСЛИ КУПИЛИ У НАС ТО КРАСИМ ЗЕЛЕНЫМ
  $KpConditionTable[$i] = '';
    if ($array_with_all_kp[$i]['KpCondition'] == "Купили у нас")
    {  //// красим цветом статус КП
          $KpConditionTable[$i] = "buyour";
    }
  
  // ************* Делаем чередование строк
  if(($i % 2) == 0) {
  $StringColor[$i] = "DrawLight";
  } else {
  $StringColor[$i] = "DrawDark";
  }
  // ************* Красим шрифт в строке в зависимости от важности
  if ($array_with_all_kp[$i]['KpImportance'] == "Важно") {
    $KpImportanceTable[$i] = "RedColor";}

      elseif ($array_with_all_kp[$i]['KpImportance'] == "Очень важно") {
        $KpImportanceTable[$i] = "GreenColor";}
      else {
        $KpImportanceTable[$i] = '';}
  // ************* Подсвечиваем компании которым раньше продавали  *********** 
    if ($array_with_all_kp[$i]['second_sell'] == 1) {
      $second_sell_cl[$i] = 'sell_comp';}  
    else {
    $second_sell_cl[$i] = '';} 
    
  // *************
  ///****** ограничиваем длину строки адреса ***************************************** */
  
  $array_with_all_kp[$i]['adress'] = str_replace("доставка до объекта Заказчика", "*", $array_with_all_kp[$i]['adress']);
  $array_with_all_kp[$i]['adress_full'] = $array_with_all_kp[$i]['adress'] ;
    if (mb_strlen($array_with_all_kp[$i]['adress']) > 60){
   

    $array_with_all_kp[$i]['adress'] = mb_strimwidth($array_with_all_kp[$i]['adress'], 0, 50) . '...';
    }

  $i++;
  }

// *******************   Отправляем в смарти массивы со ссылками на КП *********************
$smarty->assign("LinkKp", $LinkKp);
$smarty->assign("LinkKpPdf", $LinkKpPdf);
$smarty->assign("exist_pdf_file", $exist_pdf_file);
$smarty->assign("exist_excel_file", $exist_excel_file);
// *******************   Отправляем в смарти массив c закрытыми бледными КП *********************
$smarty->assign("statusKpClass", $statusKpClass);
// *******************   Отправляем в смарти массив c КП по которым просрочен звонок*********************
$smarty->assign("DateNextCallTable", $DateNextCallTable);
// *******************   Отправляем в смарти массив окрашенных цветом купленных КП *********************
$smarty->assign("KpConditionTable", $KpConditionTable);
// *******************   Отправляем в смарти массив c переменными цветами строк ********************
$smarty->assign("StringColor", $StringColor);
// *******************   Отправляем в смарти массив с цветом строки в завис.. от важности **************
$smarty->assign("KpImportanceTable", $KpImportanceTable);
// *******************   Отправляем в смарти массив с цветом RG которым раньше продавали **************
$smarty->assign("second_sell_cl", $second_sell_cl);
// *******************   Отправляем в смарти массив с КП  *********************
$smarty->assign("array_with_all_kp", $array_with_all_kp);

} 