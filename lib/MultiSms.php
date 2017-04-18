<?php

/**
 * Created by PhpStorm.
 * User: zhouzhao
 * Date: 2017/4/11
 * Time: 14:20
 */
class MultiSms
{
    public $phone;
    public $context;
    public function __construct($phone,$context) {
        $this->phone = $phone;
        $this->context = $context;
    }
}