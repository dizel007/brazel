<table class="table_work_kp">

<th  colspan="6" class="darkblue_shapka">Информация о КП назначенных сотрудникам</th>

{if (isset($arr_full_user_info))} {* Проверяем есть ли массив с проданными КП*}
  <tr class="">
      <th class="light_blue">Пользователь</th>
      <th class="light_blue">Назначено КП</th>
      <th class="light_blue">Из них уже закрыто</th>
      
      <th class="light_blue">КП от 1 до 3 млн</th>
      <th class="light_blue">КП от 3 млн</th>
      <th class="light_blue">Сумма всех КП </th>

  
  </tr>

  {**********************  Таблица с отчетами (Продажи КП)    ******************}

    {foreach from=$arr_full_user_info item=value_user key=key_user}
        <tr>
        
      
    {* ************************************ Сотрудник ******************************* *}    
    <td>
    <div class ="">  {$key_user} </div>   
    </td>
    {* ************************************ Назначенные КП ******************************* *}
    <td>
        <div class =""> <a href="?transition=11&ids={$value_user['id']}"> {$value_user['count_kp']}</a> </div>   
    </td>
    {* ************************************ Назначенные КП ******************************* *}
    <td>
        <div class ="">  {$value_user['close_kp']} </div>   
    </td>
    {* ************************************  КП больше 10000000 ******************************* *}
    <td>
    <div class =""> <a href="?transition=11&ids={$value_user['id_1_mln']}"> {$value_user['kp_one_million']}</a> </div>   
    
    </td>
    
    {* ************************************  КП больше 10000000 ******************************* *}
    <td>
    <div class =""> <a href="?transition=11&ids={$value_user['id_3_mln']}"> {$value_user['kp_three_million']}</a> </div>   
    
    </td>
    {* ************************************  КП больше 10000000 ******************************* *}
    <td>
        <div class ="">  {$value_user['summa_al_kp']} </div>   
    </td>
    
    
    </tr> 
    {/foreach} 

{else}
    <tr><th class="light_blue">НЕТ ИНФОРМАЦИИ О СФОРМИРОВАННЫХ КП (выберете другие даты)</th></tr>   
{/if} 





</table>
 






              
     
        



