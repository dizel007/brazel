{* РИСУЕМ кнопку сброса *}
<div class="reset_button">
  <a href="index.php" title="Вернуться к началу страницы">СБРОС</a>
</div> 

<form class ="">
   <div class ="up_form_new">

{* *******************  Прячем сюда тип перехода        ************************** *}   

<input hidden type="text" name="transition" value="{$transitionForForm}">

 {* *******************  Меня ввода номер КП      ************************** *}
    
        <div id="g_nomerKP" class="mobile_web">
            <label for="param">номер КП : </label>
            <input size="6" type="text" id="get_nomerKP" name="get_nomerKP" value = "{$get_nomerKP}">
        </div>

{* *******************  Меня ввода Даты       ************************** *}
                <div id="g_dateKPs" class="mobile_web">
                    <label for="date_start">Дата начала : </label>
                    <input type="date" id="get_date_start" name="get_date_start" value = "{$get_date_start}">
                </div>
                <div id="g_dateKPe" class="mobile_web">
                    <label for="date_end">Дата окончания : </label>
                    <input type="date" id="get_date_end" name="get_date_end" value = "{$get_date_end}">
                </div>
        
 {* *******************  Меня ввода ИНН      ************************** *}
    
        <div id="g_inn" class="mobile_web">
            <label for="param">ИНН : </label>
            <input size="8" type="text" id="get_inn" name="get_inn" value = "{$get_inn}">
           

        </div>
 {* *******************  Меня ввода Наименование Заказчика     ************************** *}
    
        <div id="g_name_zakazchik" class="mobile_web">
            <label for="param">Заказчик : </label>
            <input size="10" type="text" id="get_name_zakazchik" name="get_name_zakazchik" value = "{$get_name_zakazchik}">
   
        </div>
 {* *******************  Меня ввода ID КП     ************************** *}
    
        <div id="g_id_kp" class="mobile_web">
            <label for="param">ID КП : </label>
            <input size="6" type="text" id="get_id_kp" name="get_id_kp" value = "{$get_id_kp}">
        </div>

{* *******************  Меня Выбора Ответственного Юзера       ************************** *}  
 <div id="g_responsible" class="mobile_web" >
Ответственный :

{* Изменяем количество пользователей*}
   {$count_users1 = $count_users}
   {for  $i=0 to $count_users-1}
              
             {if $active_user_names_arr_smarty[$i] == $get_responsible}
                 {$count_users1 = $count_users-1}
             {/if}
    {/for}

<select style="width:120px;" id="get_responsible" class="form-select data-windows" name="get_responsible" size="1">
   
  
 
         <option selected value="{$get_responsible}">{$get_responsible}</option>
         {for  $i=0 to $count_users1-1}
              {* Удаляем повтор активного польвателя*}
             {if $active_user_names_arr_smarty[$i] == $get_responsible}
                 {$i = $i + 1}
                 {$count_users = $count_users-1}
             {/if}
            <option value="{$active_user_names_arr_smarty[$i]}">{$active_user_names_arr_smarty[$i]}</option>
         {/for}
         <option value="">*сбросить*</option>
     </select>
 </div>

{* *******************  Выбора типа КП        ************************** *}  
 <div class="mobile_web" >
Тип КП : 
    <select style="width:100px;" id="get_type_kp" class="form-select data-windows" name="get_type_kp" size="1">

         <option selected value="{$get_type_kp}">{$get_value_type_kp}</option>
         {$count_AllKptype = count($AllKptype)-2}
         
         {for  $i=0 to $count_AllKptype}
              {* Удаляем повтор типа КП *}
             {if $AllValuesKptype[$i] == $get_type_kp}
                {$i = $i + 1}
             {/if}
            <option value="{$AllValuesKptype[$i]}">{$AllKptype[$i]}</option>
         {/for}
        
     </select>
 </div>

 {* *******************  Выбора типа Продукции   ************************** *}  
 <div class="mobile_web" >
Тип прод :
    <select class="form-select data-windows" name="get_product_type" size="1">
 
         <option selected value="{$get_product_type}">{$get_product_type_name}</option>
        
         {for  $i=0 to (count($AllProductTypesValue)-2)}
              {* Удаляем повтор типа КП*}
             {if $AllProductTypesValue[$i] == $get_product_type}
                {$i = $i + 1}
             {/if}
            <option value="{$AllProductTypesValue[$i]}">{$AllProductTypesName[$i]}</option>
         {/for}
        
     </select>
 </div>
 {* *******************  Выбора состояния КП    ************************** *}  
 <div class="mobile_web" >
Сост. КП :
    <select name="get_KpCondition" size="1">
 
         <option selected value="{$get_KpCondition}">{$get_KpCondition}</option>
        
         {for  $i=0 to (count($AllKpConditions)-2)}
              {* Удаляем повтор типа КП*}
             {if $AllKpConditions[$i] == $get_KpCondition}
                {$i = $i + 1}
             {/if}
            <option value="{$AllKpConditions[$i]}">{$AllKpConditions[$i]}</option>
         {/for}
        
     </select>
 </div>



 {* *******************  Меня ввода Адрес поставки     ************************** *}
    
        <div id="g_adres_postavki" class="mobile_web">
            <label for="param"> Адрес : </label>
            <input size="10" type="text" id="get_adres_postavki" name="get_adres_postavki" value = "{$get_adres_postavki}">
      
        </div>

{* *******************  Меня ввода Закр.Перенос Контр      ************************** *}
       
        <div class="mobile_web">
            <label for="FinishContract">Закр. Контр: </label>
                    {if $get_FinishContract == 1}            
                    <input type="checkbox" name="get_FinishContract" value="1" checked>
                    {else}
                        <input type="checkbox" name="get_FinishContract" value="1">
                    {/if}
       </div>

 <button  type="submit">ОБНОВИТЬ</button>
   </div>
             
</form>




