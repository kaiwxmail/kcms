$(function(){
//判断是否是pc
function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
                    "SymbianOS", "Windows Phone",
                    "iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    };


function showApp(){
	var winWidth = $(window).width();
    if (winWidth < 750) {		
		$("html").css({"zoom":"+winWidth/774+","transform":"scale("+winWidth/750+")","transform-origin": "top left","overflow-x":"hidden"});		
    }
	else{
		$("html").css({"zoom":"","transform":""});	
	}
}

var isPC=IsPC();

if(isPC){
	//pc端缩放手机页面
	if($.cookie('flagPC')!="true"){ 
	   showApp();
       window.onresize=function () {  	 
          showApp();
	   }
    }
}else{
	//移动端tab点击不跳转
	$(".tab_title li a").click(function(e) {
        return false;
    });
	
}



})