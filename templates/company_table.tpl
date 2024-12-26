<div class="zagolovok">
        {$company_arr[0]['name']}
 </div>
       <table width="100%" class="table_inn employee_table">
       <tbody>
           <tr class="draw_inn">
             <td width="70">ИНН</td>
             
             <td width="200">Полное наименование</td> 
             <td  width="400">
             Телефон
           
             </td>
             <td width="32">
             <a href="?transition=10&id={$id}&InnCustomer={$company_arr[0]['inn']}&typeQuery=309#win309"><img src ="icons/table/plus.png"></a>
             </td>
             <td>Емайл</td>
             <td width="32">
             <a href="?transition=10&id={$id}&InnCustomer={$company_arr[0]['inn']}&typeQuery=409#win409"><img src ="icons/table/plus.png"></a>
             </td>
             <td>Контактное лицо</td>
             <td width = "160">Адрес</td>
             <td>Комментарий</td>
             <td>Ред</td>
          </tr>
          <tr class="draw_inn">
             <td class = "inntext" >{$company_arr[0]['inn']}</td>
            
             <td>{$company_arr[0]['fullName']}</td> 
             
<!-- ************************ ВЫВОД ТЕЛЕФОНОВ *********************************** -->
<td valign="top" colspan="2" width="300">

{* for ($i=0; to $i < count($telephons_company)) *}

  
<table width ="100%" class ="telephone">

{foreach $telephons_company as $value}
                {if $value['actual'] == "Актуальный"} 
                   {$act_phone ="actual_phone_number"}
                {elseif ($value['actual'] == "Неактуальный")} 
                   {$act_phone ="nonactual_phone_number"}
                {elseif $value['actual'] == "Не звонить"} 
                   {$act_phone ="nonactual_phone_number"}
                {elseif $value['actual'] == "Новый"}
                   {$act_phone ="new_phone_number"}
                {else}
                   {$act_phone =""}
                {/if}
    <tr>
       <td width ="20">
       <a class="link_tel" itemprop="telephone" href="tel:+{$value['telephone']}">
       <img style = "opacity: 0.9" src="icons/table/telephone.png">
       </a>
       </td>

        <td width="80" title="{$value['comment']}" class ="{$act_phone}">
         {$value['telephone']}
         </td>
         
         <!-- Актуальность номера -->
         <td width="40" >{$value['actual']}</td>

         <!-- WhatsApp -->
          <td width ="20"> 
          {if $value['whatsapp'] == 1} 
            {$whatsapp_o="0.9"}
          {else}
           {$whatsapp_o="0.3"}
          {/if}

          <a rel="nofollow" href="https://api.whatsapp.com/send?phone={$value['whatsapp_tel']}" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" opacity ="{$whatsapp_o}" viewBox="0 0 20 20"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M10.0036 0.00168721C8.21686 0.00116491 6.46263 0.479332 4.92332 1.38646C3.38401 2.29359 2.11583 3.59656 1.25065 5.15986C0.385481 6.72316 -0.0450837 8.4897 0.00373451 10.2758C0.0525527 12.0619 0.578971 13.8022 1.52825 15.316L1.76616 15.6939L0.755461 19.3824L4.54008 18.3903L4.90454 18.6063C6.4452 19.5187 8.20287 20.0001 9.99345 20H9.99851C12.6506 20.0004 15.1943 18.9473 17.0699 17.0723C18.9456 15.1972 19.9996 12.6539 20 10.0017C20.0004 7.34952 18.9473 4.80581 17.0723 2.93013C15.1973 1.05445 12.654 0.000447549 10.0019 0L10.0036 0.00168721ZM15.0176 15.2202C15.3666 14.9742 15.661 14.6587 15.8821 14.2934C16.0789 13.8444 16.1399 13.3476 16.0576 12.8643C15.9834 12.7394 15.7826 12.6668 15.4822 12.515C15.1819 12.3631 13.7021 11.6359 13.4271 11.5363C13.1521 11.4368 12.953 11.3861 12.7522 11.6865C12.5514 11.9868 11.976 12.6635 11.8005 12.8643C11.6251 13.065 11.4496 13.092 11.1493 12.9402C10.2627 12.5874 9.44445 12.0826 8.73134 11.4486C8.07412 10.841 7.51062 10.1393 7.05923 9.3664C6.88544 9.06606 7.04067 8.90407 7.19252 8.7539C7.32751 8.61891 7.49118 8.40294 7.64303 8.22745C7.76654 8.07559 7.86768 7.90683 7.94337 7.72631C7.98326 7.64338 8.00183 7.5518 7.99741 7.45988C7.99299 7.36796 7.96572 7.27859 7.91806 7.19986C7.84382 7.04969 7.24314 5.5699 6.99005 4.96921C6.74708 4.38201 6.50073 4.46132 6.31513 4.45288C6.13965 4.44276 5.93886 4.44276 5.73975 4.44276C5.58744 4.44684 5.43762 4.48237 5.29969 4.54713C5.16177 4.61188 5.03873 4.70445 4.93829 4.81903C4.59843 5.14069 4.32929 5.52961 4.14801 5.96101C3.96674 6.39242 3.8773 6.85685 3.88541 7.32473C3.98354 8.45825 4.41046 9.53846 5.11376 10.4328C6.40303 12.3647 8.17239 13.9283 10.2482 14.97C10.8076 15.2115 11.3792 15.4232 11.9608 15.6045C12.5741 15.7905 13.2223 15.8309 13.854 15.7226C14.2724 15.6372 14.6685 15.4661 15.0176 15.2202Z"
                              fill="#2CB742"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M15.0175 15.2202C15.3666 14.9742 15.661 14.6587 15.8821 14.2934C16.0789 13.8444 16.1399 13.3476 16.0576 12.8642C15.9834 12.7394 15.7826 12.6668 15.4822 12.515C15.1819 12.3631 13.7021 11.6359 13.4271 11.5363C13.1521 11.4368 12.953 11.3861 12.7522 11.6865C12.5514 11.9868 11.976 12.6635 11.8005 12.8642C11.6251 13.065 11.4496 13.092 11.1492 12.9402C10.2627 12.5873 9.44444 12.0826 8.73133 11.4486C8.0741 10.841 7.51061 10.1393 7.05921 9.3664C6.88542 9.06605 7.04065 8.90407 7.19251 8.75389C7.32749 8.61891 7.49116 8.40293 7.64302 8.22744C7.76652 8.07558 7.86766 7.90682 7.94336 7.72631C7.98324 7.64337 8.00181 7.5518 7.99739 7.45988C7.99297 7.36795 7.9657 7.27858 7.91805 7.19986C7.84381 7.04968 7.24313 5.56989 6.99003 4.9692C6.74706 4.38201 6.50071 4.46131 6.31511 4.45287C6.13963 4.44275 5.93884 4.44275 5.73974 4.44275C5.58743 4.44683 5.4376 4.48237 5.29968 4.54712C5.16175 4.61187 5.03871 4.70444 4.93827 4.81902C4.59841 5.14068 4.32927 5.5296 4.148 5.96101C3.96672 6.39241 3.87729 6.85685 3.88539 7.32472C3.98353 8.45824 4.41044 9.53845 5.11375 10.4328C6.40302 12.3647 8.17237 13.9283 10.2482 14.97C10.8075 15.2115 11.3792 15.4232 11.9608 15.6045C12.5741 15.7905 13.2223 15.8309 13.854 15.7226C14.2723 15.6372 14.6685 15.4661 15.0175 15.2202Z"
                              fill="white"></path>
                          </svg>
          </a>
          </td>

          <!-- Контактное лицо -->
          <td width ="130">{$value['name']}</td>

          <td width="20">
    
    <a href="?transition=10&id={$id}&id_phone={$value['id']}&typeQuery=300#win300" class="btn"><img style = "opacity: 0.9" src="icons/table/change.png"></a>
              </td>
      </tr>

{/foreach}
    </table>

    </td>
<!-- *********************  ВЫВОД EMAILS ********************* -->
 <td valign="top" colspan="2" width="400">
                     
{foreach $emails_company as $value}
                 {if $value['actual'] == "Актуальная"} 
                   {$act_email ="actual_phone_number"}
                {elseif ($value['actual'] == "Неактуальная")} 
                   {$act_email ="nonactual_phone_number"}
                {elseif $value['actual'] == "Новая"}
                   {$act_email ="new_phone_number"}
                {else}
                   {$act_email =""}
                {/if}                      


                     <table width ="100%" class ="telephone">
                         <tr>
                         <td width="150" class ="{$act_email}">
<a class = " link_tel {$act_email}" href="mailto:{$value['email']}"> {$value['email']}</a>
                              
                              </td>
                              <!-- Актуальность email -->
                              <td width="70">
                                 {$value['actual']}
                              </td>
                               <!-- КОмантарий к почте -->
                               <td width =""  title="{$value['comment']}">
                               {$value['comment']}
                               </td>
                               <td width="30">
                     <a href="?transition=10&id={$id}&id_email={$value['id']}&typeQuery=400#win400" class="btn"><img style = "opacity: 0.9" src="icons/table/change.png"></a>
                               </td>
                        </tr>
 </table>
        
{/foreach}
</td>          
 
 



 


 <!-- *********************  ВЫВОД КОНТАКТНОЕ ЛИЦО ********************* -->
             <td width ="200">{$company_arr[0]['contactFace']}</td>
             <td>{$company_arr[0]['adress']}</td>
             <td>{$company_arr[0]['comment']}</td>

<!-- *********************  Корректировка данных компании ********************* -->
             <td width="20">
             <a href="?transition=10&id={$id}&InnCustomer={$company_arr[0]['inn']}&typeQuery=200#win8" class="btn"><img style = "opacity: 0.9" src="icons/table/change.png" alt="formatZakup"></a>
             </td>
          </tr>


</tbody>
</table>