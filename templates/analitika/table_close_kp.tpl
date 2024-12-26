

 <table class="table_work_kp">
        <th  colspan="4" class="darkblue_shapka">Информация о закрытых КП</th>

  <tr class="">
      <th class="light_blue">Ответсвенный</th>
      <th class="light_blue">Уже купили</th>
      <th class="light_blue">Нет требуется</th>
      <th class="light_blue">Нет данных</th>
      

  
  </tr>


{foreach from=$active_user_login key=key item=value_user key=key_user}
      
      <tr>
{foreach from=$array_close_kp key=key item=value key=key}    

{if ($key_user == $key)}

  {* ************************************ Сотрудник ******************************* *}    
                <td>
                   <div class ="">  {$value_user} </div>   
                </td>
{* ************************************ КП которые УЖЕ КУПИЛИ ******************************* *}
   <td>
      <div class ="">
          {if (isset($array_close_kp.$key['KpCount_alr_buy']))}
              <a href="?transition=11&ids={$array_close_kp.$key['idKp_alr_buy']}">
                 {$array_close_kp.$key['KpCount_alr_buy']} 
               </a>
           {else} 
                 0
           {/if}
     </div>   
   </td>
{* ************************************ КП которые НЕ ТРЕБУЕТСЯ  ******************************* *}
   <td>
      <div class ="">
          {if (isset($array_close_kp.$key['KpCount_not_need']))}
              <a href="?transition=11&ids={$array_close_kp.$key['idKp_not_need']}">
                 {$array_close_kp.$key['KpCount_not_need']} 
               </a>
           {else} 
                 0
           {/if}
     </div>   
   </td>
{* ************************************ КП которые НЕТ ДАННЫХ  ******************************* *}
   <td>
      <div class ="">
     
          {if (isset($array_close_kp.$key['KpCount_not_know']))}
              <a href="?transition=11&ids={$array_close_kp.$key['idKp_not_know']}">
                 {$array_close_kp.$key['KpCount_not_know']} 
               </a>
           {else} 
                0
           {/if}
     </div>   
   </td>


{/if}
{/foreach}

{* ************************************ END Закрытые КП  ******************************* *}




       </tr>                

   
   
{/foreach}

<tr class="itogo">
   <td>
       <div class ="">  ИТОГО </div>   
   </td>

{**********************   Итого ************************************}
    <td>
        <div class ="">
            <a href="?transition=11&ids={$itog_close_kp['idKp_alr_buy']}">
              {$itog_close_kp['KpCount_alr_buy']} 
            </a>
        </div>   
    </td>

    <td>
        <div class ="">
            <a href="?transition=11&ids={$itog_close_kp['idKp_not_need']}">
              {$itog_close_kp['KpCount_not_need']} 
            </a>
        </div>   
    </td>

    <td>
        <div class ="">
            <a href="?transition=11&ids={$itog_close_kp['idKp_not_know']}">
              {$itog_close_kp['KpCount_not_know']} 
            </a>
        </div>   
    </td>


         
  </tr> 

</table>
 


              
     
        



