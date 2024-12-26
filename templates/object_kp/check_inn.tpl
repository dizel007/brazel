<div class="block">
 <p class="zagolovok">Проверка наличия ИНН в Базе</p>
        <form enctype="multipart/form-data" action="?transition=2" method="get">
            <div class="input_form_left zhir">
              <input type="hidden" name="user_login" value="{$userdata['user_login']}">
              <input type="hidden" name="transition" value="2">
                    {if isset($tender_data['KonturLink'])}
                       <input type="hidden" name="KonturLink" value ="{$tender_data['KonturLink']}">
                    {else} 
                       <input type="hidden" name="KonturLink" value ="">
                    {/if}

                    {if isset($input_inn)}
                       ИНН Заказчика : <input type="number" name="InnCustomer" value ="{$input_inn}">
                    {else} 
                       ИНН Заказчика : <input type="number" name="InnCustomer" value ="">
                    {/if}
            </div>
            <div class="input_form_left">
              <input type="submit" value="Запросить ИНН">
            </div>
   
    
           <div class="red_string">
              <p>
           {if isset($input_inn)}    
                  {if !isset($arr_inn_comp.0.inn)}          
                    Данный ИНН отсутствует в НАШЕЙ(!!!!!!!) Базе    &nbsp&nbsp&nbsp
                    <a href="?transition=3&back_transition=2&user={$userdata['user_login']}&InnCustomer={$input_inn}" > Добавить?</a>
                  {else}
                    &nbsp
                  {/if}
          {else} 
               &nbsp
          {/if}                            
              </p>
            </div>

        </form>
</div>