<div>
<table class="s_font_24 styled-table drawtable">
<tr >
    <td class="reports_shapka">Пользователь</td>
    <td class="reports_shapka">новых КП</td>
    <td class="reports_shapka">новых Компаний</td>
    <td class="reports_shapka">изменений в КП</td>
    <td class="reports_shapka">отправленных email</td>
    <td class="reports_shapka">изменений в данных о компании</td>
    <td class="reports_shapka">КП с изменениями</td>
    
</tr>

{foreach from=$arr_users item=value}

<tr>
    <td>{$value}</td>
    {* новые КП *}
    {foreach from=$kol_new_kp key=user item=new_kp}
            {if ($user == $value)}
                <td>
                 
                {if $new_kp <> 0}
                <a href="?transition=11&ids={$arr_new_kp_user["$value"]}">
                <div class ="link_reports_table">
                    {$new_kp}
                 </div>   
                </td>
                </a>
                {else} 
                 <div class ="link_reports_table">
                    {$new_kp}
                 </div>  
                {/if}
            {/if}
    {/foreach}

    {* новые Компаний создано *}
    {foreach from=$kol_new_comp key=user item=new_comp}
     {if ($user == $value)}
             <td>{$new_comp}</td>
            {/if}
    {/foreach}
{* Изменений в КП  *}
          {foreach from=$kol_change_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>
                {if $kp_change <> 0}
                  
                <a href="?transition=15&author={$value}&date_start={$get_date_start}&date_end={$get_date_end}&what_change=1">
                 <div class ="link_reports_table">
                    {$kp_change}
                </div>
                </a>
                {else}
                    <div class ="link_reports_table">
                       {$kp_change}
                   </div>
                {/if}
                </td>
            
            
            {/if}
        {/foreach}


        {foreach from=$kol_send_mail key=user item=send_mail}
            {if ($user == $value)}
                <td>{$send_mail}</td>
            {/if}
        {/foreach}

        {foreach from=$kol_change_comp key=user item=change_comp}
        {if ($user == $value)}
            <td>{$change_comp}</td>
        {/if}
        {/foreach}
{* КП с изменениями *}
        {foreach from=$kol_change_unique_kp key=user item=kp_unique_change}
            {if ($user == $value)}
                <td>
                <a href="?transition=11&ids={$arr_change_kp_user["$value"]}">
                {$kp_unique_change}
                </a>
                </td>
            {/if}
        {/foreach}
              
      </tr>
        
{/foreach}

</table>





</div>