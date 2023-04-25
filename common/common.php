<?php
/*
 * @Author: LyLme admin@lylme.com
 * @Date: 2023-04-25 20:42:16
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2023-04-26 03:32:34
 * @FilePath: common/common.php
 * @Description: 公共文件
 */
error_reporting(0);
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT', dirname(SYSTEM_ROOT) . '/');
require ROOT . 'config.php';
require SYSTEM_ROOT . 'Today.php';

use lylme\today\Today;
$Today = new Today;
if ($config['lunar']) {
    require SYSTEM_ROOT . 'Lunar.php';
    require SYSTEM_ROOT . 'lunar_str.php';
}
if ($config['day60s']) {
    $day60s = $Today->get60sView();
}
if ($config['history']) {
    $history_today = $Today->getHistoryToday(date('m'), date('d'));
}

function yan()
{
    $filename = SYSTEM_ROOT . 'data/yan/yan.txt';
    if (file_exists($filename)) {
        $data = explode(PHP_EOL, file_get_contents($filename));
        $day = intval((count($data) + date('z')) % count($data));
        return str_replace(array("\r", "\n", "\r\n"), '', $data[$day]);
    } else {
        return "一万年太久，只争朝夕！";
    }
}
include($config['theme'] . '/index.php');