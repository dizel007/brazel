<?php
include_once 'functions/full_get.php'; // считваем все GET данные
include_once 'functions/form_select.php'; // Настраиваем SQL запрос
$smarty->display('info_filtr.tpl');
include_once 'functions/setup_param_main_table.php'; // настраиваем всек данные для шаблона
// $smarty->display('info_setup_filtr.tpl');
include_once 'sub_programs/page_number.php'; // выводим номера страниц на таблице



$smarty->assign('text', 'Несколько КП выводим по ID');
$smarty->display('title_razdel.tpl');

$smarty->display('main_table.tpl'); // выводим данные о выбранном КП

include 'sub_programs/page_number.php'; // выводим номера страниц на таблице


