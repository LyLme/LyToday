<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $config['title']; ?></title>
    <meta name="keywords" content="LyToday,60秒读懂世界,历史上的今天,今日黄历,上云六零,六零,LyLme,今日120秒视界,开源免费">
    <meta name="description" content="120秒视界LyToday每天120秒看世界，你是懂世界的。历史上的今天,今日黄历，上云六零PHP版。">
    <meta name="author" content="LyLme">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="full-screen" content="yes">
    <meta name="browsermode" content="application">
    <meta name="x5-fullscreen" content="true">
    <meta name="x5-page-mode" content="app">
    <link rel="stylesheet" href="<?php echo $config['theme']; ?>/css/style.css">
    <script src="<?php echo $config['theme']; ?>/js/html2canvas.min.js"></script>
    <?php $colors = ['#EF5350', '#FBC02D', '#d6569b', '#52ab62', '#FB8C00', '#3eb4f0', '#7E57C2'];?>
    <style>.root-color {color:<?php echo $colors[date("w")] ?>;}.root-background {background-color:<?php echo $colors[date("w")] ?>;}</style>
</head>