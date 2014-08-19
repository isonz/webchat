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
		addMsg("我", str, currentTime());
		$("#saytext").val('');
		sendMsg(str);
	});
	historyMsg();
	setInterval("getMsg()", 5000);
	
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

function getMsg(){
	$.getJSON("/chat",{type:"get", o:O, s:S, u:U},function(data){
		var message = data.message;
		var to_user = data.to_user;
		for(var i=0; i<message.length; i++){
			if('undefined'==typeof(message[i].nickname) || ''==message[i].nickname){
				user = message[i].from_user;
			}else{
				user = message[i].nickname;
			}
			addMsg(user, message[i].message, message[i].created_at);
		}
		if(''==to_user.username){
			$(".notice").show();
			$(".notice_name").hide();
		}else{
			$(".notice_name").show();
			$(".notice").hide();
			$(".notice_name em").html(to_user.nickname);
			toUser = to_user.username;
		}
	});
}

function historyMsg(){
	$.getJSON("/chat",{type:"history", o:O, s:S, u:U},function(history){
		var data = history.data;
		var page = history.page;
		for(var i=0; i<data.length; i++){
			var user = "我";
			if(data[i].from_user != U && data[i].from_session != S){
				if('undefined'==typeof(data[i].nickname) || ''==data[i].nickname){
					user = data[i].from_user;
				}else{
					user = data[i].nickname;
				}
			}
			addMsg(user, data[i].message, data[i].created_at);
		}
	});
}

function sendMsg(str){
	if(''==str) return false;
console.log(toUser);
	$.ajax({
        type: 'POST',
        data: {type:"send", o:O, s:S, msg:str, u:U, r:R, tu:toUser},
        url: '/chat',
        error: function (XMLHttpRequest, textStatus, errorThrown) {console.log("网络异常，请稍后再试...");},
        success: function (data) {
        	//console.log("请求成功");
        }
   });
}

