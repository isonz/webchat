function upOnline(){
	$.getJSON("/chat", {type:"get", s:S, u:U}, function(data){
		var guestlist = data.guestlist;
		$("#guestlist").html('');
		for(var i=0; i<guestlist.length; i++){
			$("#guestlist").append('<a href="chat?s='+guestlist[i][1]+'&u='+guestlist[i][2]+'&n='+guestlist[i][0]+'">'+guestlist[i][0]+'</a>');
		}
		
		var message = data.message;
		var Request = GetRequest();
		var user = decodeURI(Request['n']);
		for(var i=0; i<message.length; i++){
			if(''==user) user = message[i].from_user;
			addMsg(user, message[i].message, message[i].created_at);
		}
	});
}
$(function(){
	$('.emotion').qqFace({
		id : 'facebox', 
		assign:'saytext', 
		path:'images/arclist/'	//表情存放的路径
	});
	$(".sub_btn").click(function(){
		var str = $("#saytext").val();
		if($("#saytext").val()==''){
			return false;	
		}
		str = replace_em(str);
		addMsg(N, str, currentTime());
		$("#saytext").val('');
		sendMsg(str);
	});
	
	$(".notice>a").click(function(){
		 $(this).parent().hide(); 
	});
	historyMsg();
	//upOnline();
	setInterval("upOnline()", 5000);
	
	$("#saytext").ctrlSubmit(function(event){
	    var str = $("#saytext").val();
		if($("#saytext").val()==''){
			return false;	
		}
		str = replace_em(str);
		addMsg("我", str, currentTime());
		$("#saytext").val('');
		sendMsg(str);
		return false; 
	});
	
	
});

jQuery.fn.extend({
    ctrlSubmit:function(fn,thisObj){
        var obj = thisObj || this;
        var stat = false;
        return this.each(function(){
            $(this).keyup(function(event){
                //只按下ctrl情况，等待enter键的按下
                if(event.keyCode == 17){
                    stat = true;
                    //取消等待
                    setTimeout(function(){
                        stat = false;
                    },300);
                }  
                if(event.keyCode == 13 && (stat || event.ctrlKey)){
                    fn.call(obj,event);
                }  
            });
        });
    }  
});


function addMsg(user, str, time){
	$("#show").append('<div class="saytitle"><div class="say_help">'+user+'<em>'+time+'</em></div><p>'+str+'</p></div>');
	var e=document.getElementById("show")
	e.scrollTop=e.scrollHeight;
}

function historyMsg(){
	var Request = GetRequest();
	$(".notice_name em").html(decodeURI(Request['n']));
	
	$.getJSON("/chat",{type:"history", s:S, u:U},function(data){
		var history = data.history;
		var datas = history.data;
		var page = history.page;
		var Request = GetRequest();
		var user ='';
		var times = '';
		for(var i=0; i<datas.length; i++){
			user = datas[i].from_user;
			if(''==user) user = decodeURI(Request['n']);
			if('admin'==datas[i].message_from_url){
				user = datas[i].nickname;
				datas[i].message_from_url = "客服平台";
			}
			times = datas[i].created_at + " [来自" + datas[i].message_from_url + "]";
			addMsg(user, datas[i].message, times);
		}
	});
}

function sendMsg(str){
	if(''==str) return false;
	$.ajax({
        type: 'POST',
        data: {type:"send", s:S, msg:str, u:U},
        url: '/chat',
        error: function (XMLHttpRequest, textStatus, errorThrown) {console.log("网络异常，请稍后再试...");},
        success: function (data) {
        	//console.log("请求成功");
        }
   });
}

//查看结果
function replace_em(str){
	str = str.replace(/\</g,'&lt;');
	str = str.replace(/\>/g,'&gt;');
	str = str.replace(/\n/g,'<br/>');
	str = str.replace(/\[em_([0-9]*)\]/g,'<img src="images/arclist/$1.gif" border="0" />');
	return str;
}
function currentTime(){
	var d = new Date(),str = '';
	 str += d.getHours()+':';
	 str += d.getMinutes()+':';
	 str += d.getSeconds();
	return str;
}
function GetRequest() {
	var src = location.href;
	var url = src.substring(src.indexOf('?'));
	var theRequest = new Object();
	if (url.indexOf("?") != -1) {
		var str = url.substr(1);
	    strs = str.split("&");
	    for(var i = 0; i < strs.length; i ++) {
	    	theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
	    }
	}
	return theRequest;
}

