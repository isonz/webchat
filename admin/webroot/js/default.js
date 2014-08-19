$(document).ready(function(){
	$("input[class*=import]")
	.each(function(){   
	   var oldVal=$(this).val(); 
	   $(this)   
	   .css({"color":"#999"})
	   .focus(function(){   
		if($(this).val()!=oldVal){$(this).css({"color":"#333"})}else{$(this).val("").css({"color":"#999"})}   
	   })   
	   .blur(function(){   
		if($(this).val()==""){$(this).val(oldVal).css({"color":"#999"})}   
	   })   
	   .keydown(function(){$(this).css({"color":"#333"})}) 
	});
	var oldword=false;
	var newword=false;
	var restword=false;
	$("#oldpassword").blur(function(){
		var oldval = $("#oldpassword").val();
		if(oldval != ""){
			oldword=true;
		}else{
			$("#error_p").html("请填写原始密码！");
			oldword=false;
		}
	});
	$("#newpassword").blur(function(){
		var newval = $("#newpassword").val();
		if(newval.length < 6 || newval.length>20){
			$("#error_p").html("密码在6到20位之间！");
			newword = false;
		}else{
			newword = true;
		}						
	});
	$("#reastpassword").blur(function(){
		var testval = $("#reastpassword").val();
		if(testval != $("#newpassword").val()){
			$("#error_p").html("两次输入的密码不同！");
			restword = false;
		}else{
			restword = true;
		}					
	});
	$("#subpsw").click(function(check){
		if(!oldword || !newword || !restword){
			$("#error_p").html("请填写正确的信息！");
			return false;
		}
	});
	$(".psw").focus(function(){
		$("#error_p").html("");					
	});
	
	$(".inpt").click(function(){
		$(this).select();
		$(this).css("boder","1px solid #ccc");
		$(this).css("text-indent","5px");
	})
	$(".inpt").blur(function(){
		$(this).css("boder","1px solid #fff");
		$(this).css("text-indent","0");
		$.post('',{type:'update', key:$(this).attr("id"), value:$(this).val()});
	})
	
}); 
