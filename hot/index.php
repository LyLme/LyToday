<?php
/* 
 * @Description: 热搜
 * @Author: LyLme admin@lylme.com
 * @Date: 2024-1-18 00:49:12
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2024-01-23 18:42:19
 * @FilePath: /LyToday/hot/index.php
 * @Copyright (c) 2024 by LyLme, All Rights Reserved. 
 */

require '../common/common.php';
if (!empty($_GET['type'])) {
    $parseHot = $Today->parseHot($hots, $_GET['type']);
    $hots = $parseHot[0];
    $hot_title = $parseHot[1];
}
require ROOT . $config['theme'] . '/hot.php';
