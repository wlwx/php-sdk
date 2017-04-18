<?php
/**
 * Created by PhpStorm.
 * User: zhouzhao
 * Date: 2017年4月10日 17:55:23
 */

require_once('HttpUtil.php');

class MultiSmsOperator {
    public $uid;
    public $cust_pwd;
    public $srcphone;
    public $wlwx_config;

    public function __construct($uid = null, $cust_pwd = null, $srcphone = null) {
        $this->wlwx_config = $GLOBALS['WLWX_CONFIG'];
        if ($uid == null)
            $this->uid = $this->wlwx_config['CUST_CODE'];
        else
            $this->uid = $uid;
        if ($cust_pwd == null)
            $this->cust_pwd = $this->wlwx_config['CUST_PWD'];
        else
            $this->cust_pwd = $cust_pwd;
        if ($srcphone == null)
            $this->srcphone = $this->wlwx_config['SP_CODE'];
        else
            $this->srcphone = $srcphone;
    }

    /**
     * 批量发送短信
     * @param array $data
     * @return Result
     */
    public function send_multiSms($data = array()) {
        if (!array_key_exists('msg', $data))
            return new Result(null, $data, null, 'msg 为空');
        $data['uid'] = $this->uid;
        $data['srcphone'] = $this->srcphone;
        $msgStr = $this->unicodeDecode(json_encode($data['msg']));
        $sign = urlencode($msgStr). $this->cust_pwd;
        $data['sign'] = md5($sign);
        $data['msg'] = urlencode( $msgStr );
        $o = "";
        foreach ( $data as $k => $v ) {
            $o.= "$k=" .$v."&" ;
        }
        $post_data = substr($o,0,-1);
        return HttpUtil::PostCURL_Multi($this->wlwx_config['URI_SEND_MULTI_SMS'], $post_data);
    }

    /**
     * unicode解码
     * @param $data
     * @return mixed
     */
    function unicodeDecode($data) {
        function replace_unicode_escape_sequence($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }
        $rs = preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $data);
        return $rs;
    }

}


