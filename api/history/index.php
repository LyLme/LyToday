<?php
/*
 * @Author: LyLme admin@lylme.com
 * @Date: 2023-04-23 10:40:18
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2023-04-23 13:45:45
 * @FilePath: api/history/index.php
 * @Description: 历史上的今天api接口
 */
header("Content-type:application/json");
require '../../common/Today.php';
use lylme\today\Today;

$Today = new Today;
$data = $Today->returnJson($Today->getHistoryToday(date('m'), date('d')));
exit($data);