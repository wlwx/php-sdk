<?php

/**
 * Created by PhpStorm.
 * User: zhouzhao
 * Date: 2017年4月11日 12:03:16
 */
require_once('Result.php');
class HttpUtil {
    /**
     * 发送post请求，返回json格式
     * @param $url
     * @param $post_data
     * @return Result
     */
    public static function PostCURL($url,$post_data){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','charset=utf-8'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $retry=0;
        // 若执行失败则重试
        do{
            $output = curl_exec($ch);
            $retry++;
        }while((curl_errno($ch) !== 0) && $retry<$GLOBALS['WLWX_CONFIG']['RETRY_TIMES']);

        if (curl_errno($ch) !== 0) {
            $r = new Result(null, $post_data, null,curl_error($ch));
            curl_close($ch);
            return $r;
        }
        $output = trim($output, "\xEF\xBB\xBF");
        $statusCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        $ret = new Result($statusCode,$post_data,json_decode($output,true),null);
        curl_close($ch);
        return $ret;
    }

    /**
     * 发送post请求，返回字符串格式
     * @param $url
     * @param $post_data
     * @return Result
     */
    public static function PostCURL_Multi($url,$post_data){
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $retry=0;
        // 若执行失败则重试
        do{
            $output = curl_exec($ch);
            $retry++;
        }while((curl_errno($ch) !== 0) && $retry<$GLOBALS['WLWX_CONFIG']['RETRY_TIMES']);

        if (curl_errno($ch) !== 0) {
            $r = new Result(null, $post_data, null,curl_error($ch));
            curl_close($ch);
            return $r;
        }
        $statusCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        $ret = new Result($statusCode,$post_data,$output,null);
        curl_close($ch);
        return $ret;
    }
}