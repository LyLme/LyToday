<?php
/* 
 * @Description: 公共文件
 * @Author: LyLme admin@lylme.com
 * @Date: Tue Jan 23 2024 12:16:33
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2024-01-23 19:25:00
 * @FilePath: /LyToday/common/common.php
 * @Copyright (c) 2024 by LyLme, All Rights Reserved. 
 */


//error_reporting(0);
ini_set('date.timezone', 'Asia/Shanghai');

define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT', dirname(SYSTEM_ROOT) . '/');
require ROOT . 'config.php';
require SYSTEM_ROOT . 'Today.php';

use lylme\today\Today;

$Today = new Today($config);
if ($config['lunar']) {
    require SYSTEM_ROOT . 'Lunar.php';
    require SYSTEM_ROOT . 'lunar_str.php';
}
if ($config['day60s']) {
    $day60s = $Today->get60sView();
}
if ($config['hot']) {
    $hots = $Today->hot();
    if (!$config['hotconf']['show_all']) {
        $show_list =  $config['hotconf']['show'];
        usort($hots, function ($a, $b) use ($show_list) {
            $posA = array_search($a['alias'], $show_list);
            $posB = array_search($b['alias'], $show_list);
            if ($posA === false) {
                $posA = PHP_INT_MAX; // 如果项目 $a 的 "name" 不在 $show_list 中，则将其位置设为最大值  
            }
            if ($posB === false) {
                $posB = PHP_INT_MAX; // 如果项目 $b 的 "name" 不在 $show_list 中，则将其位置设为最大值  
            }
            return $posA - $posB; // 返回位置差，决定排序顺序  
        });
        $hot_data = [];
        foreach ($hots as $hot) {
            if (in_array($hot['alias'], $show_list)) {
                $hot_data[] = $hot;
            }
        }
        $hots = $hot_data;
    }
    $hot_title = "热搜榜";
}
if ($config['history']) {
    $history_today = $Today->getHistoryToday(date('m'), date('d'));
}

function yan()
{
    $filename = SYSTEM_ROOT . 'data/yan/yan.txt';
    if (file_exists($filename) && is_readable($filename)) {
        $data = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $day = intval((count($data) + date('z')) % count($data));
        return str_replace(array("\r", "\n", "\r\n"), '', $data[$day]);
    } else {
        return "一万年太久，只争朝夕！";
    }
}
function formatNumber($number)
{
    if (!is_numeric($number)) {
        return $number;
    }
    if ($number >= 10000) {
        $number = round($number / 10000);
        return $number . 'w';
    } elseif ($number >= 1000) {
        $number = round($number / 1000);
        return $number . 'k';
    }
    return $number;
}
/**
 * 字符串截取并且超出隐藏
 * @Author: LyLme
 * @param string $text 文字
 * @param int $length 长度
 * @return void
 */
function subtext($text, $length)
{
    if (mb_strlen($text, 'utf8') > $length)
        return mb_substr($text, 0, $length, 'utf8') . '...   <b>详情></b>';
    else {
        return $text;
    }
}
