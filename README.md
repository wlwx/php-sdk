# php-sdk
The http://www.10690757.com php sdk.

在使用SDK之前，您需要有一对有效的cust_code和cust_pwd。如果不记得，可咨询我们的客服人员。


一、SDK结构

    1. lib目录主要包含了一些对 http封装的类
    2. autoload.php用于引入SDK，供开发者使用
    3. config.php是配置文件，使用前需要填入相关信息。

    //用户账号，必填
    $wlwx_config['CUST_CODE'] = "XXXXXX";
    //用户密码，必填
    $wlwx_config['CUST_PWD'] = "XXXXXXXXXXXX";
    //长号码，选填
    $wlwx_config['SP_CODE'] = "";
    //是否需要状态报告
    $wlwx_config['NEED_REPORT'] = "yes";
    //业务标识，选填，由客户自行填写不超过20位的数字
    $wlwx_config['UID'] = "";
    //短信网关地址，具体地址咨询客服
    $wlwx_config['SMS_HOST'] = 'http://127.0.0.1';


二、场景化示例

&lt;?php<br/>
require_once 'autoload.php';<br/>

$smsOperator = new SmsOperator();<br/>
//开发者亦可在构造函数中填入配置项<br/>
//$smsOperator = new SmsOperator($cust_code, $cust_pwd, $sp_code, $need_report, $uid);<br/>

// 发送普通短信<br/>
echo "发送普通短信\n";<br/>
$data1['destMobiles'] = '15960XXX654';<br/>
$data1['content'] = '【未来无线】您的验证码为：170314。如非本人操作，请忽略。';<br/>
$result = $smsOperator-&gt;send_comSms($data1);<br/>
print_r($result);<br/>

//发送变量短信<br/>
echo "发送变量短信\n";<br/>
$params = array();<br/>
//VariantSms类用于封装发送号码以及参数变量<br/>
array_push($params,new VariantSms("15960XXX654",array("长乐","25")));<br/>
array_push($params,new VariantSms("18650XXX293",array("上杭","23")));<br/>
$data2['content'] = "${mobile}用户您好，今天${var1}的天气，晴，温度${var2}度，事宜外出。";<br/>
$data2['params'] = $params;<br/>
$result = $smsOperator-&gt;send_varSms($data2);<br/>
print_r($result);<br/>

//获取状态报告<br/>
echo "获取状态报告\n";<br/>
$result = $smsOperator-&gt;get_report();<br/>
print_r($result);<br/>

//获取用户上行<br/>
echo "获取用户上行\n";<br/>
$result = $smsOperator-&gt;get_mo();<br/>
print_r($result);<br/>

//获取账户余额<br/>
echo "获取账户余额\n";<br/>
$result = $smsOperator-&gt;get_account();<br/>
print_r($result);<br/>

//创建短信模板<br/>
echo "创建短信模板\n";<br/>
$template = "([\S\s]*)用户您好，请记住您的验证码([\S\s]*)。";<br/>
$result = $smsOperator-&gt;send_template($template);<br/>
print_r($result);<br/>

//批量发送短信<br/>
$multiSmsOperator = new MultiSmsOperator();<br/>
//开发者亦可在构造函数中填入配置项，注本处的uid为用户账号<br/>
//$multiSmsOperator = new MultiSmsOperator($uid, $cust_pwd, $srcphone);<br/>
echo "批量发送短信\n";<br/>
$msg = array();<br/>
//MultiSms类用于封装发送号码以及内容<br/>
array_push($msg,new MultiSms("15960XXX654","【未来无线】您的验证码为：170314。如非本人操作，请忽略。"));<br/>
array_push($msg,new MultiSms("18650XXX293","【未来无线】您的验证码为：170315。如非本人操作，请忽略。"));<br/>
$data3['msg'] = $msg;<br/>
$result = $multiSmsOperator-&gt;send_multiSms($data3);<br/>
print_r($result);<br/>
								

