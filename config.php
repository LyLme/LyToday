<?php
/* 
 * @Description: Lytoday配置文件
 * @Author: LyLme admin@lylme.com
 * @Date: 2024-01-23 12:16:33
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2024-01-23 20:32:56
 * @FilePath: /LyToday/config.php
 * @Copyright (c) 2024 by LyLme, All Rights Reserved. 
 */

$config = array(
    "title" => "LyToday视界", //网站标题
    "theme" => "theme/default", //网站主题
    "day60s" => true, //显示每天60秒读懂世界(bool)
    "history" => true, //显示历史上的今天(bool)
    "lunar" => true, //显示今日黄历(bool)
    "yan" => true, //显示每日一语(bool)
    "hot" =>true, //显示实时热搜(bool)
    "hotconf" =>array(
        //热搜配置
        "desc"=>false, //显示热搜页的热搜摘要(bool)，首页不显示，仅用于热搜页
        "updatef"=> 1800, //热搜数据更新频率(int)，单位:秒，默认值1800(30分钟)，不建议低于300，若更新太频繁可能被API拉黑服务器IP
        "show_all"=>true, //首页显示所有热搜(bool)
        "show"=>array("baidu","weibo","douyin","zhihu") //首页单独显示的热搜(array)，若单独启用某几个时将"show_all"的值修改为：false，若需要调整顺序，直接修改该数字对应项的顺序即可
        //热搜列表：baidu(百度热搜) weibo(微博热搜) douyin(抖音热点) zhihu(知乎热搜)
       
    )
);
