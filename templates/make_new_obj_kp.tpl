<div class="zagolovok"> Создание нового Объектного КП </div>
 {*    ********************** ИНН Заказчика   ********************} 
    {include file="object_kp/check_inn.tpl"}
{*    ********************** Ввод Информации из парсера контур ********************} 
    {include file="object_kp/check_kontur_parser.tpl"}
{******************************** наша форма ввода данных *********************************************}


<form enctype="multipart/form-data" action="pdo_connect_db/insert_new_object_kp_in_reestr.php" method="post">

{*    ********************** Прячем тут ИНН если он был введен  ***************}    
{if isset($arr_inn_comp.0.inn)}
    <input type="hidden" name="InnCustomer" value="{$arr_inn_comp.0.inn}">  
{else} 
    <input type="hidden" name="InnCustomer" value="">  
{/if}
{*    ********************** Прячем тут ссылку на Контур если он был введен  ***************}    
{if isset($tender_data['KonturLink'])}
  <input type="hidden" size ="70" type="text" name="KonturLink" value ="{$tender_data['KonturLink']}">
{else} 
  <input type="hidden" name="KonturLink" value=""> 
{/if} 

 {*    ********************** Тип КП   ***************}    
<div class="block"> 

    <p class = "zhir">Источник КП :
        <select size="1" name="type_kp">
          <option selected value="6">объектное КП</option>
        </select>
    </p>
<br>
     {* Тип продукции *}
       <p class = "zhir">Тип продукции :
       
            <select size="1" name="product_type">
               {for $i=0 to  (count($AllProductTypesName)-1)}
                  <option value="{$AllProductTypesValue.$i}">{$AllProductTypesName.$i}</option>
               {/for}
            </select>
       </p>  


 </div>



{********************************  Данные о компании ********************************************************}
<div class="block green_bgc">
 {*    ********************** Наименование Заказчика   ********************} 
{if isset($arr_inn_comp.0.inn)}
 <p class="pad5px width15 zhir">Наименование Заказчика : <input disabled type="text"  value ="{$arr_inn_comp.0.name}" size="70">
 <input hidden type="text" name="NameCustomer" value ="{$arr_inn_comp.0.name}" size="70">
 </p>
{else}
 <p class="pad5px width15 zhir">Наименование Заказчика : <input required type="text" name="NameCustomer" value ="" size="70"></p>
{/if}


 {*    ********************** Телефон Заказчика   ********************} 
{if isset($tel_comp)}
 <p class="pad5px width15 zhir">Телефон Заказчика : <input type="tel" name="TelCustomer" value ="{$tel_comp}" size="70"></p>
 
{else}
<p class="pad5px width15 zhir">Телефон Заказчика : <input type="tel" name="TelCustomer" value ="" size="70" data-phone-pattern></p>
{/if}
 {*    ********************** Почта Заказчика   ********************} 
 {if isset($email_comp)}
 <p class="pad5px width15 zhir">Эл. Почта Заказчика : <input type="text" name="EmailCustomer" value ="{$email_comp}" size="70"></p>
 {else}
 <p class="pad5px width15 zhir">Эл. Почта Заказчика : <input type="email" name="EmailCustomer" value ="" size="70"></p>

 {/if}
 {*    ********************** Контактное лицо Заказчика   ********************} 
   <p class="pad5px width15 zhir">Контактное лицо   : <input type="text" name="ContactCustomer" value ="" size="70"></p>
</div>

 
{***************************************** Данные с сайта *********************************}
<div class="block green_object_kp">
<p class="pad5px width15 zhir">IdKp : <input required type="number" name="idKp" value ="" size="70"></p>

 {*    ********************** Номер тендера   ********************} 
{if isset($tender_data['tender_number'])}
 <p class="pad5px width15 zhir">Номер тендера : <input type="text" name="tender_number" value ="{$tender_data['tender_number']}" size="70">
 </p>
 
{else}
 <p class="pad5px width15 zhir">Номер тендера : <input required type="text" name="tender_number" value ="" size="70"></p>
{/if}


 {*    ********************** Наименование тендера  ********************} 
{if isset($tender_data['tender_descr'])}
 <p class="pad5px width15 zhir">Наименование тендера : <textarea name="tender_descr" cols="100" rows="3">{$tender_data['tender_descr']}</textarea></p>
 
{else}
<p class="pad5px width15 zhir">Наименование тендера : <textarea name="tender_descr" cols="72" rows="2"></textarea></p>
{/if}
 {*    ********************** НМЦК тендера   ********************} 
 {if isset($tender_data['tender_begin_price'])}
 <p class="pad5px width15 zhir">НМЦК тендер : <input type="text" name="tender_begin_price" value ="{$tender_data['tender_begin_price']}" size="70"></p>
 {else}
 <p class="pad5px width15 zhir">НМЦК тендер : <input type="text" name="tender_begin_price" value ="" size="70"></p>

 {/if}
 {*    ********************** Ссылка в ЕИС   ********************} 
 {if isset($tender_data['tender_link_eis'])}
  <p class="pad5px width15 zhir">Ссылка в ЕИС : <input type="text" name="tender_link_eis" value ="{$tender_data['tender_link_eis']}" size="70"></p>
 {else}
   <p class="pad5px width15 zhir">Ссылка в ЕИС : <input type="text" name="tender_link_eis" value ="" size="70"></p>
 {/if}

</div>



{*  ********************************** Адрес поставки ***************}
<div class="block">
     <div class="pad5px zhir"> 
      <p>Адрес поставки : </p> 
      {if isset($tender_data['tender_adress'])}
        <textarea name="Adress" rows="2" cols="115">{$tender_data['tender_adress']}</textarea>
    {else}
      <textarea name="Adress" rows="2" cols="115"></textarea>
    {/if}
      </div>
</div>
{*  ********************************** Цепляем файл  ***************}
 <div class="block">              
      <input type="hidden" name="MAX_FILE_SIZE" value="500000">
        файл заполненный по шаблону: <input required name="upload_file" type="file">
      <div><a href="sample_files/temp_kp.xlsx" download>Скачать шаблон для КП</a></div>
 </div>
 {*  ********************************** Кнопка Создать ***************}
    <div class="block"> 
       <p><input type="submit" value="Создать"></p>
    </div>
  </div>
 </form>

 {*  ******************************** Ссылка на возврат в реестр  ***************}
  <div class="block"> 
      <a class="zagolovok" href="index.php">Вернуться в реестр</a>
 </div>


              
