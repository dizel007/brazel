
<br>
    <b>{$shapka['kp_name']}</b>
<br>
<table class = "shapka_kp">

<tr>
  <td>Заказчик :</td>
  <td> {$shapka['Zakazchik']} 
  {if (($InnCustomer <> 0))}
    ИНН: {$InnCustomer}
    {/if}
    </td>
  {if (($InnCustomer == 0) && ($priz_update_inn == '') )}
    <td><div>
      <a class="link_inn" href="?transition=3&back_transition=30&user=zeld&id={$id}&InnCustomer="> 
        Привязать к ИНН
      </a>
    </div>
      </td>

  {/if}
   {if ($priz_update_inn <> '')}
    <td>
        <div class="major_info">
            При сохранении формы к КП будет привязан ИНН: {$priz_update_inn} ({$NameCustomer})
        </div>
    </td>
  {/if}

</tr>
{*<tr>
  <td>Телефон :</td>
  <td>{$shapka['Phone']}</td>
</tr>
<tr>
  <td>Эл. почта :</td>
  <td>{$shapka['Email']}</td>
</tr>*}
</table>

{$p=0}

{******************************** Начало ФОРМЫ **************************************************}
<form class ="contact_form_change_kp" action ="update_data_in_kp/format_data_for_make_kp.php" method="POST">

<table class ="dop_table_cs">
<tr>
  <td>Телефон :
    <input size ="" type="text" name = "telefon_zakaz" value ="{$shapka['Phone']}">
  </td>
</tr>
<tr>
  <td>Email :
  <input size ="" type="text" name = "email_zakaz" value ="{$shapka['Email']}"></td>
</tr>
<tr>
  <td>Контактное лицо :
  <input size ="" type="text" name = "contact_face_zakaz" value ="{$shapka['ContactCustomer']}"></td>
</tr>

<tr>
    <td>
    {* Источник КП *}
                  <label for="type_kp">Источник КП</label>
                <select class="update_type_kp" size="1" name="type_kp">
                  {for $i=0 to  (count($AllKptype)-2)}
                    {if ($type_kp == $AllValuesKptype.$i)}
                        <option selected value="{$AllValuesKptype.$i}">{$AllKptype.$i}</option>
                      {/if} 
                  {/for}

                    {for $i=0 to  (count($AllKptype)-2)}
                      {if ($type_kp == $AllValuesKptype.$i)}
                        {continue}
                      {/if} 
                    <option value="{$AllValuesKptype.$i}">{$AllKptype.$i}</option>
                  {/for}
                </select>
            

    </td>
</tr>
 <tr>
  <td>
   {* Тип продукции *}
        <label for="product_type">Тип продукции в КП</label> 
          <select class="update_type_kp" size="1" name="product_type">
             {for $i=0 to  (count($AllProductTypesName)-1)}
                {if ($type_product == $AllProductTypesValue.$i)}
                   <option selected value="{$AllProductTypesValue.$i}">{$AllProductTypesName.$i}</option>
                 {/if} 
             {/for}


             {for $i=0 to  (count($AllProductTypesValue)-1)}
                 {if ($type_product == $AllProductTypesValue.$i)}
                         {continue}
                 {/if}
                  <option value="{$AllProductTypesValue.$i}">{$AllProductTypesName.$i}</option>
               {/for}
          </select>
    
  </td>
</tr>

</table>
{* *}
  {if ($priz_update_inn <> '')}
    <input hidden name="InnCustomer" value="{$priz_update_inn}">
  {/if}
  
<div class="text_in_kp">Текст в Коммерческом предложении :</div>
     <textarea class="zonavvoda" name="ZakupName" rows="5" cols="10">{$shapka['ZakupName']}</textarea>

<div class="text_in_kp">
Перечень товаров :
</div>

{***************************** Перечень товаров : ********************************************}

<table>
<tr>
  <td><p class ="table_p table_bgc">пп</p></td>
  <td><p class ="table_p table_bgc">Наименование</p></td>
  <td><p class ="table_p table_bgc">Ед.изм</p></td> 
  <td><p class ="table_p table_bgc">Кол-во</p></td> 
  <td><p class ="table_p table_bgc">Цена за ед.</p></td>  
  </tr>


{foreach from=$prods item=value}

<tr>
  <td><p class ="table_p"> {$p+1}</p></td>

{if $p==0}
  <td><input required size ="100" type="text" name = "name{$p}" value ="{$value['name']}"></td>
{else}
  <td><input size ="100" type="text" name = "name{$p}" value ="{$value['name']}"></td>
{/if}

  <td><input size ="2"   type="text" name = "ed_izm{$p}" value ="{$value['ed_izm']}"></td>
  <td><input size ="1"   type="number" step="any" name = "kol{$p}" value ="{$value['kol']}"></td>
  <td><input size ="1"   type="number" step="any" name = "price{$p}" value ="{$value['price']}"></td>
</tr>
  {$p = $p+1}
{/foreach}

 </table>
{************************************                    **************************************}


  <input hidden type="text" name = "id" value ="{$id}"></td>
  <input hidden type="number" name = "all_kolvo" value ="{$p}"></td>

   {if ($priz_update_inn == '')}
   <div class ="add_string">
        <a  href="?transition=30&id={$id}&add_str_plus={$add_str+1}">добавить строку</a>
    </div>
  {/if}

 



<table>
<tr>
  <td><label for="uslovia_oplati">Условия оплаты :</label></td>
  <td><input size ="70" type="text" name = "uslovia_oplati" value ="{$dop_info['uslovia_oplati']}"></td>
</tr>
<tr>
  <td>  <label for="srok_izgotovl">Срок изготовления :</label></td>
  <td><input size ="70"   type="text" name = "srok_izgotovl" value ="{$dop_info['srok_izgotovl']}"></td>
</tr>
<tr>
    <td>
      {if ($type_kp <> 6)}
         <label for="adress_dostavki">Условия отгрузки :  <label>
       {else}
         <label for="adress_dostavki">Примерная стоимость доставки до объекта :<label>
      {/if}

    
   </td>
      <td>    <label for="adress_dostavki">Цена доставки :  <label>  </td>
</tr>
<tr>
   <td>
        <input size="70" name = "adress_dostavki" value ="{$dop_info['adress_dostavki']}">
    </td>
    <td>
        <input size ="30" type="number" name = "price_dost" value ="{$dop_info['price_dost']}">
    </td>
  
</tr>  
  
  <br><br>

 


</table>
 <br> <br>
 <button class="submit" type="submit">Сформировать КП с новыми данными</button>
 </form>