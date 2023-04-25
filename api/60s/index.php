<?php
/*
 * @Author: LyLme admin@lylme.com
 * @Date: 2023-04-23 11:11:08
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2023-04-26 03:29:04
 * @FilePath: api/60s/index.php
 * @Description: 60秒读懂世界api接口
 */
header("Content-type:application/json");
require '../../common/Today.php';
use lylme\today\Today;

$cachefile = SYSTEM_ROOT.'data/60s_view/cache.json';
$cache = json_decode(file_get_contents($cachefile), true);
$Today = new Today;
$data = $Today->returnJson($Today->get60sView(),$cache['time']);
exit($data);