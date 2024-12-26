{if ($typeQuery == 409)}
  
  <div class="dm-overlay" id="win409">
      <div class="dm-table-phone">
          <div class="dm-cell-phone">
              <div class="dm-modal-phone">
                  <a href="#close" class="close"></a>
      
      <div class ="center">ДОБАВЛЕНИЕ НОВОЙ ЭЛЕКТРОННОЙ ПОЧТЫ<br><br></div>

<form  action="pdo_connect_db/insert_email.php" method="get">
  <table class="modal_tabel" width="100%" cellspacing="0" cellpadding="5">
    <caption>Наименование КОМПАНИИ: {$company_arr[0]['name']}</caption>

       <tr> 
          <td width="100" valign="top">ИНН</td>
           <td>
              <input type="hidden" name="InnCustomer" value="{$company_arr[0]['inn']}">
              {$company_arr[0]['inn']}  
           </td>
      </tr>
      <tr> 
        <td> 
          <!-- передаем id  чтобы знать куда вернуться -->
             <input type="hidden" name="id" value="{$id}">   
        </td>
      </tr>
      
      <tr> 
          <td valign="top">email</td>
           <td>   
              <input type="email"  name="new_email" value="">
	         </td>
      </tr>
      <tr>           
        <td valign="top">Актуальность почты</td>
              <td> 
            
                  <select size="1" name="actual_email">
                      <option value="Актуальная">Актуальная</option>
                      <option value="Неактуальная">Неактуальная</option>
                      <option selected value="Новая">Новая</option>
                      <option value=""></option>
                </select>
            
          </td>
    </tr>
      <tr> 
          <td width="200" valign="top">Коментарий</td>
          <td>   
                 <textarea name="commentEmail" rows="3" cols="30"></textarea>
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