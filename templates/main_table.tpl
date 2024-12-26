
<div class="">
        <div class="our_table">
        <table width="100%" class="drawtable employee_table">
          <thead>
            <tr class="DrawDark">
               <td class="hidden_class_column">пп</td>
               <td>№КП</td>
               <td><p title="Скачать EXCEL файл">Ex</p></td> 
               <td><p title="Посмотреть EXCEL файл">SJS</p></td>
               {* <td><p title="Количество изменений в КП">КИ</p></td>  *}
               <td><p title="Скачать счет">Сч</p></td> 
               <td width ="50" >Дата КП</td>
               <td width ="70" class="hidden_class_column">ИНН</td>
               <td><p title="Скачать PDF файл">PDF</p></td>
               <td><p title="Тип КП(Источник запроса)">Тип</p></td>
               <td><p title="Основной тип продукции в КП">ТП</p></td>
               <td>Наименование</td>
               <td><p title="Ссылка на источник закупки. Только для Объектных">Кон</p></td>
               <td><p title="Отправить КП. Время последней отправки письма">EM</p></td>
               {*<td><p title="Количество отправленных писем с реестра">SEm</p></td>*}
               <td class="hidden_class_column">Важность</td>
          
               <td class="hidden_class_column">Ответственный</td>
               <td>id</td>
               <td>Комментарий</td>
               <td><p title="Редактирование КП">Ред</p></td>
               <td width ="60" class="hidden_class_column">Сл.звонок</td>
               <td class="hidden_class_column">Состояние</td>
               <td>amo</td>
               <td>Сумма КП</td>
               <td><p title="Создать КП в эту же Компанию">ДКП</p></td>
               <td width ="40" class="hidden_class_column">НМЦК Закупки</td>
         {*    <td class="hidden_class_column">ДКЗ</td>      *}
             <td class="hidden_class_column">КЗ</td>       
         {*      <td width ="60" class="hidden_class_column">Финиш</td> *}
               <td>Ист</td>
               <td class="hidden_class_column">Адрес поставки</td>
                <td class=""><p title="Корректировка КП">ККП</p></td>
         </tr>
         </thead>
      <tbody>

 {for $i = $start_item_on_page to $end_item_on_page}
 {if $array_with_all_kp.$i.marker == 1}
   {$new_kp_marker = 'new_kp_marker'}
   {else}
   {$new_kp_marker = ''}
 {/if}
          <tr class ="{$new_kp_marker} {$KpImportanceTable.$i}  {$statusKpClass.$i} {$StringColor.$i}">
{*<!-- ***************************  порядковый норме  ************************************************* -->*}
               <td>{$i+1}</td>
 {*<!-- ***************************  Номер КП  ********************************************* --> *}             
       <td>{$array_with_all_kp.$i.KpNumber}</td> 
{*<!-- Проверяем есть ли файл с КП в формате ексель на сервере ************************************** -->*}

{*<!-- ***************************  EXCEL файл  ********************************************** --> *}  

         {if ({$exist_excel_file.$i} == 1) }
          <td><a href="open_excel/show_excel_kp.php?id={$array_with_all_kp.$i.id}" target="_blank"><img class="scale11" style = "opacity: 0.8" src="icons/table/excel.png" alt="Excel"></a></td>
         {else} 
       <td><img style = "opacity: 0.2" src="icons/table/excel.png" alt="Excel"></td>
        {/if} 
{*<!-- *************************** парсер JS файл  ********************************************** --> *}  

         {if ({$exist_excel_file.$i} == 1) }
             <td><a href="open_excel/parce_json_kp.php?id={$array_with_all_kp.$i.id}" target="_blank"><img class="scale11" style = "opacity: 0.8" src="icons/see_excel.png" alt="Excel"></a></td>
         {else} 
       <td><img style = "opacity: 0.2" src="icons/see_excel.png" alt="Excel"></td>
        {/if} 

{*<!-- ****************  Колчиство Изменений КП   **************************************** -->   *}
   {*<!--      <td><b>({$array_with_all_kp.$i.cor_kol_kp})</b></td> --> *}



{*<!-- Проверяем есть ли файл с КП в формате ексель на сервере ********Скачиваем счет -->*}
  {if ({$exist_excel_file.$i} == 1) }  
   <td><a href = "open_excel/make_schet.php?id={$array_with_all_kp.$i.id}"><img class="scale11" style = "opacity: 0.8" src="icons/table/schet.png" alt="Excel"></a></td>
        {else}
    <td><img style = "opacity: 0.2" src="icons/table/schet.png" alt="Excel"></td>
      {/if }  

{*<!-- ***************************  Дата КП  ************************************************* --> *}       
         <td>{$array_with_all_kp.$i.KpData}</td>
                                      <!--   --> 
{*<!-- ***************************  ИНН покупателя  ********************************************* --> *}       
       <td class="{$second_sell_cl.$i} hidden_class_column">
            
            {if $array_with_all_kp.$i.InnCustomer <> 0}
            
                  {$array_with_all_kp.$i.InnCustomer}
            {else}
                  &nbsp
            {/if}

       </td>
{*<!-- ***************************  PDF file  ***************************************** -->*}

         {if ({$exist_pdf_file.$i} == 1) }
             <td><a href="{$LinkKpPdf.$i}" target="_blank"><img class="scale11" style = "opacity: 0.8" src="icons/table/pdf.png" alt="Excel" ></a></td>
         {else} 
       <td><img style = "opacity: 0.2" src="icons/table/pdf.png" alt="Excel"></td>
        {/if} 
{*<!-- ***************************  Тип Прихода КП  ***************************************** -->*}
         {if ({$array_with_all_kp.$i.type_kp} > 0)  } 
            <td>
            <img class="" style = "opacity:0.6" src="icons/type_kp/{$array_with_all_kp.$i.type_kp}.png" alt="{$array_with_all_kp.$i.type_kp}">
             </td>
           {else}  
           <td></td>
          {/if}
{*<!-- ***************************  Тип Продукции в КП  ***************************************** -->*}
         {if ({$array_with_all_kp.$i.type_product} > 0)  } 
            <td>
               <img class="" style = "opacity:0.6" src="icons/type_product/{$array_with_all_kp.$i.type_product}.png" alt="{$array_with_all_kp.$i.type_product}">

                         </td>
           {else}  
           <td>нд</td>
          {/if}
{*<!-- ***************************  Наименование покупателя  ***************************************** -->*}
          <td width ="150">{$array_with_all_kp.$i.NameCustomer}</td>
          
{*<!-- ******************************  Icons konturLink   *********************************** -->*}

           {if ({$array_with_all_kp.$i.konturLink} <> '') } 
                  <td><a href= "{$array_with_all_kp.$i.konturLink}" alt="konturLink" target="_blank"><img class="scale11" style = "opacity: 0.8" src="icons/kontur.png" alt="SeeLinkKontur"></a></td>
             {else}
               <td><img class="" style = "opacity: 0.2" src="icons/kontur.png" alt="SeeLinkKontur"></td>
             {/if}


{*<!-- ******************************  Icons Email  *********************************************** -->*}
      
  {if $array_with_all_kp.$i.marker == 1}
       <td><img class="" style = "opacity: 0.8" src="icons/table/email_not.png" alt="Send_email_not" title=""></td>
 
   {else}
   
      <td class="">
      <a href= "?transition=23&id={$array_with_all_kp.$i.id}&InnCustomer={$array_with_all_kp.$i.InnCustomer}" target="_blank">
      <div class="scale11 container_link_img">
      <img class="" style = "opacity: 0.8" src="icons/table/email.png" alt="Send_email" >
      <div class="text_center_img" title="{$array_with_all_kp.$i.date_last_email}">{$array_with_all_kp.$i.email_count}</div>
      </div>
      
      </a></td>
   
   {/if}

      

      
 {*<!-- ******************************  Количество высланных Email  *********************************** -->*}
      {* <!-- <td>{$array_with_all_kp.$i.email_count}</td>  -->*}

 {*<!-- ********************************** ВАЖНОСТЬ КП ************************************************ -->*}
      <td  class="hidden_class_column" id = "js-KpImportance{$array_with_all_kp.$i.id}" width ="50" class="hidden_class_column">{$array_with_all_kp.$i.KpImportance}</td>     
 {*<!-- ********************************** ОТветственный  ********************************************* -->*}
     <td id= "js-Responsible{$array_with_all_kp.$i.id}" width="80" class="hidden_class_column">{$array_with_all_kp.$i.Responsible}</td>

 {*<!-- ******************************  ПАПКА для открытия КП  *************************************  -->*}
     <td><a name="{$array_with_all_kp.$i.id}" href="index.php?transition=10&id={$array_with_all_kp.$i.id}" target="_blank"><img class="scale11" src="icons/table/open_dir.png" style = "opacity: 0.6" alt="OPEN" title="Открыть КП id={$array_with_all_kp.$i.id}"></a></td> 
 {*<!-- ********************************** Комментарий  ************************************************ -->*}
      <td id = "js-comment{$array_with_all_kp.$i.id}" class ="limit_width text_left">{$array_with_all_kp.$i.Comment}</td>

 {*<!-- ********************************** Редактирование  *************************************** -->*}
<td><img id = "{$array_with_all_kp.$i.id}" data-modal = "write_comment" class="js-open-modal commentClass scale11" src="icons/table/change.png" alt="addCooment"></td> 

 {*<!-- ********************************** Дата следующего звонка  ******************************** -->*}

      <td id = "js-DateNextCall{$array_with_all_kp.$i.id}" width="60" class ="{$DateNextCallTable.$i}  hidden_class_column">{$array_with_all_kp.$i.DateNextCall}</td>
 {*<!-- ********************************** СОСТОЯНИЕ КП ********************************** -->*}
      <td class="hidden_class_column"> <div id = "js-KpCondition{$array_with_all_kp.$i.id}" class = "{$KpConditionTable.$i}">{$array_with_all_kp.$i.KpCondition}</div></td>
  
   
   
   {*<!-- ********************************** AMO crm ********************************** -->    *}
   {if $array_with_all_kp.$i.id_amo_lead <> 0}
   <td><a target="_blank" href= "https://anmaks.amocrm.ru/leads/detail/{$array_with_all_kp.$i.id_amo_lead}"><img style = "opacity: 0.8" src="icons/table/amo.jpg" alt="AmoCRM"></a></td>
   {else}

    <td><a target="_blank" href= "amo/a_amo_test/insert_new_ko_in_amo.php?id={$array_with_all_kp.$i.id}"><img style = "opacity: 0.2" src="icons/table/amo.jpg" alt="AmoCRM"></a></td>
   {* <td><img style = "opacity: 0.2" src="icons/table/amo.jpg" alt="AmoCRM"></td>; *}

   {/if}

  
  
  {*<!-- ********************************** СУММА КП ********************************** -->    *}  
      <td id = "js-KpSum{$array_with_all_kp.$i.id}" >{$array_with_all_kp.$i.KpSum}</td>

  {*<!-- ********************************** ДОбавить новое КП ************************************ -->*}


<td>
  {if $array_with_all_kp.$i.InnCustomer <> 0}
      <a href="?transition=1&user_login={$userdata['user_login']}&InnCustomer={$array_with_all_kp.$i.InnCustomer}">
           <img  style = "opacity: 0.5" class="scale11" src="icons/table/red_plus.png" alt="add_KP">
      </a>
    {else}
             &nbsp
    {/if}
      
</td> 




 {*<!-- ********************************** СУММА ТЕНДЕРА  ********************************** -->    *}  
      <td class="hidden_class_column">{$array_with_all_kp.$i.TenderSum}</td>

  {*<!-- ********************************** Дата окончания выполнения контракта ************** -->*}
{*{if (({$array_with_all_kp.$i.dateContract}<>"0000-00-00") && ({$array_with_all_kp.$i.dateContract}))}
      
     <td class="hidden_class_column" id = "js-dateContract{$array_with_all_kp.$i.id}"><img class="scale11" style = "opacity: 0.8" src="icons/table/dateContract.png" title="Дата Закл :{$array_with_all_kp.$i.dateContract}"></td>
        {else}
        <td class="hidden_class_column" id = "js-dateContract{$array_with_all_kp.$i.id}">
        <img style = "opacity: 0.2" src="icons/table/dateContract.png" title="Нет данных">
        </td>

      {/if} 
*}
      

{* ******************************  ФИНИШ Контракта   ********************************************* *}
    <td class="hidden_class_column" id = "js-FinishContract{$array_with_all_kp.$i.id}" >{$array_with_all_kp.$i.FinishContract}</td>

{* ******************************  ИСТОРИ КП  *************************************  *}
     <td><a name="{$array_with_all_kp.$i.id}" href="?transition=17&id={$array_with_all_kp.$i.id}" target="_blank"><img class="scale11" src="icons/table/history_kp.png" style = "opacity: 0.6" alt="История КП" title="История КП"></a></td> 
{* ****************************** Адрес поставки   ********************************************* -->*}
      <td class="hidden_class_column" id = "js-Adress{$array_with_all_kp.$i.id}" width ="150"  title="{$array_with_all_kp.$i.adress_full}" >{$array_with_all_kp.$i.adress}</td>
 {* <!-- ******************************  Корректировака КП  ********************************************* -->*}
  {*    <td> 
            <a href= "?transition=30&id={$array_with_all_kp.$i.id}" alt="Корректировка КП" target="_blank"><img class="scale11" style = "opacity: 0.8" src="icons/correct_kp.png" alt="SeeLinkKontur"></a>
      </td>
           *}
 <td>
 {*<!-- ***************************  EXCEL файл  ********************************************** --> *}  

 {if ({$exist_excel_file.$i} == 1) }
  <a href= "?transition=30&id={$array_with_all_kp.$i.id}" alt="Корректировка КП" target="_blank">
    <div class="scale11 container_link_img">
        <img class="scale11" style = "opacity: 0.8" src="icons/correct_kp.png" alt="Изменение КП">
        <div class="text_center_img" title="Изменение КП">{$array_with_all_kp.$i.cor_kol_kp}</div>
    </div>
  </a>
{else} 
  <img style = "opacity: 0.2" src="icons/correct_kp.png" alt="Изменение запрещено">
{/if} 
 
 
  </td>









       </tr>
    
 {/for}
          </tbody>
      </table>
  </div>
</div>