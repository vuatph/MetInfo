<?php
require_once '../login/login_check.php';
$css_url="../templates/".$met_skin."/css";
$img_url="../templates/".$met_skin."/images";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" type="text/css" href="<?echo $css_url;?>/metinfo_admin.css">
<title>上传图片</title>
<script type="text/javascript" src="../language/zh_cn.js"></script>
<script type="text/javascript" src="../include/metinfo.js"></script>
</head>
<body>

<form enctype="multipart/form-data" method="POST" name="myform" onSubmit="return CheckFormupload();" action="upload_save.php?action=add" target="_self">
<input name="imgurl" type="file" class="input" size="20" maxlength="200"> <input type="submit" name="Submit" value="上传" class="tj">
<input name="returnid" type="hidden" value="<? echo $returnid; ?>" />
<input name="create_samll" type="hidden" value="<? echo $create_samll; ?>" />
<input name="flash" type="hidden" value="<? echo $flash; ?>" />
</form>
</body>
</html>