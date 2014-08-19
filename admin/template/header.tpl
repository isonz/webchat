<{include file="head.tpl"}>
<div class="home_div">
    <div class="homediv">
    <div class="top_div clearfix">
        <a href="/" class="logo_h"></a>
        <{if $user|default:0}>
        <div class="sign_info">欢迎 <b><{$user}></b> <a href="/sign?out">退出</a></div>
        <{/if}>
    </div>
