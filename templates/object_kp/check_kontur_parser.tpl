 <div class="block green_object_kp">
 
 <p class="zagolovok">Подтянуть данные с сайта контура</p>

        <form enctype="multipart/form-data" action="" method="get">
            <div class="input_form_left zhir">
              <input type="hidden" name="user_login" value="{$userdata['user_login']}">
              <input type="hidden" name="transition" value="2">
                 
                    {if isset($input_inn)}
                        <input type="hidden" name="InnCustomer" value="{$input_inn}">
                    {else} 
                      <input type="hidden" name="InnCustomer" value ="">
                    {/if}
                
                    {if isset($tender_data['KonturLink'])}
                       Ссылка на сайт: <input size ="70" type="text" name="KonturLink" value ="{$tender_data['KonturLink']}">
                    {else} 
                       Ссылка на сайт: <input type="text" name="KonturLink" value ="">
                    {/if}
            </div>
            <div class="input_form_left">
              <input type="submit" value="Запросить данные">
            </div>
            &nbsp
        </form>
<br>
 </div>