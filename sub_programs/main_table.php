<?php
include_once 'functions/full_get.php'; // считваем все GET данные
include_once 'functions/form_select.php'; // Настраиваем SQL запрос
// include_once 'functions/setup_url_for_maintable.php'; // функции для настройки количества вывода страниц и КП на странице

$smarty->assign('transitionForForm', 7); //  Задаем тип перехода при нажатии на кнопки обновить
$smarty->display('info_filtr.tpl');

include_once 'functions/setup_param_main_table.php'; // настраиваем всек данные для шаблона
include_once 'sub_programs/page_number.php'; // выводим номера страниц на таблице

$smarty->display('info_setup_filtr.tpl');
$smarty->display('main_table.tpl');

include 'sub_programs/page_number.php'; // выводим номера страниц на таблице
