<div class="mail_about_company">
<p class="mail-center"> ФОРМА ДЛЯ ОТПРАВКИ ПИСЬМА КЛИЕНТУ</p>
    {if ($link_pdf_excel <> '') } 
    {*   если есть Ексель файл, то выводим данне с него *}
        <i>Вводный текст:</i> <b>{$ZakupName}</b><br>
        <i>Заказчик :</i> <b>{$Zakazchik}</b><br>
        <i>ИНН :</i><b> {$InnCustomer} </b><br>
        <i>EMAIL из КП :</i> <b>{$Email}</b>
    {else} {* Если ексель файла нет *}
      <h5 class ="alarm_font">КП в формате EXCEL отсутствует на сервере </h5>
    {/if}


<hr>
<form enctype="multipart/form-data" action="mailer/sender_letter_many.php"  method="post">
    <!-- передаем ID  закупки -->
    
    <input hidden name="id" value={$id}>
    <!-- передаем Наименование Заказчика -->
    <input hidden name="Zakazchik" value={$Zakazchik}>
    <!-- имя пользователя : --> 
    <input hidden name="user_mail" value={$userdata["user_login"]}>
    <!-- Наименование Закупки : -->
    <input hidden name="ZakupName" value = {$ZakupNameTemp}>



<div class="container">
{********************* Блок с выводм емайлов ************************************}
<div class="emails_from_db">

{if ($InnCustomer <>'')} 

       {if ($count_arr_emails > 0)} 
            <b>Email из Базы Данных: (Выберите один EMAIL , либо введите новый)</b>
            <br><br>
              <table>
                <tr>
                  <td class="emails_table_db email_table_shapka">email</td>
                  <td class="emails_table_db email_table_shapka">Состояние</td>
                  <td class="emails_table_db email_table_shapka">Коммент</td>
                  <td class="emails_table_db email_table_shapka">Дата создания</td>
                </tr>

                {foreach from=$arr_emails item=$value }
                <tr>
                  <td class="emails_table_db">
                  <input type="radio" name="email_from_kp" value="{$value['email']}">{$value['email']}
                  </td>
                  <td class="emails_table_db">{$value['actual']}</td>
                  <td class="emails_table_db">{$value['comment']}</td>
                  <td class="emails_table_db">{$value['date_write']}</td>
                </tr>
                {/foreach} 
         </table>
     {else}
      <b class="alarm_font">В базе данных отсутствует EMAIL!!!</b>
      <br><br>
       <label for="email_from_kp">Email из КП </label>
    <input type="radio" name="email_from_kp" value="{$Email}">{$Email}
    <br><br>
  {/if}
        {else}
      <b class="alarm_font">В базе данных отсутствует EMAIL!!!</b>
      <br><br>
       <label for="email_from_kp">Email из КП </label>
    <input type="radio" name="email_from_kp" value="{$Email}">{$Email}
    <br><br>
   
{/if}
<br>
<b>Новый EMAIL для отправки КП :</b>
<input type="email"  name="email_from_kp_new" value=""><Br>

</div> {* конец блок с выводом емайлов*}

{********************* Вложение в письмо ************************************}
<div class="add_post_file">
{* Когда нужно отправить файл загруженный на сервер *}
{if $real_file == 1 }

  <b>Выберите файлы для отправки:</b>
  <br>
  Коммерческое предложение по выбранному КП: 
      <br>
      <input checked type="checkbox"  name="link_pdf" value="{$link_pdf}">
      <a href="{$link_pdf}" target="_blank"><img src="icons/table/pdf.png"></a>
      {$link_pdf_text}
      
   {*   <input type="hidden" name="link_pdf" value={$link_pdf}> *}


  {$i=0}
  <hr>
  <br>
     {if (isset($new_link_kp_by_our_id) >0)}
        <b>Остальные сформированные КП:</b>
          <hr>
        {foreach from=$new_link_kp_by_our_id item=dop_kp}
            <input type="hidden" name="count_dop_kp" value="{$count_dop_kp}">   
            <input type="checkbox"  name="dop_kp_{$i}" value="{$dop_kp}"> 
            <label for="dop_kp_{$i}"><a href="{$dop_kp}" target="_blank"><img src="icons/table/pdf.png"></a>
            {$dop_kp}</label>
             <hr>        
            {$i=$i+1}
        {/foreach}
      {/if}
    Подгрузить дополнительные файлы к КП  <b>(макс. размер 0,5 Мб каждый)</b> <br> подгрузите файл(ы) для отправки :
      <input type="hidden" name="MAX_FILE_SIZE" value="500000" multiple>   
      <input name="upload_file[]" type="file" multiple>
  

{else}
{* Когда нужно отправить файл новый файл *}

  <b class="alarm_font">файл {$link_pdf_text} на сервере отсутствует.</b> <br><br> подгрузите файл(ы) для отправки :
 <input type="hidden" name="MAX_FILE_SIZE" value="500000" multiple>   
 <input name="upload_file[]" type="file" multiple>

{/if}


<hr>
<br>
<b> Рекламные каталоги к КП:</b>
<br>

{*
//Старые каталоги
<input type="checkbox"  name="catalog_present" value="1"> 
<label for="catalog_present">Включить ПРЕЗЕНТАЦИЮ в письмо</label> <br>

<input type="checkbox"  name="catalog_bordur"  value="1"> 
<label for="catalog_bordur">Включить в письмо каталог с бордюрами</label> <br>

<input type="checkbox"  name="catalog_inox"  value="1"> 
<label for="catalog_inox">Включить в письмо каталог нержавейки</label> <br>

 *}

<select name="catalog">
  <option value="0"></option>
  <option value="1">Презентация</option>
  <option value="2">Бордюры</option>
  <option value="3">Нержавейка</option>
  <option value="4">Грязезащита</option>

</select>



</div> {* конец блока с вложением письма*}

</div> {* конец контейнера *}



{********************* ТЕКСТ ПИСЬМА ************************************}
<div class="container">

<div class = "post_text">

<h4>Предмет письма</h4>
<p>
<input type="text"  name="subject_theme"  size="50" value = "КП от ТД АНМАКС" placeholder="КП от ТД АНМАКС">
</p>
<h5>ТЕКСТ ПИСЬМА</h5>

<textarea name="bodypost" cols="100" rows="4">
Здравствуйте!<br>
{if $type_kp == 6 }
Предлагаем рассмотреть приобретение следующей продукции, для гос.закупки
{/if}
{$ZakupName}
</textarea>
<br>
<input type="checkbox"  name="certifikat" checked value="Вся продукция сертифицирована."> 
<label for="certifikat">Вся продукция сертифицирована.</label> <br>

<input type="checkbox"  name="better_offer" checked value="Если у Вас есть более интересное предложение, сообщите нам, пожалуйста, мы постараемся улучшить условия нашего КП.">
<label for="better_offer">Если у Вас есть более интересное предложение, сообщите нам, пожалуйста, мы постараемся улучшить условия нашего КП.</label> <br>

  <br>
    С уважением<br>
    {$userdata['ful_name']}<br>
    {$userdata['user_phone']}<br>
    {$userdata['user_mobile_phone']}<br>
    {$userdata['user_email']}<br>
    <a href="https://anmaks.ru">anmaks.ru</a>
  </div> {* конец текста пиьсма post_text *}
  </div> {* конец контейнера *}
<div class="mail_button">
    <button class="submit" type="submit">Отправить</button>
</div> {* конец mail_button *}
</form>
</div> {* конец класса mail_about_company*}

