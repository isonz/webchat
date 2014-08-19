<{include file="header.tpl"}>

	<div class="center_div clearfix">
    	<{include file="left.tpl"}>
        <div class="center_right">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="22%" class="title">登入账号：</td>
                <td width="78%"><{$info.username}></td>
              </tr>
              <tr>
                <td class="title">真实姓名：</td>
                <td><input name="" type="text" value="<{$info.realname}>" id="realname" class="inpt" /></td>
              </tr>
              <tr>
                <td class="title">昵称：</td>
                <td><input name="" type="text" value="<{$info.nickname}>" id="nickname" class="inpt" /></td>
              </tr>
              <tr>
                <td class="title">创建时间：</td>
                <td><{$info.created_at}></td>
              </tr>
              <tr>
                <td class="title">最后一次登入时间</td>
                <td><{$info.last_login_time}></td>
              </tr>
              <tr>
                <td class="title">最后一次登入IP</td>
                <td><{$info.last_login_ip}></td>
              </tr>
            </table>

        </div>
    </div>

<script type="text/javascript" id="webchatjsapi" src="/js/api.js"></script>
<{include file="footer.tpl"}>
