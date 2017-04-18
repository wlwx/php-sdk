<?php
/**
 * Created by PhpStorm.
 * User: zhouzhao
 * Date: 2017年4月10日 17:55:23
 */

require_once('HttpUtil.php');

class SmsOperator {
    public $cust_code;
    public $cust_pwd;
    public $sp_code;
    public $need_report;
    public $uid;
    public $wlwx_config;

    public function __construct($cust_code = null, $cust_pwd = null, $sp_code = null, $need_report = null, $uid = null) {
        $this->wlwx_config = $GLOBALS['WLWX_CONFIG'];
        if ($cust_code == null)
            $this->cust_code = $this->wlwx_config['CUST_CODE'];
        else
            $this->cust_code = $cust_code;
        if ($cust_pwd == null)
            $this->cust_pwd = $this->wlwx_config['CUST_PWD'];
        else
            $this->cust_pwd = $cust_pwd;
        if ($sp_code == null)
            $this->sp_code = $this->wlwx_config['SP_CODE'];
        else
            $this->sp_code = $sp_code;
        if ($need_report == null)
            $this->need_report = $this->wlwx_config['NEED_REPORT'];
        else
            $this->need_report = $need_report;
        if ($uid == null)
            $this->uid = $this->wlwx_config['UID'];
        else
            $this->uid = $uid;
    }

    /**
     * 发送普通短信
     * @param array $data
     * @return Result
     */
    public function send_comSms($data = array()) {
        if (!array_key_exists('destMobiles', $data))
            return new Result(null, $data, null, 'destMobiles 为空');
        if (!array_key_exists('content', $data))
            return new Result(null, $data, null, 'content 为空');
        $data['cust_code'] = $this->cust_code;
        $data['sp_code'] = $this->sp_code;
        $data['need_report'] = $this->need_report;
        $data['uid'] = $this->uid;
        $data['sign'] =   md5($data['content'].$this->cust_pwd);
        return HttpUtil::PostCURL($this->wlwx_config['URI_SEND_COMMON_SMS'], json_encode($data));
    }

    /**
     * 发送变量短信
     * @param array $data
     * @return Result
     */
    public function send_varSms($data = array()) {
        if (!array_key_exists('params', $data))
            return new Result(null, $data, null, 'params 为空');
        if (!array_key_exists('content', $data))
            return new Result(null, $data, null, 'content 为空');
        $data['cust_code'] = $this->cust_code;
        $data['sp_code'] = $this->sp_code;
        $data['sign'] =   md5($data['content'].$this->cust_pwd);
        return HttpUtil::PostCURL($this->wlwx_config['URI_SEND_VARIANT_SMS'], json_encode($data));
    }

    /**
     * 获取token
     * @return Result
     */
    private function get_token() {
        $data['cust_code'] = $this->wlwx_config['CUST_CODE'];
        return HttpUtil::PostCURL($this->wlwx_config['URI_GET_TOKEN'], json_encode($data));
    }

    /**
     * 获取查询封装的参数
     * @return Result
     */
    private function get_queryInfo() {
        $data['cust_code'] = $this->wlwx_config['CUST_CODE'];
        $tokens = $this->get_token()->responseData;
        $data['token_id'] = $tokens['token_id'];
        $data['sign'] = md5($tokens['token'].$this->cust_pwd);
        return $data;
    }

    /**
     * 获取状态报告
     * @return Result
     */
    public function get_report() {
        return HttpUtil::PostCURL($this->wlwx_config['URI_GET_REPORT'], json_encode($this->get_queryInfo()));
    }

    /**
     * 获取上行记录
     * @return Result
     */
    public function get_mo() {
        return HttpUtil::PostCURL($this->wlwx_config['URI_GET_MO'], json_encode($this->get_queryInfo()));
    }

    /**
     * 获取账户余额
     * @return Result
     */
    public function get_account() {
        return HttpUtil::PostCURL($this->wlwx_config['URI_QUERY_ACCOUNT'], json_encode($this->get_queryInfo()));
    }

    /**
     * 创建短信模板
     * @param array $data
     * @return Result
     */
    public function send_template($temp_content) {
        $data = $this->get_queryInfo();
        $sign = $data["sign"];
        array_splice($data,2,1);
        $data['passwd'] = $sign;
        $data['temp_content'] = $temp_content;
        return HttpUtil::PostCURL($this->wlwx_config['URI_SMS_TEMPLATE'], json_encode($data));
    }
}
