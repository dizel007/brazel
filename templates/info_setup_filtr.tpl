{* Настройка строки с отображением ФИЛЬТРа*} 

<div class = "filter_p">
ФИЛЬТР : 
{if isset($kpCount)}
<b>{$kpCount}</b> КП:</b>
{else}
<b>0*</b> КП:</b>
{/if}


{if $get_nomerKP<>''}
<i>Номер КП :<b>{$get_nomerKP}</b></i>
{/if}
{if $get_date_start<>'' }
<i>Дата начала:<b>{$get_date_start}</b></i>
{/if}
{if $get_date_end<>'' }
<i>Дата окончания :<b>{$get_date_end}</b></i>
{/if}

{if $get_inn<>'' }
<i>ИНН :<b>{$get_inn}</b></i>
{/if}

{if $get_id_kp<>'' }
<i>ID_KP :<b>{$get_id_kp}</b></i>
{/if}


{if $get_name_zakazchik<>'' }
<i>Заказчик :<b>{$get_name_zakazchik}</b></i>
{/if}

{if ($get_responsible <>'') }
<i>ответственный :<b>{$get_responsible}</b></i>
{/if}

{if ($get_type_kp <>'') }
<i>Тип КП :<b>{$get_value_type_kp}</b></i>
{/if}

{if ($get_product_type <>'') }
<i>Тип продукции :<b>{$get_product_type_name}</b></i>
{/if}

{if ($get_KpCondition <>'') }
<i>Сост. КП :<b>{$get_KpCondition}</b></i>
{/if}


{if $get_adres_postavki <>'' }
<i>Адрес поставки :<b>{$get_adres_postavki}</b></i>
{/if}

</div>