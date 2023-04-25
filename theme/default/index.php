<?php
/*
 * @Author: LyLme admin@lylme.com
 * @Date: 2023-04-25 11:09:06
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2023-04-25 22:23:57
 * @FilePath: theme/default/index.php
 * @Description: default模板@MurphyChen
 */
include $config['theme'] . '/head.php';
?>

<body>
  <div id="root">
    <div class="min-h-screen" style="background-color: rgb(255, 255, 255);">
      <div class="lylmepage relative left-[50%] -translate-x-[50%]">
        <div id="lylme" class="root-background">
          <header font="song bold" text="center white" pb-2="">
            <div flex="" items-center="" mb-5="">
              <div flex-1=""></div>
              <button class="roo-color " px-3="" py-3="" data-html2canvas-ignore id="saveimg"
                onclick="saveimg(true)">保存图片</button>
            </div>
            <p font-normal="" text-lg="" pt-1="">120秒视界</p>

            <p text-3xl="" tracking-wider="" pt-2="" mt-2="">
              <?php echo date('Y') ?>
            </p>
            <h2 text-5xl="" py-3="">
              <?php echo date('n月j日') ?>
            </h2>
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
            <?php if ($config['day60s']) { ?>

              <!-- 60秒读懂世界 -->
              <div my-3="">
                <h1 class="root-color" font="song bold"><i>「60秒读懂世界」</i></h1>
                <ul text-sm="">
                  <?php
                  foreach ($day60s as $item) {
                    echo '<li class="mt-1 leading-6">' . $item . '</li>';
                  }
                  ?>
                </ul>
              </div>
            <?php } ?>
            <?php if ($config['history']) { ?>
              <!-- 历史上的今天 -->
              <div my-3="">
                <h1 class="root-color" font="song bold"><i>「历史上的今天」</i></h1>
                <ul text-sm="">
                  <?php
                  foreach ($history_today as $item) {
                    echo ' <li class="leading-6"><a href="' . $item['link'] . '"
                target="_blank" title="' . $item['desc'] . '"><span inline-block="" w-8="" text-right="" font-sans=""><i>' . $item['year'] . '</i></span><span
                  mx-1="">·</span><span>' . $item['title'] . '</span></a></li>';
                  }
                  ?>
                </ul>
              </div>
            <?php } ?>
            <?php if ($config['lunar']) { ?>
              <!-- 今日黄历 -->
              <div my-3="">
                <h1 class="root-color" font="song bold"><i>「今日黄历」</i></h1>
                <div class="huangli">
                  <div id="md">
                    <?php echo $lunar_md; ?>
                  </div>
                  <div id="ymd">
                    <?php echo $lunar_ymd; ?>
                  </div>
                  <div class="nayin"><b>五行</b><i id="nayin">
                      <?php echo $lunar_nayin; ?>
                    </i></div>
                  <div class="chongsha"><b>冲煞</b><i id="chongsha">
                      <?php echo $lunar_chongsha; ?>
                    </i></div>
                  <div class="pengzu"><b>彭祖</b><i id="pengzu">
                      <?php echo $lunar_pengzu; ?>
                    </i></div>
                  <div class="xishen"><b>喜神</b><i id="xishen">
                      <?php echo $lunar_xishen; ?>
                    </i></div>
                  <div class="fushen"><b>福神</b><i id="fushen">
                      <?php echo $lunar_fushen; ?>
                    </i></div>
                  <div class="caishen"><b>财神</b><i id="caishen">
                      <?php echo $lunar_caishen; ?>
                    </i></div>
                  <div class="yiji" id="yi">
                    <b>宜</b>
                    <?php echo $lunar_yi_str; ?></i>
                  </div>
                  <div class="yiji ji" id="ji">
                    <b>忌</b>
                    <?php echo $lunar_ji_str; ?></i>
                  </div>
                  <div class="shen" id="jshen">
                    <b>吉神</b>
                    <?php echo $lunar_jshen_str; ?></i>
                  </div>
                  <div class="shen xiong" id="xshen">
                    <b>凶神</b>
                    <?php echo $lunar_xshen_str; ?></i>
                  </div>
                </div>
              </div>
            <?php } ?>
            <?php if ($config['yan']) { ?>
              <div my-3="">
                <h1 class="root-color" font="song bold"><i>「每日一语」</i></h1>
                <p text-sm="">
                  <?php echo yan() ?>
                </p>
                <!--<p>欢迎关注上云六零公众号</p>-->
              </div>
            <?php } ?>
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

  span.onclick = function () {

    modal.style.display = "none";
    imgview.src = '';
  }
</script>
<!--
 - LyToday基于PHP开发@上云六零工作室
 - 今日黄历功能使用@6tail的Lunar开发 https://6tail.cn/
 - 前端来自@MurphyChen https://mphy.me https://github.com/hacker-c/60s-view
 -->