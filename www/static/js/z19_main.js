//移动端导航
function setSwiperNav(index){
var initialSlide = index;
var numSlide;
if($(window).width()<768){
	numSlide=3;
}else{
	numSlide=6;
}
var mySwiperNav = new Swiper('#swiper_container_pad_nav', {
		freeMode: true,
		freeModeFluid: true,
		calculateHeight: true,
		slidesPerView: 'auto',
		cssWidthAndHeight: true,
		initialSlide: initialSlide,
		onFirstInit: function (swiper) {
			if (initialSlide >= $(".pad_nav li").size() - numSlide) {
				$('#pad_nav_mask_right').hide();
			} 
			holdPosition = 0,holdPosition2=0, mySwiperNavTimer = null;

		},
		onTouchStart: function (swiper) {
			holdPosition = 0, holdPosition2=0,clearTimeout(mySwiperNavTimer);			
		},
		onTouchEnd: function (swiper) {			
			if (holdPosition != 0) {
				$('#pad_nav_mask_right').hide();
				
			}else{
			   $('#pad_nav_mask_right').stop().fadeIn();		
			};
		
		},				
		onResistanceAfter: function (swiper, pos) {
			holdPosition = pos
		},
		onResistanceBefore: function (swiper, pos2) {
			holdPosition2 = pos2
		}
	})
}

//tab切换
$(".tab_title li").hover(function(e) {
    $(this).addClass("now").siblings().removeClass("now");
	var tabCon=$(this).parent().next(".tabBox");
	tabCon.children(".tab_con").eq($(this).index()).show().siblings().hide();
});
$(".kycc_tab li").click(function(e) {
    $(this).addClass("now").siblings().removeClass("now");
	var tabCon=$(this).parent().next(".tabBox");
	tabCon.children(".tab_con").eq($(this).index()).show().siblings().hide();
});

//首页焦点图
var mySwiperFocus;
if($("#swiper_container_top_Focus").length>0){
mySwiperFocus = new Swiper('#swiper_container_top_Focus',{
				loop:true,
				calculateHeight : true,
				speed:1000,
				autoplay: 5000,
				disableOnInteraction : true,
				pagination : '.pagination',
				paginationClickable :true,
				autoplayDisableOnInteraction:false			
			})
			$('.swiper-button-prev').on('click', function(e){
                e.preventDefault()
                mySwiperFocus.swipePrev()
            })
            $('.swiper-button-next').on('click', function(e){
                e.preventDefault()
                mySwiperFocus.swipeNext()
            })
$(window).resize(function(){
    mySwiperFocus.reInit();
});
}


function resizeHeight(){
    $(".videoBox li").height($(".videoBox li").eq(0).width()*115/193);
}


//移动端切换pc
function removejscssfile(filename,filetype){
   var targetelement=(filetype=="js")? "script" :(filetype=="css")? "link" : "none"
   var targetattr=(filetype=="js")?"src" : (filetype=="css")? "href" :"none"
   var allsuspects=document.getElementsByTagName(targetelement)
   for (var i=allsuspects.length; i>=0;i--){
      if (allsuspects[i] &&allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
       allsuspects[i].parentNode.removeChild(allsuspects[i])
      }
}
function showPC(){
	removejscssfile("z19_styleMobile.css","css");
	removejscssfile("z19_stylePad.css","css");
    var viewportmeta = document.querySelector('meta[name="viewport"]');
    if (viewportmeta) {
      viewportmeta.content = "width=1254,target-densitydpi=device-dpi";
    }	
	$("html").css({"zoom":"","transform":"","height":"auto"});
		
}
//切换pc版
$("#change_pc,.padPC").click(function(e) {	
	showPC();	
	$(".GoPC").show();	
	var now = new Date();
    now.setTime(now.getTime() + 12 * 60 * 1000);
	$.cookie('flagPC', 'true',{ expires: now,path:'/',secure:false,raw:false});	
	window.location.reload();
	return false;
});
//返回移动版
$(".GoPC").click(function(e) {
	 $.removeCookie('flagPC',{ path: '/'}); 
	 window.location.reload();
});


//回到顶部
$(window).scroll(function(){
			
	if($(window).scrollTop()>=$(window).height()/2){
		$('#returnTop').fadeIn('fast');	
		if($(window).width()<768){
		  $('#returnTopM').fadeIn('fast');	
	    }
	}else{
		$('#returnTop').fadeOut('fast');		
		$('#returnTopM').fadeOut('fast');					
	}		
});
$('#returnTop').click(function(){$('body,html').animate({'scrollTop':0}) });
$('#returnTopM').click(function(){$('body,html').animate({'scrollTop':0}) });

//首页下拉菜单
var _timera;		
function navM(nav,menu){
		  $(nav).on({
			"mouseenter":function(){
			  if(menu.is(":hidden")){
			     menu.stop(true).slideDown(300).siblings(".model_box").stop(true).hide();	
				 nav.addClass("on").siblings("li").removeClass("on");			 
			     clearTimeout(_timera);
			  }
			},
			"mouseleave":function(){
				_timera = setTimeout('$(".model_box").hide();$("#nav li").removeClass("on");',10);
				menu.hover(
				   function(){clearTimeout(_timera)},
				   function(){
					   $(this).stop(true).slideUp(300);
					   $("#nav li").removeClass("on");						   
				   }
					);				
				}
			});
}		   
$("#nav li").each(function(n, m) {
    if(n>0 && $(window).width()>1250){
		navM($("#nav li").eq(n),$("#nav_model .model_box").eq(n-1));
	}
	else{		
		$(this).mouseenter(function(e) {
            $(this).addClass("on");
			$(this).children(".nav_down").stop(true).slideDown(300);
        });
		$(this).mouseleave(function(e) {
            $(this).removeClass("on");
			$(this).children(".nav_down").stop(true).slideUp(300);
        });
		
	}
});

//底部年份获取
var time=new Date();
$("#foot_year").html(time.getFullYear());


if($("#swiper_Focus_kyjz").length>0){
var kyjzSwiperFocus = new Swiper('#swiper_Focus_kyjz',{
				loop:true,
				calculateHeight : true,
				speed:1000,
				autoplay:false,
				autoplayDisableOnInteraction : false,
				pagination : '.pagination_kyjz',
				paginationClickable :true,
				simulateTouch:false				
})
$(window).resize(function(){
    kyjzSwiperFocus.reInit();
});
}

if($("#swiper_Focus_kyjz2").length>0){
var kyjzSwiperFocus2 = new Swiper('#swiper_Focus_kyjz2',{
				loop:true,
				calculateHeight : true,
				speed:1000,
				autoplay:false,
				autoplayDisableOnInteraction : false,
				pagination : '.kyjz_focus2 .pagination_kyjz',
				paginationClickable :true,
				simulateTouch:false				
})
$(window).resize(function(){
    kyjzSwiperFocus2.reInit();
});
}


//移动端二级菜单
var menuR=$(".m_menu_box").width();
$(".m_menu_box").css("right",-menuR);
$(".m_menu_btn").click(function(e) {
	if($(".m_menu_box").css("right")=='0px'){
       $(".m_menu_box").css("right",-menuR);	
	   $(this).removeClass("open");
	}
	else{	  
	  $(".m_menu_box").css("right",0);
	  $(this).addClass("open");
	}
});


//细览页字体大小
var allcontent = $(".xl_content *");
var styleList=new Array();
for (var i = 0; i < allcontent.length; i++) {
   styleList.push(allcontent[i].style.cssText);                     
}

$(".fontB").click(function(){	  
   for (var i = 0; i < allcontent.length; i++) {
	   allcontent[i].style.cssText=styleList[i]+"font-size:18px !important";
   };
   $(this).addClass("now").siblings().removeClass("now");
})
$(".fontM").click(function(){
   for (var i = 0; i < allcontent.length; i++) {
       allcontent[i].style.cssText=styleList[i]+"font-size:16px !important";
   };
   $(this).addClass("now").siblings().removeClass("now");
})
$(".fontS").click(function(){
   for (var i = 0; i < allcontent.length; i++) {
       allcontent[i].style.cssText=styleList[i]+"font-size:14px !important";  
   };
   $(this).addClass("now").siblings().removeClass("now");
}) 

$(function(){  

  
  $(".Left").height($(".Left").height>$(".Right").height()?$(".Left").height:$(".Right").height);
  resizeHeight();
  $(".CASmap").width($(".map").width());
  
	  //判断ipad请求桌面站点（显示pc版）
      var userAgentInfo = navigator.userAgent;
      if (userAgentInfo.indexOf('Macintosh') > 0 ) {
	     showPC(); 
      }
	  
	  if ($.cookie('flagPC')) {
         showPC();
		 $(".GoPC").show();	
      }
  
  
})

$(window).resize(function(){
	resizeHeight();	
	$(".Left").height($(".Left").height>$(".Right").height()?$(".Left").height:$(".Right").height);
	$(".CASmap").width($(".map").width());	
	menuR=$(".m_menu_box").width();
    $(".m_menu_box").css("right",-menuR);
	if($(window).width()>=768){
       $(".video_img2").height(($(".video_left").height()-20)/2);
    }else{
	   $(".video_img2").height("auto");
	}
});

var swiper_zkyzs = new Swiper('#swiper_zkyzs', {
      slidesPerView: 4,
      spaceBetween: 30,
      slidesPerGroup: 4,
      loop: true,
      loopFillGroupWithBlank: true,
      pagination: {
        el: '#swiper_zkyzs_span .swiper-pagination',
        clickable: true,
      },
	  navigation: {
        nextEl: '#swiper_zkyzs_span .swiper-button-next',
        prevEl: '#swiper_zkyzs_span .swiper-button-prev',
      },
});


//组织机构右侧随机
if($('.yqfc li').length>4){
var listArr=new Array();
var listNum=$('.yqfc li').length;
$('.yqfc li').each(function(index, element) {
    listArr.push('<li>'+$(this).html()+'</li>');
});
//生成随机数
var lenArr=new Array();
function getNum(){
	 var random = Math.floor(Math.random()*listNum);
     if(lenArr.length < 4){   
        for(i=0;i<=lenArr.length;i++){
           if(random==lenArr[i]){   
               break;
           }else{
               if(i==lenArr.length){
				   lenArr.push(random);
				   break;
			   }
           }
        };
     getNum();
     }
}
getNum();
$('.yqfc').html('');
for(i=0;i<=lenArr.length;i++){
	$('.yqfc').append(listArr[lenArr[i]]);
}
}


//下面是检索专用js
function isValid(str){
  if(str.indexOf('&') != -1 || str.indexOf('<') != -1 || str.indexOf('>') != -1 || str.indexOf('\'') != -1
    || str.indexOf('\\') != -1 || str.indexOf('/') != -1 || str.indexOf('"') != -1 
    || str.indexOf('%') != -1 || str.indexOf('#') != -1){
    return false;
  }
  return true;
}
$(function(){
  $('#sub-pc').click(function(){
    var searchword = $.trim($('#searchword').val());
	if(searchword == "" || searchword == "请输入关键字" || !isValid(searchword)){
	  alert("请输入关键词后再进行提交。");
      return false;
	}
	$('input[name="keyword"]').val(encodeURI(searchword));
	$('form[name="searchform"]').submit();
  });
  
  $('#sub-mobile').click(function(){
    var iptSword = $.trim($('#iptSword').val());
	if(iptSword == "" || iptSword == "请输入关键字" || !isValid(iptSword)){
	  alert("请输入关键词后再进行提交。");
      return false;
	}
	$('input[name="keyword"]').val(encodeURI(iptSword));
	$('form[name="searchform"]').submit();
  });
});


//专题页是否有图片判断
var ztList=new Array();
$(".ztBox a").each(function() {
    if($(this).children("img").attr("src")==''){
		ztList.push($(this).prop("outerHTML"));
	    $(this).remove();
	}
});
if(ztList.length>0){
  var ztHtml='<div class="ztList clearfix">';
  for(var i=0;i<ztList.length;i++){
	  ztHtml+=ztList[i];
  }
  ztHtml+='</div>';
  $(".ztBox").after(ztHtml);	
}

//移动端检索
$("#m_search").click(function(e) {
    $(this).hide();
	$("#search_close").show();
	$(".m_search").show();
});
$("#search_close").click(function(e) {
    $(this).hide();
	$("#m_search").show();
	$(".m_search").hide();
});

//首页视频新闻图片高度
if($(window).width()>=768){
  $(".video_img2").height(($(".video_left").height()-20)/2);
}







