<?php
require_once 'autoload.php';

$smsOperator = new SmsOperator();
//开发者亦可在构造函数中填入配置项
//$smsOperator = new SmsOperator($cust_code, $cust_pwd, $sp_code, $need_report, $uid);

// 发送普通短信
echo "发送普通短信\n";
$data1['destMobiles'] = '15960XXX654';
$data1['content'] = '【未来无线】您的验证码为：170314。如非本人操作，请忽略。';
$result = $smsOperator->send_comSms($data1);
print_r($result);

//发送变量短信
echo "发送变量短信\n";
$params = array();
//VariantSms类用于封装发送号码以及参数变量
array_push($params,new VariantSms("15960XXX654",array("长乐","25")));
array_push($params,new VariantSms("18650XXX293",array("上杭","23")));
$data2['content'] = "\${mobile}用户您好，今天\${var1}的天气，晴，温度\${var2}度，事宜外出。";
$data2['params'] = $params;
$result = $smsOperator->send_varSms($data2);
print_r($result);

//获取状态报告
echo "获取状态报告\n";
$result = $smsOperator->get_report();
print_r($result);

//获取用户上行
echo "获取用户上行\n";
$result = $smsOperator->get_mo();
print_r($result);

//获取账户余额
echo "获取账户余额\n";
$result = $smsOperator->get_account();
print_r($result);

//创建短信模板
echo "创建短信模板\n";
$template = "([\S\s]*)用户您好，请记住您的验证码([\S\s]*)。";
$result = $smsOperator->send_template($template);
print_r($result);

//批量发送短信
$multiSmsOperator = new MultiSmsOperator();
//开发者亦可在构造函数中填入配置项，注本处的uid为用户账号
//$multiSmsOperator = new MultiSmsOperator($uid, $cust_pwd, $srcphone);
echo "批量发送短信\n";
$msg = array();
//MultiSms类用于封装发送号码以及内容
array_push($msg,new MultiSms("15960XXX654","【未来无线】您的验证码为：170314。如非本人操作，请忽略。"));
array_push($msg,new MultiSms("18650XXX293","【未来无线】您的验证码为：170315。如非本人操作，请忽略。"));
$data3['msg'] = $msg;
$result = $multiSmsOperator->send_multiSms($data3);
print_r($result);