
<div class="zagolovok_reports_table">История изменений по КП</div>

<table class="table_work_kp">
  <tr class="">
         <th  colspan="4" class="darkgreen_shapka">Информация о создании КП </th>
  </tr>
  <tr class="">
  <th width ="30" class="">пп</th>
     
      <th class="">Номер КП и Наименование Заказчика</th>
      <th width ="100" class="">дата и время создания КП</th>
      <th width ="60" class="">исполнитель</th>

  </tr>
  <tr class="">
      <td>1</td>
      <td class="">{$start_info_kp['KpNumberAnsDate']}</td>
      <td class="">{$start_info_kp['time_change']}</td>
       <td>
          {foreach $active_user_login key=key item=user}
            {if $start_info_kp['author'] == $key}
              {$user}
            {/if}
          {/foreach}
      </td>
  </tr>

</table>

{***************************************  **** ИНФО об ОТправке ЕМАЙЛОВ ******************************}
{if isset ($start_emales)}
<table class="table_work_kp">

  <tr class="">
         <th  colspan="4" class="darkgreen_shapka">Информация об отправленных письмах</th>
  </tr>

  <tr class="">
    <th width ="30" class="">пп</th>
    <th class="">Адрес получателя</th>
    <th width ="80" class="">дата/время отправки</th>
    <th width ="60" class="">исполнитель</th>
  </tr>

  {$i=0}
  {foreach from=$start_emales item=emails}
    <tr>
      <td>{$i+1}</td>
      <td>{$emails['comment_change']}</td>
      <td>{$emails['time_change']}</td>
      <td>
         {foreach $active_user_login key=key item=user}
            {if $emails['author'] == $key}
              {$user}
            {/if}
          {/foreach}
          
      </td>
      </tr>
    {$i=$i+1}
  {/foreach}
</table>
{/if}



{* **************************************  **** ИНФО Изменения в КП *********************************** *}
{if isset($change_in_kp)}
<table class="table_work_kp">

  <tr class="">
         <th  colspan="4" class="darkgreen_shapka">Информация об изменениях в КП</th>
  </tr>

  <tr>
    <th width ="30" class="">пп</th>
    <th>Комментарий</th>
    <th width ="80" class="">дата/время отправки</th>
    <th width ="60" class="">исполнитель</th>
  </tr>
  {$i=0}
  {foreach from=$change_in_kp item=comment}
    <tr>
      <td>{$i+1}</td>
      <td>
        {foreach from=$comment['comment_change'] item=value}
           {$value}<br>
        {/foreach}
      </td>
   
      <td>{$comment['time_change']}</td>
      <td>
      
         {foreach $active_user_login key=key item=user}
            {if $comment['author'] == $key}
              {$user}
            {/if}
         {/foreach}
      
      </td>
      </tr>
    {$i=$i+1}
  {/foreach}
</table>
{/if}
{* ***************************************  **** Изменения данных в КП ************************************}


<table class="table_work_kp">

  <tr class="">
         <th  colspan="4" class="darkgreen_shapka">Информация об изменениях в данных КП</th>
  </tr>


  <tr>
    <th width ="30" class="">пп</th>
    <th>Изменения в КП</th>
    <th width ="80" class="">дата/время отправки</th>
    <th width ="60" class="">исполнитель</th>
  </tr>
   <tr>
    <td>0</td>
    <td> 
              {if ($LinkKp_first <> '')}
      <a href="{$LinkKp_first}" target="_blank" >Первичное КП</a>
         {else}
         файл удален с сервера
         {/if}

  
    </td>
    <td>{$start_info_kp['time_change']}</td>
    <td>
              {foreach $active_user_login key=key item=user}
            {if $start_info_kp['author'] == $key}
              {$user}
            {/if}
          {/foreach}
    </td>
  </tr>
 
  {$i=0}
  {foreach from=$change_data_kp item=comment}

    <tr>
      <td>{$i+1}</td>
      <td>
          {if ($arr_LinkKp[$i] <> '')}
         <a href="{$arr_LinkKp[$i]}" target="_blank" >{$comment['comment_change']}</a>
         {else}
         файл удален с сервера
         {/if}
      </td>
      <td>{$comment['time_change']}</td>
      <td>
        {foreach $active_user_login key=key item=user}
            {if $comment['author'] == $key}
              {$user}
            {/if}
         {/foreach}

      </td>
      </tr>
    {$i=$i+1}
  {/foreach}
</table>
