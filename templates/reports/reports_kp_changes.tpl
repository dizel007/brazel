<h2>Изменения в КП за выбранный период</h2>


<div>
<table class="styled-table drawtable employee_table">
<tr>
    <td>Пользователь</е>
    <td>Новых КП назначено</td>
    <td>Новых КП ожидает</td>
    <td>КП "НЕ в работе" всего</td>    
    <td>взято "в работу" за период</td>
    <td>КП "в работе" всего</td>
    <td>КП проданы за период</td>
    <td>Сумма продаж за период</td>
    <td>Просроченные КП за период</td>
    <td>Закрытые КП за период</td>
    <td>Закрытые КП всего</td>

    
</tr>

{foreach from=$active_user_names_arr_smarty item=value}
    <tr>
    <td>{$value}</td>

{**************** новых КП назначено  **************}
        {foreach from=$kol_new_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>
    
    <a class="report_link"  href="?transition=7&get_date_start={$get_date_start}&get_date_end={$get_date_end}&get_responsible={$value}&get_FinishContract=1">
                
                    {$kp_change}
                 
                 </a>
    


                </td>
                
            {/if}
        {/foreach}

{**************** Новых КП ожидает чтобы взяли в работу  **************}
        {foreach from=$kol_new_kp_need_work key=user item=kp_change}
            {if ($user == $value)}
                <td>
                
                    <a class="report_link" href="?transition=7&get_date_start={$get_date_start}&get_date_end={$get_date_end}&get_responsible={$value}&get_KpCondition=%20">{$kp_change}</a>
                
                </td>
            {/if}
        {/foreach}

        {*  КП "НЕ в работе" всего      *}
        {foreach from=$kol_new_kp_work key=user item=kp_change}
            {if ($user == $value)}
                <td>
               NOT
                </td>
            {/if}
        {/foreach}



{*  взято "в работу" за период      *}
        {foreach from=$kol_new_kp_work key=user item=kp_change}
            {if ($user == $value)}
                <td>
                <a class="report_link" href="?transition=7&get_date_start={$get_date_start}&get_date_end={$get_date_end}&get_responsible={$value}&get_KpCondition=В работе">{$kp_change}</a>
                </td>
            {/if}
        {/foreach}

{*  ВСЕГО КП В РАБОТЕ ОВ/В/Н      *}
        {foreach from=$kol_new_kp_work key=user item=kp_change}
            {if ($user == $value)}
                <td>NET</td>
            {/if}
        {/foreach}
{*  КП проданные за период       *}
        {foreach from=$kol_sold_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>
                    <a class="report_link" href="?transition=7&get_date_sell_start={$get_date_start}&get_date_sell_end={$get_date_end}&get_responsible={$value}&get_KpCondition=Купили у нас">{$kp_change}</a>
                </td>
            {/if}
        {/foreach}
{*  Сумма продаж за период       *}
        {foreach from=$sum_sold_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>{$kp_change}</td>
            {/if}
        {/foreach}
{*  Просроченные КП за период       *}
        {foreach from=$kol_needcall_kp key=user item=kp_change}
            {if ($user == $value)}
                <td>{$kp_change}</td>
            {/if}
        {/foreach}
{*  Закрытые КП за период       *}
        {foreach from=$kol_close_kp_period key=user item=kp_change}
            {if ($user == $value)}
                <td>{$kp_change}</td>
            {/if}
        {/foreach}
 {*  Закрытые КП за все время        *}
        {foreach from=$kol_close_kp_period key=user item=kp_change}
            {if ($user == $value)}
                <td>ALL</td>
            {/if}
        {/foreach}

        
    </tr>
        
{/foreach}

</table>





</div>
