<?php# MetInfo Enterprise Content Management System # Copyright (C) MetInfo Co.,Ltd (http://www.metinfo.cn). All rights reserved. defined('IN_MET') or exit('No permission');ini_set('date.timezone','Asia/Shanghai');load::mod_class('pay/web/pay');class unionpay extends pay {    public function __construct() {            global $_M;    }    /**     * 银联支付     * @param	Number      merId       //商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数     * @param	String(32)  orderId     //商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则     * @param	String      txnTime     //订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数     * @param	Number      txnAmt      //交易金额，单位分，此处默认取demo演示页面传递的参数     */    public static function unionpay($date) {        include_once 'unionpay/acp_service.php';                $params = array(                //固定参数——以下信息非特殊情况不需要改动                'version'      => '5.0.0',              //版本号                'encoding'     => 'utf-8',		//编码方式                'txnType'      => '01',			//交易类型                'txnSubType'   => '01',			//交易子类                'bizType'      => '000201',		//业务类型                'frontUrl'     => SDK_FRONT_NOTIFY_URL, //前台通知地址                'backUrl'      => SDK_BACK_NOTIFY_URL,  //后台通知地址                'signMethod'   => '01',                 //签名方法                'channelType'  => '08',	                //渠道类型，07-PC，08-手机                'accessType'   => '0',		        //接入类型                'currencyCode' => '156',	        //交易币种，境内商户固定156                //变量参数                'merId'     => MERID_CONFIG,		//商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数                'txnTime'   => date("YmdHis"),          //订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数                'orderId'   => $date["out_trade_no"],   //商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则                'txnAmt'    => $date["total_fee"]*100,  //交易金额，单位分，此处默认取demo演示页面传递的参数        );                AcpService::sign ( $params );        $uri = SDK_FRONT_TRANS_URL;        $html_form = AcpService::createAutoFormHtml( $params, $uri );                echo $html_form;    }    /**     * 银联回调验证     */    public function donotify($date) {        global $_M;        include_once 'unionpay/acp_service.php';        //交易状态判断(判断respCode=00或A6即可认为交易成功)+商户内部订单号比对+验证签名        if (isset ( $_POST ['signature'] ) && $_POST ['respCode']==='00' || $_POST ['respCode']==='A6' && $_POST ['orderId']===$date['out_trade_no'] && AcpService::validate ( $_POST )) {                                             return TRUE;        } else {            return FALSE;        }    }}# This program is an open source system, commercial use, please consciously to purchase commercial license.# Copyright (C) MetInfo Co., Ltd. (http://www.metinfo.cn). All rights reserved.?>