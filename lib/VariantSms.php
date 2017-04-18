<?php

/**
 * Created by PhpStorm.
 * User: zhouzhao
 * Date: 2017/4/11
 * Time: 14:20
 */
class VariantSms
{
    public $mobile;
    public $vars;
    public function __construct($mobile,$vars = array()) {
        $this->mobile = $mobile;
        $this->vars = $vars;
    }
}