  {if ($typeQuery == 309) }
  <div class="dm-overlay" id="win309">
      <div class="dm-table-phone">
          <div class="dm-cell-phone">
              <div class="dm-modal-phone">
                  <a href="#close" class="close"></a>
      
      <div class ="center">ДОБАВЛЕНИЕ НОВОГО ТЕЛЕФОННОГО НОМЕРА<br><br></div>
                  <form  action="pdo_connect_db/insert_telephone.php" method="get">
 <table class="modal_tabel" width="100%" cellspacing="0" cellpadding="5">
 <caption>Наименование КОМПАНИИ: {$company_arr[0]['name']}</caption>

       <tr> 
          <td width="100" valign="top">ИНН</td>
           <td><input type="hidden" name="InnCustomer" value="{$company_arr[0]['inn']}">{$company_arr[0]['inn']}</td>
      </tr>
      <tr> 
        <td> 
          <!-- передаем id  чтобы знать куда вернуться -->
             <input type="hidden" name="id" value="{$id}">   
        </td>
      </tr>
      
      <tr> 
          <td valign="top">Телефон</td>
           <td>   
         <input type="text" class="form-control" id="phone2" name="telefon" placeholder="+7 (999) 999-99-99" autocomplete="off" data-phone-pattern>
	     
          </td>
      </tr>
      <tr>           
        <td valign="top">WhatsApp</td>
           <td> 
                <select size="1" name="whatsapp">
                      <option value="1">есть</option>
                      <option selected value="0">нет</option>
                 </select>
            
          </td>
    </tr>
    
     <tr>           
        <td valign="top">Актуальность номера</td>
              <td> 
            
                  <select id="js-phone-num" size="1" name="actual_phone">
                      <option value="Актуальный">Актуальный</option>
                      <option value="Неактуальный">Неактуальный</option>
                      <option value="Не звонить">Не звонить</option>
                      <option selected value="Новый">Новый</option>
                      <option value=""></option>
                </select>
            
          </td>
    </tr>
      <tr> 
          <td width="200" valign="top">Контактное Лицо</td>
         <td>   
            <textarea name="contactName" rows="1" cols="30"></textarea>
         </td>
        </tr>
      <tr> 
          <td width="200" valign="top">Коментарий</td>
          <td>   
                 <textarea name="commentPhone" rows="3" cols="30"></textarea>
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