var webchaturl = "/";
$(window).load(function(){
	loadStyleFile(webchaturl+"css/window.css");
	var htmlfloat = '<div class="floatright"><a href="javascript:;" onclick="showwindow()"></a></div>';
	$(document.body).append(htmlfloat);
});
function showwindow(){
	var Request = GetRequest();
	var openUrl = webchaturl+"?o="+Request['o']+"&u="+Request['u']+"&r="+encodeURIComponent(window.location.href);
	var iWidth=650;
	var iHeight=550;
	var iTop = (window.screen.availHeight-iHeight)/2;
	var iLeft = (window.screen.availWidth-iWidth)/2;
	window.open(openUrl,"newwindow","height="+iHeight+", width="+iWidth+", top="+iTop+", left="+iLeft+", toolbar=no ,menubar=no,scrollbars=no, resizable=no,location=no, status=no"); 
}
function loadStyleFile(url){
    var s = document.createElement("link");
    s.href = url;
    s.type = "text/css";
    s.rel = "stylesheet";
    document.getElementsByTagName("head")[0].appendChild(s);
}

//获取url中"?"符后的字串,参数1 = Request['参数1'];
function GetRequest() {
	var webchatjsapi = document.getElementById("webchatjsapi");
	var src = webchatjsapi.getAttribute("src");
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
