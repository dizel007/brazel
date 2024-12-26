
<table class="table_work_kp">
<th  colspan="8" class="darkblue_shapka">Информация о работе сотрудников</th>
  <tr class="">
      <th class="light_blue">Пользователь</th>
      <th class="light_blue">Новых КП</th>
      <th class="light_blue">Создано Компаний</th>
      <th class="light_blue">Изменений в КП</th>
      <th class="light_blue">Отправленных писем</th>
      <th class="light_blue">Изменения в компаниях</th>
      <th class="light_blue">КП с изменениями</th>
      <th class="light_blue">Изменение ДАННЫХ в КП</th>
</tr>

{foreach from=$arr_users item=value}

<tr>
    <td>
    {foreach from=$active_user_login item=value_user key=key_user}
        {if $value == $key_user}
            {$value_user}
        {/if} 
    {/foreach}
    </td>
    {* ********************************************************************** новые КП *}
    {foreach from=$kol_new_kp key=user item=new_kp}
            {if ($user == $value)}
                <td>
                 
                {if $new_kp <> 0}
                <a href="?transition=11&ids={$arr_new_kp_user["$value"]}">
                <div class ="">
                    {$new_kp}
                 </div>   
                </td>
                </a>
                {else} 
                 <div class ="">
                    {$new_kp}
                 </div>  
                {/if}
            {/if}
    {/foreach}

    {* **********************************************************************  Компаний создано *}
    {foreach from=$kol_new_comp key=user item=new_comp}
     {if ($user == $value)}

                     <td>
                {if $new_comp <> 0}
                  
                <a href="?transition=16&author={$value}&date_start={$get_date_start}&date_end={$get_date_end}&what_change=9">
                 <div class ="">
                    {$new_comp}
                </div>
                </a>
                {else}
                    <div class ="">
                       {$new_comp}
                   </div>
                {/if}
                </td>


            
            {/if}
    {/foreach}
{* Изменений ********************************************************************** в КП  *}
          {foreach from=$kol_change_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>
                {if $kp_change <> 0}
                  
                <a href="?transition=15&author={$value}&date_start={$get_date_start}&date_end={$get_date_end}&what_change=1">
                 <div class ="">
                    {$kp_change}
                </div>
                </a>
                {else}
                    <div class ="">
                       {$kp_change}
                   </div>
                {/if}
                </td>
            
            
            {/if}
        {/foreach}

{* отправленные письма  Заказчикам *}
        {foreach from=$kol_send_mail key=user item=send_mail}
            {if ($user == $value)}
                <td>
              {if $send_mail <> 0}
                 <b> 
                <a href="?transition=15&author={$value}&date_start={$get_date_start}&date_end={$get_date_end}&what_change=7">
                 <div class ="">
                    {$send_mail}
                </div>
                </b>
                </a>
                {else}
                    <div class ="">
                       {$send_mail}
                   </div>
                {/if}
             
                
                
                </td>
            {/if}
        {/foreach}
{* изменениями  в КОМПАНИЯХ*}
        {foreach from=$kol_change_comp key=user item=change_comp}
        {if ($user == $value)}
            
            <td>
         {if $change_comp <> 0}
                  
                <a href="?transition=16&author={$value}&date_start={$get_date_start}&date_end={$get_date_end}&what_change=2">
                 <div class ="">
                    {$change_comp}
                </div>
                </a>
                {else}
                    <div class ="">
                       {$change_comp}
                   </div>
                {/if}
       
            
            
            </td>
        {/if}
        {/foreach}
{* КП с изменениями *}
        {foreach from=$kol_change_unique_kp key=user item=kp_unique_change}
            {if ($user == $value)}
                <td><b>
                <a href="?transition=11&ids={$arr_change_kp_user["$value"]}">
                {$kp_unique_change}
                </a></b>
                </td>
            {/if}
        {/foreach}

{* КП с измененными данными *}
       {foreach from=$kol_change_unique_kp_data key=user item=kp_unique_change}
            {if ($user == $value)}
                <td><b>
                <a href="?transition=11&ids={$arr_change_data_kp_user["$value"]}">
                {$kp_unique_change}
                </a></b>
                </td>
            {/if}
        {/foreach}

      </tr>
        
{/foreach}

</table>
