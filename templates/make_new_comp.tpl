
{* ДОБАВИТЬ НОВУЮ КОМПАНИЮ ПО ИНН *}
{include file="header.tpl" title=foo}

<div class="zagolovok"> Добавить Новую компанию по ИНН</div>
 {*    ********************** ИНН Заказчика   ********************} 


{* Модуль DADATA для вывода данных о компании*}
{if isset({$input_inn})}
     <section class="block">
    <p><strong>Введите наименование компании или ИНН</strong></p>
    <input id="party" name="party" type="text" value="{$input_inn}">
    </div>  
  </section> 
{else} 
     <section class="block">
    <p><strong>Введите наименование компании или ИНН</strong></p>
    <input id="party" name="party" type="text" placeholder="Введите название, ИНН, ОГРН или адрес организации">
    </div>  
  </section>  
{/if}

<br><br><br>

{*  Форма для ввода данных  *}
<form enctype="multipart/form-data" action="pdo_connect_db/insert_new_comp_in_bd.php" method="post">


{*    ********************** Прячем тут ИНН если он был введен  ***************}  
<div class="block green_bgc">  
 <p class="pad5px width15 zhir"> ИНН Заказчика :
    <input required id="inn" type="number" name="InnCustomer" value="">  
</p>
 <p class="pad5px width15 zhir"> КПП Заказчика :
    <input required id="kpp" type="number" name="KppCustomer" value="">  
</p>

{*    ********************** Прячем тут ИД КП если он есть ***************}  
{if ($id<>'')}
         <input hidden name="id" type="text" value="{$id}">
    
{/if}


 {*    ********************** Наименование Заказчика   ********************} 

 <p class="pad5px width15 zhir">Краткое наименование : <input required id="name_short" type="text" name="NameCustomer" value ="" size="70"></p>

 {*    ********************** Телефон Заказчика   ********************} 
<p class="pad5px width15 zhir">Телефон Заказчика : <input name="TelCustomer" size="70" data-phone-pattern></p>
        
        


 {*    ********************** Почта Заказчика   ********************} 
 <p class="pad5px width15 zhir">Эл. Почта Заказчика : <input type="email" name="EmailCustomer" value ="" size="70"></p>

 {*    ********************** Контактное лицо Заказчика   ********************} 
   <p class="pad5px width15 zhir">Контактное лицо   : <input type="text" name="ContactCustomer" value ="" size="70"></p>

 {*    ********************** Адрес Заказчика   ********************} 
   <p class="pad5px width15 zhir">Адрес Заказчика   : <input id="address" type="text" name="Adress" value ="" size="70"></p>


<input type="hidden" name="back_transition" value="{$back_transition}"> 

 {*  ********************************** Кнопка Создать ***************}
 
 <p><input type="submit" value="Создать"></p>


 </div>
 </form>


  <div class="block"> 
      <a class="zagolovok" href="?transition={$back_transition}&user={$userdata['user_login']}">Вернуться в создание КП</a>
 </div>
 
 {*  ********************************** Скрипты дл я ДАДАТЫ   ****************************}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.12.0/dist/js/jquery.suggestions.min.js"></script>
  
  <script>
      $("#party").suggestions({
          token: "ef0e1d4c5e875f38344a698c7bfae1f02078f7ed",
          type: "PARTY",
          /* Вызывается, когда пользователь выбирает одну из подсказок */
          onSelect: function(suggestion) {
              console.log(suggestion);
          }
      });
  </script>
  <script src="dadata/dadate.js"></script>


{include file="footer.tpl"}
              
