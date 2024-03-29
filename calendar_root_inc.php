<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/include/general_inc.php";
$current_dir = basename(__DIR__);
define("CALENDAR_ROOT", DOMEN . $current_dir . '/');
define("CALENDAR_ROOT_Q", DOMEN . $current_dir . '_q/');
define("CALENDAR", 'Учительский календарь');
define("CALENDAR_DESC", 'Календарь для учителя');
define("CALENDAR_PRINT", 'Учебный календарь распечатать');
define("CALENDAR_REQUEST_URI", $_SERVER["REQUEST_URI"]);

function _version ($fileName): string{
    return  'v=' . filemtime(__DIR__ . '/static/' . $fileName);
}