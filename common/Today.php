<?php
/*
 * @Author: LyLme admin@lylme.com
 * @Date: 2023-04-24 20:30:24
 * @LastEditors: LyLme admin@lylme.com
 * @LastEditTime: 2023-04-26 01:43:11
 * @FilePath: conmmon/Today.php
 * @Description: LyToday核心操作类
 */

namespace lylme\today;

class Today
{
    /**
     * 每天60秒读懂世界
     */
    public function get60sView()
    {
        $filedir = SYSTEM_ROOT . 'data/60s_view/'; //数据目录
        $filename = $filedir . date('Ymd') . '.json'; //今日缓存文件
        $cachefile = $filedir . "cache.json";
        if (!file_exists($cachefile)) {
            $this->updateCache('');
        }
        $cache = json_decode(file_get_contents($cachefile), true); //缓存信息
        if (file_exists($filename)) {
            //今日缓存文件存在
            $json = file_get_contents($filename);
            $data = json_decode($json, true);
            return $data['data'];
        } elseif ($cache['updatetime'] + 3600 <= time() || empty($cache['latest'])) {
            //缓存过期（有效期1h）

            $response = $this->getCurl('https://cdn.lylme.com/api/60s/'); //60秒简报接口
            $data = json_decode($response, true);
            if (empty($data['status']) || $data['status'] != 200) {
                //获取失败（使用缓存）
                $file = $filedir . $cache['latest'];
                clearstatcache();
                if (is_file($file)) {
                    $latest = json_decode(file_get_contents($file), true);
                    $latest_data = array_push($latest, '拉取最新数据失败！');
                    return $latest_data;
                } else {
                    return false;
                }
            } else {
                //获取成功
                $jsondata = $data['time'] . '.json';
                $this->updateCache($jsondata); //更新缓存时间
                file_put_contents($filedir . $jsondata, $response);
                return $data['data'];
            }
        } else {
            //从缓存中读取
            $file = $filedir . $cache['latest'];
            if (file_exists($file)) {
                $cachedata = json_decode(file_get_contents($file), true)['data'];
                array_unshift($cachedata, '今天的简讯未更新，下面是' . $this->fdate(explode('.', $cache['latest'])[0]) . '的简讯！');
                return $cachedata;
            } else {
                return false;
            }
        }
    }
    public function getHistoryToday($month, $day)
    {
        $filepath = SYSTEM_ROOT . 'data/history_today/';
        $json = file_get_contents($filepath . $month . '.json');
        $array = $this->getHistoryTodayJson($json, $month, $day);
        return $array;
    }

    /**
     * 获取历史上的今天
     * @param string $json JSON数据
     * @param string $month 指定月份(mm格式)
     * @param string $day (指定日期(dd格式)
     * @return array 历史上的今天
     */

    public function getHistoryTodayJson($json, $month, $day)
    {
        $month = strval($month);
        $day = strval($day);
        $data = json_decode($json, true)[$month][$month . $day];
        $array = [];
        foreach ($data as $item) {
            array_push(
                $array,
                array(
                    "year" => $item['year'],
                    "title" => strip_tags($item['title']),
                    "desc" => strip_tags($item['desc']),
                    "link" => $item['link'],
                    "date" => $month . $day
                )
            );
        }
        return $array;
    }
    /**
     * 实时热搜
     */
    public function hot()
    {

        $filedir = SYSTEM_ROOT . 'data/hot/'; //数据目录
        $filename = $filedir . 'data.json'; //最新缓存文件
        $cachefile = $filedir . "cache.json";
        if (!file_exists($cachefile)) {
            $this->updateHot();
        }
        $cache = json_decode(file_get_contents($cachefile), true); //缓存信息
        if (file_exists($filename) && $cache['updatetime'] + 3600 > time()) {
            //缓存文件存在，未过期
            $json = file_get_contents($filename);
            $data = json_decode($json, true);
            return $data['data'];
        } elseif ($cache['updatetime'] + 3600 <= time() || !file_exists($filename)) {
            //缓存文件不存在或过期（有效期1h）

            $response = $this->getCurl('https://cdn.lylme.com/api/hot/'); //实时热搜接口
            $data = json_decode($response, true);
            if (empty($data['code']) || $data['code'] != 200) {
                //获取失败（使用缓存）
                clearstatcache();
                if (is_file($filename)) {
                    $latest = json_decode(file_get_contents($filename), true);
                    $hot_data = $latest['data'];
                    $hot_updatetime = "热搜数据更新于" . $filename['time'];
                    array_unshift($hot_data, array("code" => 0, "data" => array("title" => $hot_updatetime, "url" => "#")));
                    return $hot_data;
                } else {
                    return false;
                }
            } else {
                //获取成功，更新缓存
                $this->updateHot(); //更新缓存
                file_put_contents($filename, $response);
                return $data['data'];
            }
        } else {
            //失败
            return false;
        }
    }
    public function getCurl($url)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_USERAGENT => 'LyToday_curl'
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    /**
     * 格式化日期
     * @param string $time 日期yyyymmdd格式
     * @return string 格式化后的日期
     */

    private function fdate($time)
    {
        preg_match('/([0-9]{4})([0-9]{2})([0-9]{2})/', $time, $ha);
        if (!empty($ha)) {
            $t = $ha[1] . '-' . $ha[2] . '-' . $ha[3];
            $strtotime = strtotime($t);
        }
        if (!isset($strtotime) || !$strtotime) {
            return $time;
        }
        $d = time() - $strtotime;
        $byd = time() - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
        $yd = time() - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
        switch ($d) {
            case $d == $yd:
                $fdate = '昨天';
                break;
            case $d == $byd:
                $fdate = '前天';
                break;
            default:
                $fdate = date('Y-m-d', $time);
                break;
        }
        return $fdate;
    }
    public function returnJson($data, $time = 0)
    {
        if (empty($data)) {
            $arr = array(
                "status" => 500,
                "message" => "error",
                "time" => date('Ymd')
            );
        } else {
            if ($time != 0 && $time <= date('Ymd')) {
                array_push($data, '');
            } else {
                $time = date('Ymd');
            }
            $arr = array(
                "status" => 200,
                "message" => "success",
                "data" => $data,
                "time" => $time
            );
        }
        return json_encode($arr, 320);
    }
    /**
     * 更新缓存
     * @param string $filename 文件名
     * @param integer $time 更新时间
     * @return void
     */
    public function updateCache($filename)
    {
        $filepath = SYSTEM_ROOT . 'data/60s_view/';
        $cachefile = $filepath . "cache.json";
        $cachearr = array(
            "updatetime" => time(),
            "latest" => $filename
        );
        file_put_contents($cachefile, json_encode($cachearr), 320);
    }

    public function updateHot()
    {
        $filepath = SYSTEM_ROOT . 'data/hot/';
        $cachefile = $filepath . "cache.json";
        $cachearr = array(
            "updatetime" => time()
        );
        file_put_contents($cachefile, json_encode($cachearr), 320);
    }
}
