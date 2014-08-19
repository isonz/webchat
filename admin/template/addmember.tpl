<{include file="header.tpl"}>

	<div class="center_div clearfix">
    	<{include file="left.tpl"}>
        <div class="center_right">
         <form action="" id="formd"  method="post">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="17%">账号：</td>
                <td width="83%"><input type="text" name="username" class="psw" /></td>
              </tr>
              <tr>
                <td>密码：</td>
                <td><input type="password" name="password" class="psw" /></td>
              </tr>
              <tr>
                <td>真实姓名：</td>
                <td><input type="text" name="realname" class="psw" /></td>
              </tr>
              <tr>
                <td>昵称：</td>
                <td><input type="text" name="nickname" class="psw" /></td>
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
                <input type="submit" name="button" class="sub" value="添加" />
                <input type="hidden" name="type" value="add">
                </td>
              </tr>
            </table>
		</form>
        </div>
    </div>

<script type="text/javascript" id="webchatjsapi" src="/js/api.js"></script>
<{include file="footer.tpl"}>
