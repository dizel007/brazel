
<div class="user_menu">
  <nav>
    <ul class="menuItems">
 {*  ********************************************   Реестр КП     ***************************************************** *}      
   
      <li>
        <a href="?" data-item='РЕЕСТР КП' >РЕЕСТР КП</a>
      </li>

{*  ********************************************   Создание КП     ***************************************************** *}      
      <li>
        <a href="?transition=1&user_login={$userdata['user_login']}" data-item='Создать КП' >Создать КП</a>
      </li>
      <li>
        <a href="?transition=2&user_login={$userdata['user_login']}" data-item='Создать объектное КП'>Создать объектное КП</a>
      </li>
      
{*  ********************************************   Аналитика    ************************************************ *}      

      <li>
        <a href="?transition=70&user_login={$userdata['user_login']}" target="_blank">Аналитика</a>
      </li>

{*  ********************************************   ОТЧЕТЫ  ************************************************ *}      
      <li>
        <a href="?transition=71&user_login={$userdata['user_login']}" target="_blank">Отчеты</a>
      </li>

{*      <li>
        <a href="?transition=13&user_login={$userdata['user_login']}" target="_blank">Аналитика</a>
      </li>
*}
{*  ********************************************   Наименование пользователя ************************************************ *}
      <li>
        <a href="?transition=97">Пользователь: {$userdata['user_name']}</a>
        {if count($arr_overdue_now) >0}
        <a class="overdue_kp_now" href="?transition=41&overdue_type=1">{count($arr_overdue_now)}</a>
        {else}
        <a class="overdue_kp_now" href="#">{count($arr_overdue_now)}</a>
        {/if}
        {if count($arr_overdue_all) >0}
        <a class="overdue_kp_all" href="?transition=41&overdue_type=2">{count($arr_overdue_all)}</a>
          {else}
        <a class="overdue_kp_all" href="#">{count($arr_overdue_all)}</a>
           {/if}
{*  ********************************************   Поисковики ************************************************ *}
 <li>
     <a href="?transition=80&user_login={$userdata['user_login']}" target="_blank">Поиск</a>
  </li>        
{* Ввод нового Юзера *}
      {if $userdata['userType'] >= 1}
      <li>
        <a href="?transition=5&user_login={$userdata['user_login']}" data-item='Новый пользователь' >Новый пользователь</a>
      </li>
      {/if}

      {if $userdata['userType'] > 1}
        <li>
          <a href="?transition=6" data-item='Редакт Юзера' >Редакт Юзера</a>
        </li>
        {/if}

    </ul>
  </nav>

</div>
