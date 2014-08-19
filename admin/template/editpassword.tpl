<{include file="header.tpl"}>

	<div class="center_div clearfix">
    	<{include file="left.tpl"}>
        <div class="center_right">
        <form action="" id="formd"  method="post">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="17%">原始密码：</td>
                <td width="83%"><input name="oldpassword" type="password" id="oldpassword" class="psw" /></td>
              </tr>
              <tr>
                <td>新密码：</td>
                <td><input name="newpassword" type="password" id="newpassword" class="psw" /></td>
              </tr>
              <tr>
                <td>确认密码：</td>
                <td><input name="reastpassword" type="password" id="reastpassword" class="psw" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                <{if $error neq 0}>
                <div id="error_p" style="color:#f00;"><{$msg}></div>
                <{else}>
                <div id="s_p" style="color:#090; font-weight:bold;"><{$msg}></div>
                <{/if}>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>
                <input name="" type="submit" class="sub" id="subpsw" />
                <input type="hidden" name="type" value="reset">
                </td>
              </tr>
            </table>
         </form>
        </div>
    </div>


<{include file="footer.tpl"}>
