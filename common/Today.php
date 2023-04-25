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

define('SYSTEM_ROOT', dirname(__FILE__) . '/');
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
        if(!file_exists($cachefile)){
            $this->updateCache('');
        }
        $cache = json_decode(file_get_contents($cachefile), true); //缓存信息
        if (file_exists($filename)) {
            //今日缓存文件存在
            $json = file_get_contents($filename);
            $data = json_decode($json, true);
            return $data['data'];

        } else if ($cache['updatetime'] + 3600 <= time() || empty($cache['latest'])) {
            //缓存过期（有效期1h）

            $response = $this->getCurl('https://cdn.lylme.com/api/60s/'); //60秒简报接口
            $data = json_decode($response, true);
            if ($data['status'] != 200) {
                //获取失败（使用缓存）
                $file = $filedir . $cache['latest'];
                clearstatcache();
                if (is_file($file)) {
                    $latest = json_decode(file_get_contents($file), true);
                    $latest_data = array_push($latest, '拉取最新数据失败！');
                    return $latest_data;
                } else {
                    return ['获取数据失败！'];
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
                array_unshift($cachedata, '<b>今天的60秒简讯还未更新，下面是' . explode('.', $cache['latest'])[0] . '的简讯！</b>');
                return $cachedata;
            } else {
                return ['获取数据失败！'];
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
    public function getCurl($url)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.69 Safari/537.36'
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
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
     * Undocumented function
     *
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
}