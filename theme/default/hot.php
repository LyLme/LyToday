<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>实时热搜榜 - <?php echo $config['title']; ?></title>
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
    <link rel="stylesheet" href="../<?php echo $config['theme']; ?>/css/style.css">
    <script src="../<?php echo $config['theme']; ?>/js/html2canvas.min.js"></script>
    <?php $colors = ['#EF5350', '#FBC02D', '#d6569b', '#52ab62', '#FB8C00', '#3eb4f0', '#7E57C2'];?>
    <style>.root-color {color:<?php echo $colors[date("w")] ?>;}.root-background {background-color:<?php echo $colors[date("w")] ?>;}</style>
</head>
<body>
  <div id="root">
    <div class="min-h-screen" style="background-color: rgb(255, 255, 255);">
      <div class="lylmepage relative left-[50%] -translate-x-[50%]">
        <div id="lylme" class="root-background">
          <header font="song bold" text="center white" pb-2="">
            <div flex="" items-center="" mb-5="">
              <div flex-1=""></div>
              <button class="roo-color " px-3="" py-3="" data-html2canvas-ignore id="saveimg" onclick="saveimg(true)">保存图片</button>
            </div>
           
            <h2 text-5xl="" py-3=""><a href="../">实时热搜榜</a></h2>

<p text-3xl="" tracking-wider="" pt-2="" mt-2="">
 <?php echo date('n月j日 H:i') ?>
</p>
            <div pt-2="" text-lg="" tracking-wider="">
              <span>
                <?php echo $Lunar_week ?>
              </span>
              <span ml-8="">
                <?php echo $lunar_md ?>
              </span>
            </div>

          </header>
          <main m-4="" bg-white="" px-3="" py-4="" card-shadow="">

              <!-- 实时热搜 -->
              <div my-3="">
              
               
                  <?php
                  if (!empty($hots)) {
                    foreach ($hots as $item) {
                      echo '<h1 class="root-color" font="song bold"><i>「' . $item["name"] . '」</i></h1>  
                      <ul text-sm="">';

                      $slices = $item['data'];
                      $i = 1;
                      echo '<table class="table" text-sm="" width="100%" border="0" cellpadding="0" cellspacing="0"><tbody>';
                      foreach ($slices as $slice) {
                        echo ' <tr>
                        <td class="h1" align="center">' . $i . '.</td>
                        <td class="h2"><a href="' . $slice['url'] . '" target="_blank" rel="nofollow">'.$slice['title'].'</a></td>
                        <td class="h3" align="right">' . formatNumber($slice['hotScore']) . '</td>
                        </tr>';
                       $i++;
                      }
                      echo '</tbody></table></ul>';
                    }
                  } else {
                    echo '<li class="mt-1 leading-6">获取数据失败</li>';
                  }
                  ?>
                
              </div>

         
          </main>
          <footer flex-center="" font-sans="" pt-2="" pb-7="" text="white sm">
            <!--<a href="#" target="_blank" mr-2="">©MurphyChen&@LyLme</a> -->
          </footer>
        </div>
      </div>
    </div>
  </div>
</body>

<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <div id="caption">长按保存完整图片</div>
  <img id="imgview" class="modal-content" />
</div>

</html>
<script>
  var imgview = document.getElementById('imgview');
  var modal = document.getElementById('myModal');

  var img = document.getElementById('saveimg');
  var modalImg = document.getElementById("imgview");
  var span = document.getElementsByClassName("close")[0];

  function saveimg(wx = false) {

    html2canvas(document.getElementById('lylme'), {
      scale: 2,
      useCORS: true,
      backgroundColor: null,
    }).then((canvas) => {
      let imgUrl = canvas.toDataURL('image/png', 1);
      if (wx) {
        imgview.src = imgUrl;
        modal.style.display = "block";
        return imgUrl;
      } else {
        const a = document.createElement("a");
        const event = new MouseEvent("click");
        a.download = 'LyToday';
        a.href = imgUrl;
        a.dispatchEvent(event);
      }
    });
  }

  span.onclick = function() {

    modal.style.display = "none";
    imgview.src = '';
  }
</script>
<!--
 - LyToday基于PHP开发，微信公众号：上云六零
 - 今日黄历功能使用@6tail的Lunar开发 https://6tail.cn/
 - 前端来自@MurphyChen https://mphy.me https://github.com/hacker-c/60s-view
 -->