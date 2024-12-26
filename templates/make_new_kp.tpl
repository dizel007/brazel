

<form class ="contact_form" enctype="multipart/form-data" action="?transition=1" method="get" name="contact_form">
            <ul>
              <li>
              <input type="hidden" name="user_login" value="{$userdata['user_login']}">
              <input type="hidden" name="transition" value="1">   
                    {if isset($input_inn)}
                       <label> ИНН Заказчика : </label>
                       <input type="text" name="InnCustomer" value ="{$input_inn}">
                       
                    {else} 
                      <label> ИНН Заказчика : </label>
                      <input type="text" name="InnCustomer" value ="">
                      
                    {/if}
            
        	<button class="submit" type="submit">Запросить ИНН</button>
        </li>
                
   </ul>
      {if isset($input_inn)} 
         {if !isset($arr_inn_comp.0.inn)} 
          <ul class="red_string">
              <li>
                    Данный ИНН отсутствует в Базе
         <a class="input-line ghost-round" href="?transition=3&back_transition=1&user={$userdata['user_login']}&InnCustomer={$input_inn}" ><span class ="submit">Добавить?</span></a>
             {/if}
            {/if}                            
          </li>
       </ul>
</form>




{************************************* Основная форма     *********************************************}
{************************************* Основная форма     *********************************************}
{************************************* Основная форма     *********************************************}

<form class ="contact_form" enctype="multipart/form-data" action="pdo_connect_db/insert_new_kp_in_reestr.php" method="post">
   <ul>
         {*    ********************** Прячем тут ИНН если он был введен  ***************}    
              {if isset($arr_inn_comp.0.inn)}
                  <input type="hidden" name="InnCustomer" value="{$arr_inn_comp.0.inn}">  
              {else} 
                  <input type="hidden" name="InnCustomer" value="">  
              {/if}

 {*    ********************** Наименование Заказчика   ********************} 
 <li>
 <label>Наименование Заказчика :</label>
    {if isset($arr_inn_comp.0.inn)}
        <input required type="text" name="NameCustomer" value ="{$arr_inn_comp.0.name}">
    {else}
      <input required type="text" name="NameCustomer" value ="">
    {/if}
 </li>

 {*    ********************** Телефон Заказчика   ********************} 
<li>
  <label>Телефон Заказчика :</label>
    {if isset($tel_comp)}
      <input type="tel" name="TelCustomer" value ="{$tel_comp}" size="70">
    {else}
        <input type="tel" name="TelCustomer" value ="" size="70" data-phone-pattern>
    {/if}
</li>

 {*    ********************** Почта Заказчика   ********************} 
 <li>
  <label>Эл. Почта Заказчика :</label>
    {if isset($email_comp)}
    <input  type="text" name="EmailCustomer" value ="{$email_comp}" size="70">
    {else}
    <input  type="email" name="EmailCustomer" value ="" size="70">
    {/if}
 </li>
 {*    ********************** Контактное лицо Заказчика   ********************} 
  <li>
  <label>Контактное лицо :</label>
   <input type="text" name="ContactCustomer" value ="">
</li>



{*** Ответственный за КП *}
    <li>
      <label>Ответственный :</label>
        <select style="width:150px;" name="responsible" size="1">
            <option selected value="{$userdata['user_name']}">{$userdata['user_name']}</option>
         {for  $i=0 to $count_users-2}
              {* Удаляем повтор активного польвателя*}
             {if $active_user_logins_arr_smarty[$i] == $userdata['user_login']}
                {$i = $i + 1}
             {/if}
            <option value="{$active_user_names_arr_smarty[$i]}">{$active_user_names_arr_smarty[$i]}</option>
         {/for}
        </select>
    </li>   
 
{* Источник КП *}
       <li>
         <label>Источник КП :</label>
            <select size="1" name="type_kp">
            {$jj1 = 1}
               {for $i=0 to  (count($AllKptype)-1)}
                   {* Убираем отсюда объектные КП  *}
                  {if $AllValuesKptype.$i == 6}
                      {$jj1=$jj1+1}
                      {continue}
                   {/if}
                  <option value="{$AllValuesKptype.$i}">{$AllKptype.$i}</option>
               {/for}
            </select>
       </li>   

 {* Тип продукции *}
       <li>
         <label>Тип продукции :</label>
            <select size="1" name="product_type">
               {for $i=0 to  (count($AllProductTypesName)-1)}
                  <option value="{$AllProductTypesValue.$i}">{$AllProductTypesName.$i}</option>
               {/for}
            </select>
       </li>    

{********* номер и дата КП *}       
        <li>
           <label>Номер КП из 1С: </label>
           <input type="text" name="KpNumber" value ="" placeholder="При пропуске заполниться автоматически...">
           
        </li>
{*************** Дата КП *}
       <li>
       <label>Дата КП :</label>
      <input type="date" name="KpDate" value ="" >
       </li>
{********* важность КП *}
         <li>
           <label>Важность КП :</label>
            <select size="1" name="KpImportance">
              <option id="js-new-modal-KpImportance" selected value=""></option>  
              <option value="Нейтрально">Нейтрально</option>
              <option value="Важно">Важно</option>
              <option on value="Очень важно">Очень важно</option>
            </select>
          </li>


{*  ********************************** Адрес поставки ***************}
      <li > 
         <label>Условия отгрузки :</label>
         <textarea name="Adress" rows="2" cols="50"></textarea>
      </li>
      <li> 
         <label>Сумма доставки :</label>
         <input required type="number" name="DostCost" value ="">
      </li>





 {*    ********************** Приложить файл   ********************} 

 <li>              
      <input type="hidden" name="MAX_FILE_SIZE" value="500000">
      <label>файл заполненный по шаблону:</label>
      <input required name="upload_file" type="file">
      <span><a href="sample_files/temp_kp.xlsx" download>Скачать шаблон для КП</a></span>
 </li>
 <br>
    <button class="submit" type="submit">Создать</button>

</ul>
 </form>

      








         
