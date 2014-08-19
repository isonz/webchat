<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" > 
<head> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <title>PTP Webchat Admin</title> 
  <link rel="stylesheet" href="css/default.css" type="text/css"/>
  <script type="text/javascript" src="js/jquery.js"></script>
  <script type="text/javascript">var S='<{$sessionid}>';</script>
</head> 
<body>

<script>
 function refreshYZM(){
   var el =document.getElementById("Image1");
            el.src=el.src+'?';
  }
</script>
<style>
body{ background:#e9e9e9;font-family: Arial, Helvetica, sans-serif;font-size:12px; height:100%; padding-top:0px;}
</style>
<{if $user|default:0}>
	<{$user}>
    <a href="/sign?out">Sign Out</a>
<{else}>
	<div class="logoTop">
        	<!-- <a class="logo"></a> -->
        </div>
	<div class="sign_indiv"></div>
	<div class="sign_in">
        
        <form name="form1" method="post" action="/sign?in">
        <table>
          <tr>
            <td>
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                        <input name="user" type="text" class="signIn import" value="账号" />
                    </td>
                  </tr>
                  <tr>
                    <td><input name="passwd" type="password" class="signIn import" style="margin-bottom:19px;#margin-bottom:15px;" value="******" /></td>
                  </tr>
                  <tr>
                    <td><input name="yzm" type="text" class="yzm import" value="验证码" />                      <img src="/vcode" id="Image1" style="cursor: pointer;" onmouseup="refreshYZM()"  /></td>
                  </tr>
                  <tr>
                    <td height="32" align="center"><div id="errmsg"><{$errmsg}></div></td>
                  </tr>
                  <tr>
                    <td align="center"><input type="submit" name="submit" class="submitlogin" value="" />
                        <input type="hidden" name="organize" value="ptpcn" /></td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
	</form>
    <div class="footrer"><!-- &copy; --></div>
    </div>
<{/if}>

<script type="text/javascript" src="js/default.js"></script> 
</body> 
</html> 
