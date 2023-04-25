<?php

use com\nlf\calendar\Lunar;
$Lunar = Lunar::fromDate(new DateTime());
$lunar_md = '农历' . $Lunar->getMonthInChinese() . '月' . $Lunar->getDayInChinese();
$lunar_ymd = '<i>' . $Lunar->getYearGan().$Lunar->getYearZhi() . $Lunar->getYearShengXiao() . '年</i><i>' . $Lunar->getMonthInGanZhi() . '月</i><i>' . $Lunar->getDayInGanZhi() . '日</i><i>星期' . $Lunar->getSolar()->getWeekInChinese() . '</i>';
$Lunar_week = '星期' . $Lunar->getSolar()->getWeekInChinese();
$lunar_nayin = $Lunar->getDayNaYin();
$lunar_chongsha = '冲' . $Lunar->getChongDesc() . ' 煞' . $Lunar->getSha();
$lunar_pengzu = $Lunar->getPengZuGan() . ' ' . $Lunar->getPengZuZhi();
$lunar_xishen = $Lunar->getPositionXiDesc();
$lunar_fushen = $Lunar->getPositionFuDesc();
$lunar_caishen = $Lunar->getPositionCaiDesc();
$lunar_yi =$Lunar->getDayYi();
$lunar_ji =$Lunar-> getDayJi();
$lunar_jshen =  $Lunar->getDayJiShen();
$lunar_xshen =$Lunar->getDayXiongSha();
$lunar_yi_str ='<i>'.implode('</i><i>',$lunar_yi).'</i>';
$lunar_ji_str ='<i>'.implode('</i><i>',$lunar_ji).'</i>';
$lunar_jshen_str ='<i>'.implode('</i><i>',$lunar_jshen).'</i>';
$lunar_xshen_str ='<i>'.implode('</i><i>',$lunar_xshen).'</i>';
?>