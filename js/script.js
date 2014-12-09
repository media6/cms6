$(document).ready(function(){
    MSIE8 = ($.browser.msie) && ($.browser.version == 8),
	$.fn.ajaxJSSwitch({
		topMargin: 274,//mandatory property for decktop
		bottomMargin: 113,//mandatory property for decktop
		topMarginMobileDevices: 274,//mandatory property for mobile devices
		bottomMarginMobileDevices: 93,//mandatory property for mobile devices
        delaySubMenuHide: 300,
		menuInit:function (classMenu, classSubMenu){
		},
		buttonOver:function (item){
            $('>strong',item).stop().animate({'opacity':'1'},300,'easeOutCubic')
            $('>span',item).stop().animate({'color':'#bbbbbb'},300,'easeOutCubic')
		},
		buttonOut:function (item){
            $('>strong',item).stop().animate({'opacity':'0'},600,'easeOutCubic')
            $('>span',item).stop().animate({'color':'#2c2c2c'},600,'easeOutCubic')
		},
		subMenuButtonOver:function (item){
		},
		subMenuButtonOut:function (item){
		},
		subMenuShow:function(subMenu){
        	subMenu.stop(true,true).animate({"opacity":"show"}, 400, "easeOutCubic");
		},
		subMenuHide:function(subMenu){
        	subMenu.stop(true,true).animate({"opacity":"hide"}, 500, "easeOutCubic");
		},
		pageInit:function (pages){
		},
		currPageAnimate:function (page){
            page.css({"left":$(window).width()}).stop(true).delay(300).animate({"left":0}, 500, "easeOutCubic");
		},
		prevPageAnimate:function (page){
            page.stop(true).animate({"display":"block", "left":-$(window).outerWidth()*2}, 700, "easeInCubic");
		},
		backToSplash:function (){
		},
		pageLoadComplete:function (){
        }
	});
})
$(window).load(function(){
    setTimeout(function (){ $(window).trigger('resize') },600)
    $(".image_resize").image_resize({});
	$("#webSiteLoader").delay(500).animate({opacity:0}, 600, "easeInCubic", function(){$("#webSiteLoader").remove()});
});