
<div class="zagolovok_reports_table">Перечень новых Компаний :{$arr_select_changes.0.author} </div>


<table class="styled-table drawtable employee_table">
<tr>
<td class="reports_shapka">пп</td>
<td class = "reports_shapka">Тип изменения</td>
<td class = "reports_shapka">ИНН</td>
<td class = "reports_shapka">Наименование</td>
<td class = "reports_shapka">Изменения</td>
<td class = "reports_shapka">Дата измен</td>
<td class="reports_shapka">Пользователь</td>

<td class = "reports_shapka">История КП</td>

</tr>

{$i=0}
{foreach from=$arr_select_changes key=user item=value}
<tr>
<td>{$i+1}</td>
<td>{$arr_select_changes.$i.what_change_com}</td>
<td>{$arr_select_changes.$i.id_item}</td>
<td>{$arr_select_changes.$i.name}</td>
<td>{$arr_select_changes.$i.comment_change}</td>


<td>{$arr_select_changes.$i.time_change}</td>

<td>{$arr_select_changes.$i.author}</td>

<td>
  {if $arr_select_changes.$i.id_kp <> ''}
    <a href="?transition=10&id={$arr_select_changes.$i.id_kp}">перейти к Компании
   {else}  
   Нет созданных КП
   {/if}
 </td>
<tr>
{$i=$i+1}
{/foreach}

</table>