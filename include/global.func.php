<?php
# 文件名称:global.func.php 2009-08-18 08:53:03
# MetInfo企业网站管理系统 
# Copyright (C) 长沙米拓信息技术有限公司 (http://www.metinfo.cn).  All rights reserved.
/* 系统函数库*/
function daddslashes($string, $force = 0,$metinfo) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
	}
	if(inject_check($string)&&$metinfo!='metinfo'){
	$reurl="http://".$_SERVER["HTTP_HOST"];	
	echo("<script type='text/javascript'> alert('Please Stop SQL Injecting！'); location.href='$reurl'; </script>");
	die("Please Stop SQL Injecting！");
	}
	if($id!=""){
	if(!is_numeric($id)){
	$reurl="http://".$_SERVER["HTTP_HOST"];
	echo("<script type='text/javascript'> alert('Parameter Error！'); location.href='$reurl'; </script>");
	die("Parameter Error！");
	}}
	if($class1!=""){
	if(!is_numeric($class1)){
	$reurl="http://".$_SERVER["HTTP_HOST"];
	echo("<script type='text/javascript'> alert('Parameter Error！'); location.href='$reurl'; </script>");
	die("Parameter Error！");
	}}
	if($class2!=""){
	if(!is_numeric($class2)){
	$reurl="http://".$_SERVER["HTTP_HOST"];
	echo("<script type='text/javascript'> alert('Parameter Error！'); location.href='$reurl'; </script>");
	die("Parameter Error！");
	}}
	if($class3!=""){
	if(!is_numeric($class3)){
	$reurl="http://".$_SERVER["HTTP_HOST"];
	echo("<script type='text/javascript'> alert('Parameter Error！'); location.href='$reurl'; </script>");
	die("Parameter Error！");
	}}   
    $string = str_replace("%", "\%", $string);     // 把 '%'过滤掉     
	return $string;
}

function template($template,$EXT="html"){
	global $met_skin_user,$skin;
	if(empty($skin)){
	    $skin = $met_skin_user;
	}
	unset($GLOBALS[con_db_id],$GLOBALS[con_db_pass],$GLOBALS[con_db_name]);
	$path = ROOTPATH."templates/$skin/$template.$EXT";
	
	!file_exists($path) && $path=ROOTPATH."templates/met/$template.$EXT";
	return  $path;
}

/**底部处理**/
function footer(){	
	global $output,$db;
	$output = str_replace(array('<!--<!---->','<!---->','<!--fck-->','<!--fck','fck-->','',"\r",substr($admin_url,0,-1)),'',ob_get_contents());
	$db->close();	
	ob_end_clean();	
	fecho();
	if(!strstr($output,"MetInfo"))die("在未经授权前，请不要尝试去掉'Powered by MetInfo'版权标识！");
	exit;
}
/**操作成功提示**/
function okinfo($url = '../site/sysadmin.php',$langinfo){
echo("<script type='text/javascript'> alert('$langinfo'); location.href='$url'; </script>");
exit;
}


function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

        $ckey_length = 4;  
        $key = md5($key ? $key : UC_KEY);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }

    }
	
function codetra($content,$codetype) {
if($codetype==1){
 $content = str_replace('+','metinfo',$content);
 }else{
  $content = str_replace('metinfo','+',$content);
 }
return $content;
}
// 热门标签及分页函数
function contentshow($content) {
global $lang_PagePre,$lang_PageNext;
$content=str_replace('<sub>metinfopageEnd</sub>','',$content);
$contentarray=explode('<sub>metinfopageStart</sub>',$content);
$allnum=count($contentarray)-1;
if($allnum>1){
for($i=0;$i<$allnum;$i++){
  $k=$i+1;
  if($i){
   $metinfo.="<span id='metlist".$k."' style='display:none' >".$contentarray[$k]."</span>";
   $metpage.="<span id='metlistpage".$k."' class='metpagecontent2'><a href='#' onclick='contentpage(".$k.")' >".$k."</a></span>";
  }else{
  $metinfo.="<span id='metlist".$k."' >".$contentarray[$k]."</span>";
  $metpage.="<span id='metlistpage".$k."' class='metpagecontent1'><a href='#' onclick='contentpage(".$k.")' >".$k."</a></span>";
  }
}
   $metinfo.="<style type='text/css'>\n";
   $metinfo.=".metpagecontent1{ font-weight:bold; background-color:#FFFFFF; margin:0px 3px 0px 3px; padding:2px 5px 2px 5px; border:1px solid #0066CC;}\n";
   $metinfo.=".metpagecontent2{background-color:#F1F1F1; margin:0px 3px 0px 3px; padding:2px 5px 2px 5px; border:1px solid #999999;}\n";
   $metinfo.="</style>\n";
   $metinfo.="<span style='display:block; width:100%; height:30px; line-height:30px; text-align:center;'>";
   $metinfo.="<span id='metlistpagepre' style='display:none;' class='metpagecontent2'><a href='#' id='metlistpagepre1' onclick='contentpage(1)'>".$lang_PagePre."</a></span>";
   $metinfo.=$metpage;
   $metinfo.="<span id='metlistpagenext' class='metpagecontent2'><a href='#' id='metlistpagenext1' onclick='contentpage(2)'>".$lang_PageNext."</a></span>";
   $metinfo.="</span>";

  $metinfo.="<script  LANGUAGE='JavaScript'>\n";
  $metinfo.="function contentpage(nowpage) {\n";
  $metinfo.="var i;\n";
  $metinfo.="var k;\n";
  $metinfo.="var j;\n";
  $metinfo.="for(i=1;i<=".$allnum.";i++){\n";
  $metinfo.=" if(i==nowpage){\n";
  $metinfo.="  document.getElementById('metlist'+i).style.display='';\n";
  $metinfo.="  document.getElementById('metlistpage'+i).className='metpagecontent1';\n";
  $metinfo.="   if(i==".$allnum."){\n";
  $metinfo.="     document.getElementById('metlistpagenext').style.display='none';\n";
  $metinfo.="    }else{\n";
  $metinfo.="     k=i+1;\n";
  $metinfo.="	 document.getElementById('metlistpagenext').style.display='';\n";
  $metinfo.="	 document.getElementById('metlistpagenext1').onclick=function (){contentpage(k);};\n";
  $metinfo.="    }\n";
  $metinfo.="   if(i==1){\n";
  $metinfo.="    document.getElementById('metlistpagepre').style.display='none';\n";
  $metinfo.="	}else{\n";
  $metinfo.="    j=i-1;\n";
  $metinfo.="	document.getElementById('metlistpagepre').style.display='';\n";
  $metinfo.="   document.getElementById('metlistpagepre1').onclick=function (){contentpage(j);};\n";
  $metinfo.="   }\n";
  $metinfo.="  }else{\n";
  $metinfo.="  document.getElementById('metlist'+i).style.display='none';\n";
  $metinfo.="  document.getElementById('metlistpage'+i).className='metpagecontent2';\n";
  $metinfo.="  }\n";
  $metinfo.="  }\n";
  $metinfo.="}\n";
  $metinfo.="</script>\n";
  $content=$metinfo;
}
require_once ROOTPATH.'config/str.inc.php';
foreach($str as $key=>$val){
$content = str_replace($val[0],$val[1],$content);
}
return $content;
}

// 删除文件的函数
function file_unlink($file_name) {

	if(file_exists($file_name)) {
		@chmod($file_name,0777);
		$area_lord = @unlink($file_name);
	}
	return $area_lord;
}


//读取数据排序
function list_order($listid){
switch($listid){
case '0';
$list_order=" order by updatetime desc";
return $list_order;
break;

case '1';
$list_order=" order by updatetime desc";
return $list_order;
break;

case '2';
$list_order=" order by addtime desc";
return $list_order;
break;

case '3';
$list_order=" order by hits desc";
return $list_order;
break;

case '4';
$list_order=" order by id desc";
return $list_order;
break;

case '5';
$list_order=" order by id";
return $list_order;
break;
}
}

function utf8Substr($str, $from, $len) 
{
if(mb_strlen($str,'utf-8')>intval($len)){
return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
'$1',$str).".."; 
}else{
return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s', 
'$1',$str); 
}
}

function inject_check($sql_str) {
  if(strtoupper($sql_str)=="UPDATETIME" ){
  return eregi('select|insert|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
  }else{	
  return eregi('select|insert|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);    // 进行过滤
  }     
}  

function get_keyword_str($str,$keyword,$getstrlen)
{
	if(cnStrLen($str)> $getstrlen) 
	{
		$strlen = cnStrLen($keyword);
		$strpos = cnStrPos($str,$keyword);
		$halfStr = intval(($getstrlen-$strlen)/2);
		if($strpos!=""){
		 if($strpos>=$halfStr){
		    $str = cnSubStr($str,($strpos - $halfStr),$halfStr).$keyword.cnSubStr($str,($strpos + $strlen),$halfStr);
		 }else{
		   $str = cnSubStr($str,($strpos - $halfStr),$strpos).$keyword.cnSubStr($str,($strpos + $strlen),($halfStr*2));
		 }	
		}else{
		$str = cnSubStr($str,0,$getstrlen);
		}
		$str=str_replace('<p>','&nbsp;',$str);
		$str=str_replace('</p>','&nbsp;',$str);
		$str=str_replace('<br />','&nbsp;',$str);
		$str=str_replace('<br>','&nbsp;',$str);
		return str_replace($keyword,'<span style="font-size: 12px; color: #F30;">'.$keyword.'</span>',$str).'...';
	}
	else
	{
		return str_replace($keyword,'<span style="font-size: 12px; color: #F30;">'.$keyword.'</span>',$str);
	}
}

/*
	获取中英文混合字符串的长度
*/
$class2_all_1=$db->get_one("SELECT * FROM $met_otherinfo ");
$class2_all_1=explode('|',$class2_all_1[data]);

function cnStrLen($str)
{
	$i = 0;
	$tmp = 0;
	while ($i < strlen($str))
	{
		if (ord(substr($str,$i,1)) >127)
		{
			$tmp = $tmp+1;
			$i = $i + 3;
		}
		else
		{
			$tmp = $tmp + 1;;
			$i = $i + 1;
		}
	}
	return $tmp;
}
/*
	获取中英文混合字符在字符串中的位置
*/
function cnStrPos($str,$keyword)
{
	$i = 0;
	$tem = 0;
	$temStr = strpos($str,$keyword);
	while ($i < $temStr)
	{
		if (ord(substr($str,$i,1)) >127)
		{
			$tmp = $tmp+1;
			$i = $i + 3;
		}
		else
		{
			$tmp = $tmp + 1;;
			$i = $i + 1;
		}
	}
	return $tmp;
}


function cnSubStr($str, $start, $lenth)
{
	$len = strlen($str);
	$r = array();
	$n = 0;
	$m = 0;
	for($i = 0; $i < $len; $i++) {
		$x = substr($str, $i, 1);
		$a = base_convert(ord($x), 10, 2);
		$a = substr('00000000'.$a, -8);
		if ($n < $start){
			if (substr($a, 0, 1) == 0) {
			}elseif (substr($a, 0, 3) == 110) {
				$i += 1;
			}elseif (substr($a, 0, 4) == 1110) {
				$i += 2;
			}
			$n++;
		}else{
			if (substr($a, 0, 1) == 0) {
				$r[] = substr($str, $i, 1);
			}elseif (substr($a, 0, 3) == 110) {
				$r[] = substr($str, $i, 2);
				$i += 1;
			}elseif (substr($a, 0, 4) == 1110) {
				$r[] = substr($str, $i, 3);
				$i += 2;
			}else{
				$r[] = '';
			}
			if (++$m >= $lenth){
				break;
			}
		}
	}
	return join('', $r);

} // End subString_UTF8

//去除HTML字符标记

function templatemember($template,$EXT="html"){
	if(empty($skin)){
	    $skin ="met";
	}
	unset($GLOBALS[con_db_id],$GLOBALS[con_db_pass],$GLOBALS[con_db_name]);
	$path = ROOTPATH."member/templates/$skin/$template.$EXT";
	!file_exists($path) && $path=ROOTPATH."member/templates/met/$template.$EXT";
	return  $path;
}
/**底部处理**/
function footermember(){
	$output = str_replace(array('<!--<!---->','<!---->','<!--fck-->','<!--fck','fck-->','',"\r",substr($admin_url,0,-1)),'',ob_get_contents());
    ob_end_clean();
    echo $output; unset($output);
	mysql_close();
	exit;
}

/*
已采用函数
*/
# 本程序是一个开源系统,使用时请你仔细阅读使用协议,商业用途请自觉购买商业授权.
# Copyright (C) 长沙米拓信息技术有限公司 (http://www.metinfo.cn).  All rights reserved.
?>
