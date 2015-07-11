<?php
define('PHPCMS_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR);

include PHPCMS_PATH.'/phpcms/base.php';
include PHPCMS_PATH.'/phpcms/libs/classes/http.class.php';
$curl = new http();
$to_push = array(
    'source'  => 'yop_wap', //若是安装宝 换成'source'  => 'yop_wap'
    'action'  => 'url',
    'yop_uid' => "1243",   //若是安装宝 换成 'yop_uid' => $yop_uid
    'title'   => '列子',
    'arg1'=>'http://app.ymt360.com/hangqing?no_head=1'
);
$curl->post_json('http://soa.my/message/notice/',$to_push);

var_dump($curl->data);
