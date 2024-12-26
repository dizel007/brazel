{* <div class = "zagolovok_an">Аналитика</div> *}
<div class = "date_menu_an">
  
  <form class = "date_select_menu_an" action = "">
  <input hidden type="text" name ="transition" value="70">
  
  {*
  <select name="report_type">

     <option value="r1">Отчет по работе с КП</option>
     <option value="r2">Отчет по  КП</option>
     <option value="r3">Отчет по работе с КП</option>
 </select>
 *}
   <input class = "mar_left_30" type="submit" value="Отправить">
   <ul class="date_menu_an">
    <li class=""><a href="?transition=70&user_login={$userdata['user_login']}&get_date_start={$now}&get_date_end={$now}">Сегодня</a></li>
    <li class=""><a href="?transition=70&user_login={$userdata['user_login']}&get_date_start={$yesturday}&get_date_end={$yesturday}">Вчера</a></li>
    <li class=""><a href="?transition=70&user_login={$userdata['user_login']}&get_date_start={$last_week}&get_date_end={$now}">Неделя</a></li>
    <li class=""><a href="?transition=70&user_login={$userdata['user_login']}&get_date_start={$last_month}&get_date_end={$now}">Месяц</a></li>
    <li class=""><a href="?transition=70&user_login={$userdata['user_login']}&get_date_start={$last_kvartal}&get_date_end={$now}">Квартал</a></li>

</ul>
   
   {* *******************  Меня ввода Даты       ************************** *}
                <div id="g_dateKPs" class="mar_left_60">
                    <label for="date_start">Дата начала : </label>
                    <input type="date" id="get_date_start" name="get_date_start" value = "{$get_date_start}">
                </div>
                <div id="g_dateKPe" class="mar_left_30">
                    <label for="date_end">Дата окончания : </label>
                    <input type="date" id="get_date_end" name="get_date_end" value = "{$get_date_end}">
                </div>

  </form>



</div>

{**********************  Таблица с отчетами (Продажи КП)    ******************}
{if (isset($array_sold_kp))} {* Проверяем есть ли массив с проданными КП*}
    {include file="analitika/table_sell_kp.tpl"}
{else}
  <table class="table_work_kp">
    <th  colspan="6" class="darkblue_shapka">Информация о проданных КП</th>
    <tr><th class="light_blue">НЕТ ИНФОРМАЦИИ ПРОДАННЫХ КП</th></tr>   
  </table>
{/if} 

{**********************  Таблица с отчетами   (РАБОТА ПО КП)  ******************}
{if (isset($kol_change_kp))} {* Проверяем есть ли массив работой по КП*}
   {include file="analitika/table_work_kp.tpl"}
{else}
    <table class="table_work_kp">
      <th  colspan="6" class="darkblue_shapka">Информация о работе сотрудников</th>
      <tr><th class="light_blue">НЕТ ИНФОРМАЦИИ О РАБОТЕ СОТРУДНИКОВ</th></tr>   
    </table>
{/if} 

{**********************  Таблица с отчетами (Закрытые КП)    ******************}
{if (isset($array_close_kp))}  {* Проверяем есть ли массив с закрытыми КП*}
  {include file="analitika/table_close_kp.tpl"}

{else}
    <table class="table_work_kp">
      <th  colspan="6" class="darkblue_shapka">Информация о закрытых КП</th>
      <tr><th class="light_blue">НЕТ ИНФОРМАЦИИ ЗАКРЫТЫХ КП</th></tr>   
    </table>

{/if} 
