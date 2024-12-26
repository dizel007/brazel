{include file="../templates/header.tpl"}
<link rel = "stylesheet" href = "../css/style.css">
<div class="">
     <div class="our_table">
       <table width="100%" class="drawtable employee_table">
         <thead>
            <tr class="DrawDark">
               <td width = "30">пп</td>
               <td width = "600" >Наименование</td>
               <td width = "30">ед.зм</td> 
               <td width = "40">Кол-во</td> 
               <td width = "110">№КП и дата</td> 
               <td>См</td>
               <td>Ответственный</td>
               <td>Ex</td>
               <td>Рее</td>
               <td width = "80">ИНН</td>
               <td>Заказчик</td>
               <td>Тип прод</td>
               <td>Тип КП</td>

               <td>Адрес</td>

         </tr>
         </thead>
      <tbody>
{$i=0}
{$i1=0}
{$temp_kp_id=0}
{$green_darkGreen = DrawLight}
{foreach from=$prods_all item=items}
     
    {foreach from=$items item=one_item}
    <tr class ="{$green_darkGreen}">
          {if $temp_kp_id != $one_item['id']}
   <td rowspan="{count($items)}">{$i+1}</td>
             
          {/if}

          <td>{$one_item['name']}</td>
          <td>{$one_item['ed_izm']}</td>
          <td>{$one_item['kol']}</td>
         
          {if $temp_kp_id != $one_item['id']}
    <td rowspan="{count($items)}">{$one_item['KpNumber']} от {$one_item['KpData']}</td>
    <td rowspan="{count($items)}"><a href = "../open_excel/parce_excel_kp.php?LinkKp={$one_item['LinkKp']}"><img style = "opacity: 0.7" src="../icons/see_excel.png" alt="Excel"></a></td>

    <td rowspan="{count($items)}">{$one_item['Responsible']}</td> 

    <td rowspan="{count($items)}"><a href = "../{$one_item['LinkKp']}"><img style = "opacity: 0.7" src="../icons/table/excel.png" alt="Excel"></a></td>

    <td rowspan="{count($items)}"><a href = "..?transition=10&id={$one_item['id']}"><img style = "opacity: 0.7" src="../icons/see_excel_1.png" alt="Excel"></a></td>

    <td rowspan="{count($items)}">{$one_item['InnCustomer']}</td>
    <td rowspan="{count($items)}">{$one_item['NameCustomer']}</td>
    <td rowspan="{count($items)}">
      <img style = "opacity: 0.7" src="../icons/type_product/{$one_item['type_product']}.png">
    
    </td>

    <td rowspan="{count($items)}">
      <img style = "opacity: 0.7" src="../icons/type_kp/{$one_item['type_kp']}.png">
    </td> 

    
    
    <td rowspan="{count($items)}">{$one_item['adress']}</td>

          {/if}
        </tr>
        {$temp_kp_id = $one_item['id']}
      {/foreach}
     
{$i = $i + 1}
    {if (($i % 2) == 0) }
        {$green_darkGreen = DrawLight}
    {else}
        {$green_darkGreen = DrawDark}
    {/if}
{/foreach}

    
          </tbody>
      </table>
  </div>
</div>
