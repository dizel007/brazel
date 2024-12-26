 {if $typeQuery == 400}

{foreach $emails_company as $email_value}
 {if $email_value['id'] == $id_email}
  <div class="dm-overlay" id="win400">
      <div class="dm-table">
          <div class="dm-cell">
              <div class="dm-modal">
                  <a href="#close" class="close"></a>
      
      <div class ="center">ИЗМЕНЕНИЕ ДАННЫХ EMAIL<br><br></div>
                  <form  action="pdo_connect_db/update_email.php?id={$id}" method="post">
 <table class="modal_tabel" width="100%" cellspacing="0" cellpadding="5">
 <caption>Наименование КОМПАНИИ: {$company_arr[0]['name']}</caption>
  <input type="hidden" name="InnCustomer" value ="{$company_arr[0]['inn']}">
 <caption><b>Email: {$email_value['email']}</b></caption>

      <tr> 
        <td> 
             <input type="hidden" name="id_email_cor" value="{$id_email}">
             <input type="hidden" name="real_email" value="{$email_value['email']}">
     
        </td>
        <td> 
          <!-- передаем id  чтобы знать куда вернуться -->
             <input type="hidden" name="id" value="{$id}">   
        </td>
      </tr>
      <tr>           
      </tr>

      <tr>           
        <td valign="top">Актуальность email</td>
        <td valign="top">{$email_value['actual']}</td>
         <td> 
            
                  <select id="js-actual_email" size="1" name="actual_email">
                      <option id="js-new-modal-" selected value = "{$email_value['actual']}">{$email_value['actual']}</option>
                      <option value="Актуальная">Актуальная</option>
                      <option value="Неактуальная">Неактуальная</option>
                      <option value="Новая">Новая</option>
                      <option value=""></option>
                </select>
            
          </td>
    </tr>

      <tr> 
          <td width="200" valign="top">Коментарий</td>
          <td valign="top">{$email_value['comment']}</td>
          <td>   
              <p>    
                <textarea name="commentEmail" rows="3" cols="30">{$email_value['comment']}</textarea>
              </p>
         </td>
      </tr>

             
 
   </table>
                                    
       <p><input type="submit" value="Отправить"></p>
      </form>
     </div>
    </div>
   </div>
  </div>
{/if}
{/foreach}
{/if}