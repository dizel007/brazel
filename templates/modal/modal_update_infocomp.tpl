{* Корректировка данных о Компании *}
{if ($typeQuery == 200)}

  <div class="dm-overlay" id="win8">
      <div class="dm-table">
          <div class="dm-cell">
              <div class="dm-modal">
                  <a href="#close" class="close"></a>
      <form  action="pdo_connect_db/update_info_company.php?id={$id}&typeQuery=200" method="post">
 <table class="modal_tabel" width="100%" cellspacing="0" cellpadding="5">

       <tr> 
          <td width="200" valign="top">ИНН КОМПАНИИ</td>
          <td valign="top">{$company_arr[0]['inn']}</td>
          <td> 
             <input type="hidden" name="InnCustomer" value="{$company_arr[0]['inn']}">
          </td>
      </tr>
      <tr> 
          <td> 
              <input type="hidden" name="id" value="{$id}"></p>
        </td>
      </tr>
      <tr> 
          <td width="200" valign="top">КРАТКОЕ Наименование КОМПАНИИ</td>
          <td valign="top">{$company_arr[0]['name']}</td>
      </tr>
      <tr> 
          <td width="200" valign="top">Полное Наименование КОМПАНИИ</td>
          <td valign="top">{$company_arr[0]['fullName']}</td>
      </tr>
  
      <tr> 
          <td width="200" valign="top">Контактное Лицо</td>
         <td valign="top">{$company_arr[0]['contactFace']}</td>
         <td>   
              <p>    
                <textarea name="contactFace" rows="3" cols="50">{$company_arr[0]['contactFace']}</textarea>
              </p>
         </td>
        </tr>
        <tr> 
          <td width="200" valign="top">Юрид. Адрес</td>
          <td valign="top">{$company_arr[0]['adress']}</td>
      </tr>
      <tr> 
          <td width="200" valign="top">Коментарий</td>
          <td valign="top">{$company_arr[0]['comment']}</td>
          <td>   
              <p>    
                <textarea name="comment" rows="3" cols="50">{$company_arr[0]['comment']}</textarea>
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