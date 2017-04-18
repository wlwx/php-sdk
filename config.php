<?php
/*
 * config file
 */

$wlwx_config = array();
$wlwx_config['CUST_CODE'] = "XXXXXX";
$wlwx_config['CUST_PWD'] = "XXXXXXXXXXXX";
$wlwx_config['SP_CODE'] = "";
$wlwx_config['NEED_REPORT'] = "yes";
$wlwx_config['UID'] = "";
$wlwx_config['SMS_HOST'] = 'http://127.0.0.1';

// retry times
$wlwx_config['RETRY_TIMES'] = 3;
// 短信
$wlwx_config['URI_SEND_COMMON_SMS'] = $wlwx_config['SMS_HOST'] . ":8860/sendSms";
$wlwx_config['URI_SEND_VARIANT_SMS'] = $wlwx_config['SMS_HOST'] . ":8860/sendVariantSms";
$wlwx_config['URI_GET_TOKEN'] = $wlwx_config['SMS_HOST'] . ":8860/getToken";
$wlwx_config['URI_GET_REPORT'] = $wlwx_config['SMS_HOST'] . ":8860/getReport";
$wlwx_config['URI_GET_MO'] = $wlwx_config['SMS_HOST'] . ":8860/getMO";
$wlwx_config['URI_QUERY_ACCOUNT'] = $wlwx_config['SMS_HOST'] . ":8860/QueryAccount";
$wlwx_config['URI_SMS_TEMPLATE'] = $wlwx_config['SMS_HOST'] . ":8860/requestSmsTemplate";

$wlwx_config['URI_SEND_MULTI_SMS'] = $wlwx_config['SMS_HOST'] . ":8861";

$GLOBALS['WLWX_CONFIG'] = $wlwx_config;

?>