<div class="zagolovok_reports_table">Перечень изменений пользователя :{$arr_select_changes.0.author} </div>


<table class="styled-table drawtable employee_table">
<tr>
<td class="reports_shapka">пп</td>
<td class = "width_90px reports_shapka">Номер дата КП</td>
<td class="reports_shapka">Ответственный</td>
<td class = "width_150px reports_shapka">Инфа о Заказчике</td>
<td class = "width_90px reports_shapka">Дата измен</td>
<td class="reports_shapka">Ссылка на КП</td>
<td class="reports_shapka">Изменение</td>
<td class="reports_shapka">Пользователь</td>
<td class = "width_90px reports_shapka">Сумма КП</td>
<td class = "width_90px reports_shapka">История КП</td>

</tr>

{$i=0}
{foreach from=$arr_select_changes key=user item=value}
<tr>
<td>{$i+1}</td>
<td>КП№{$arr_select_changes.$i.KpNumber} от {$arr_select_changes.$i.KpData}</td>
<td>{$arr_select_changes.$i.Responsible}</td>
<td>ИНН:{$arr_select_changes.$i.InnCustomer} <br> {$arr_select_changes.$i.NameCustomer}</td>


<td>{$arr_select_changes.$i.time_change}</td>
<td><a href="?transition=10&id={$arr_select_changes.$i.id_item}">КП№{$arr_select_changes.$i.KpNumber}</td>
<td class="text_left">{$arr_select_changes.$i.comment_change}</td>
<td>{$arr_select_changes.$i.author}</td>
<td >{$arr_select_changes.$i.KpSum}</td>
<td><a href="?transition=17&id={$arr_select_changes.$i.id_item}">История КП</td>
<tr>
{$i=$i+1}
{/foreach}

</table>