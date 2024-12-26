{* РИСУЕМ кнопку сброса *}
<div class="reset_button">
  <a href="index.php?transition=13" title="Вернуться к началу страницы">СБРОС</a>
</div> 
<form class ="">
   <div class ="up_form_new">

{* *******************  Прячем сюда тип перехода        ************************** *}   
<input hidden type="text" name="transition" value="13">

{* *******************  Меня ввода Даты       ************************** *}
                <div id="g_dateKPs" class="mobile_web">
                    <label for="date_start">Дата начала : </label>
                    <input type="date" id="get_date_start" name="get_date_start" value = "{$get_date_start}">
                </div>
                <div id="g_dateKPe" class="mobile_web">
                    <label for="date_end">Дата окончания : </label>
                    <input type="date" id="get_date_end" name="get_date_end" value = "{$get_date_end}">
                </div>
        

{* *******************  Меня Выбора Ответственного Юзера       ************************** *}  
  {if ($get_responsible == '')}
          {$count_users = $count_users-1}
  {else}        
          {$count_users = $count_users-2}
  {/if}


 <div id="g_responsible" class="mobile_web" >
Ответственный :
    <select style="width:120px;" id="get_responsible" class="form-select data-windows" name="get_responsible" size="1">
 
         <option  selected value="{$get_responsible}">{$get_name_responsible}</option>
         {for  $i=0 to $count_users}
              {* Удаляем повтор активного польвателя*}
             {if $active_user_logins_arr_smarty[$i] == $get_responsible}
                {$i = $i + 1}
             {/if}
            <option value="{$active_user_logins_arr_smarty[$i]}">{$active_user_names_arr_smarty[$i]}</option>
         {/for}
         
     </select>
 </div>

{* *******************  Выбора типа КП        ************************** *}  
 <div id="g_type_kp" class="mobile_web" >
Тип КП :
    <select style="width:100px;" id="get_type_kp" class="form-select data-windows" name="get_type_kp" size="1">
 
         <option selected value=""></option>
         {$count_AllKptype = count($AllKptype)-2}
         
         {for  $i=0 to (count($AllKptype)-1)}
              {* Удаляем повтор типа КП*}
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
 <button  type="submit">ОБНОВИТЬ</button>
   </div>
             
</form>



