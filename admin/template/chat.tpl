<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" > 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <meta name="renderer" content="webkit"> 
  <title>PTP Webchat Admin</title> 
  <link rel="stylesheet" href="css/chat.css" type="text/css"/>
</head> 
<body>

<div class="logo"><img src="/images/logo.png" width="199" height="37"></div>
<div class="nameid">用户名：<{$user}> &nbsp;&nbsp;|&nbsp;&nbsp; 昵称：<{$nickname}>  <!-- 机构代码：<{$organize}> --> </div>

<div class="leftdiv">
    <div class="lefttopdiv">
        <div class="showInfo">
            <div class="notice_name">当前接入的客户： <em></em></div>
            <div id="show"></div>
        </div>
        <div class="emotiondiv"><span class="emotion">表情</span></div>
        <div class="comment">
            <div class="com_form">
                <textarea class="input" id="saytext" name="saytext"<{if $from_session eq ''}> disabled="disabled"<{/if}>></textarea>
                <p style="display:block; text-align:right;"><input type="button" class="sub_btn" value="提交"></p>
            </div>
        </div>
    </div>
</div>
<div class="rightdiv">
	<h3>客户列表</h3>
	<div id="guestlist"></div>
</div>

<script type="text/javascript">var S='<{$from_session}>'; var U='<{$guest}>'; var N='<{$nickname}>';</script>
<script  src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.qqFace.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
</body> 
</html> 

