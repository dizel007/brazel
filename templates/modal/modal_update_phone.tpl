{if ($typeQuery == 300) }
{foreach $telephons_company as $tel_value}
{if $tel_value['id'] == $id_phone}
  <div class="dm-overlay" id="win300">
      <div class="dm-table">
          <div class="dm-cell">
              <div class="dm-modal">
                  <a href="#close" class="close"></a>
      
      <div class ="center">ИЗМЕНЕНИЕ ДАННЫХ ТЕЛЕФОННОГО НОМЕРА<br><br></div>
                  <form  action="pdo_connect_db/update_telephone.php?id={$id_phone}" method="post">
 <table class="modal_tabel" width="100%" cellspacing="0" cellpadding="5">
 <caption>Наименование КОМПАНИИ: {$company_arr[0]['name']}</caption>
 <input type="hidden" name="InnCustomer" value ="{$company_arr[0]['inn']}">
 <caption><b>Телефон: {$tel_value['telephone']}</b></caption>

      <tr> 
        <td> 
             <input type="hidden" name="id_phone_cor" value="{$id_phone}">
             <input type="hidden" name="real_phone" value="{$tel_value['telephone']}">
             
        </td>
        <td> 
          <!-- передаем id  чтобы знать куда вернуться -->
             <input type="hidden" name="id" value="{$id}">   
        </td>
      </tr>
      
      <tr>           
        <td valign="top">WhatsApp</td>
        <td valign="top">{$tel_value['whatsapp']}</td>
        <td> 
                  <select size="1" name="whatsapp">
                      <option selected value = "{$tel_value['whatsapp']}">{$tel_value['whatsapp']}</option>
                      <option value="1">есть</option>
                      <option value="0">нет</option>
                  </select>
            
          </td>
    </tr>

    <tr >           
        <td valign="top">Актуальность номера</td>



        <td valign="top">{$tel_value['actual']}</td>
         <td> 
            
                  <select id="js-phone-num" size="1" name="actual_phone">
                      <option id="js-new-modal-" selected value = "{$tel_value['actual']}">{$tel_value['actual']}</option>
                      <option value="Актуальный">Актуальный</option>
                      <option value="Неактуальный">Неактуальный</option>
                      <option value="Не звонить">Не звонить</option>
                      <option value="Новый">Новый</option>
                      <option value=""></option>
                </select>
            
          </td>
    </tr>

     <tr> 
          <td width="200" valign="top">Контактное Лицо</td>
          <td valign="top">{$tel_value['name']}</td>
          <td>   
              <textarea name="contactName" rows="1" cols="30">{$tel_value['name']}</textarea>
         </td>
     </tr>
  
     <tr> 
          <td width="200" valign="top">Коментарий</td>
          <td valign="top">{$tel_value['comment']}</td>
          <td>   
              <p>    
                <textarea name="commentPhone" rows="3" cols="30">{$tel_value['comment']}</textarea>
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