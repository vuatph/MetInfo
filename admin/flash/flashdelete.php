<?php
# 文件名称:flashdelete.php 2009-08-05 11:21:57
# MetInfo企业网站管理系统 
# Copyright (C) 长沙米拓信息技术有限公司 (http://www.metinfo.cn)). All rights reserved.
require_once '../login/login_check.php';
if($action=="del"){
$allidlist=explode(',',$allid);
foreach($allidlist as $key=>$val){
$query = "delete from $met_flash where id='$val'";
$db->query($query);
}
okinfo('flash.php',$lang_loginUserAdmin);
}
else{
$query = "delete from $met_flash where id='$id'";
$db->query($query);
okinfo('flash.php',$lang_loginUserAdmin);
}
# 本程序是一个开源系统,使用时请你仔细阅读使用协议,商业用途请自觉购买商业授权.
# Copyright (C) 长沙米拓信息技术有限公司 (http://www.metinfo.cn). All rights reserved.
?>
