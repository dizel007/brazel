


<table class="table_work_kp">
<th  colspan="4" class="darkblue_shapka">Информация найденных телефонах по ЗАПРОСУ: {$search_telephone} </th>

<tr class="">
<th class="light_blue">пп</th>
<th class="light_blue">ИНН</th>
<th class="light_blue">Наименование</th>
<th class="light_blue">Телефон</th>



</tr>

{$i=1}
{foreach from=$arr_seacrh_comp_tel_t item=item }
</tr>
<td>
    {$i}
</td>
<td>
  <a href="?transition=7&get_inn={$item['inn']}">{$item['inn']}
</td>

    <td>
    {$item['name']}
    </td>
 

    <td>
    {$item['search_phone_number']}
    </td>

</tr>
{$i=$i+1}
{/foreach}

</table>