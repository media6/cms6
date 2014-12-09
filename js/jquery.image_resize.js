/*
**Version: 1.0;
**Jquery version: 1.8.3;
**Author: Behaart;
**Option:
	align_img: center / top / bottom / left / right / top_left / top_right / bottom_left / bottom_right (default:center)
	mobile_align_img: center / top / bottom / left / right / top_left / top_right / bottom_left / bottom_right (default:center)
*/
(function($){
	$.fn.image_resize=function(properties){
		var settings = {
				align_img:"center",
				mobile_align_img:"center", 
			},
			default_img = $(this),
			holder_img,
			device_window = $(window),
			top_img="top_img",
			bottom_img="bottom_img",
			body_background = $("body").css("background-color"),
			current_img = default_img,
			img_k,
			delta_y = 100;
			
		init()
		function init(){
			$.extend(settings, properties);
			/*parsing DOM*/
			default_img.wrapAll("<div id='holder_img'><div id='"+top_img+"'></div></div>");
			holder_img = $("#holder_img")
			holder_img.css({"position":"absolute", "top":"0", "z-index":"-1", "width":"100%", "height":"100%"});
			$("#"+top_img+", "+"#"+bottom_img).css({"position":"relative", "z-index":"0", "width":"100%", "height":"100%"});
			
			/*add event, call function*/
			image_load_complete();
			device_window.bind("resize", resize_window_handler).trigger("resize");	
		}
		function resize_window_handler(){
			var	window_size = {"width":$(window).outerWidth(true), "height":$(window).outerHeight()},
				window_k = window_size.height/window_size.width,
				img_new_Wsize,
				img_new_Hsize,
				img_offset_x = 0,
				img_offset_y = 0,
				screen_orient = window.orientation;
				
			/*resise image*/
			if(window_k<img_k){
				img_new_Wsize=$(window).width();
				img_new_Hsize=$(window).width()*img_k;
			}else{
				img_new_Wsize=($(window).height() + delta_y)/img_k;
				img_new_Hsize=$(window).height() + delta_y;
			}
			/*position image*/
			if(screen_orient!= undefined){
				settings.align_img = settings.mobile_align_img;
			}
			switch(settings.align_img){
				case "top":
					img_offset_x = ($(window).width()-img_new_Wsize)/2;
				break;
				case "bottom":
					img_offset_y = $(window).height()-img_new_Hsize;
					img_offset_x = ($(window).width()-img_new_Wsize)/2;
				break;
				case "right":
					img_offset_y = ($(window).height()-img_new_Hsize)/2;
					img_offset_x = $(window).width()-img_new_Wsize- delta_y;
				break;
				case "left":
					img_offset_y=($(window).height()-img_new_Hsize)/2;
				break;
				case "top_left":
					//img_offset_x = 0;
					//img_offset_y = 0;
				break;
				case "top_right":
					img_offset_x = $(window).width()-img_new_Wsize;
				break;
				case "bottom_right":
					img_offset_y = $(window).height()-img_new_Hsize;
					img_offset_x = $(window).width()-img_new_Wsize;
				break;
				case "bottom_left":
					img_offset_y = $(window).height()-img_new_Hsize;
				break;
				default:
					img_offset_y = ($(window).height() - img_new_Hsize)*0.5;
					img_offset_x = ($(window).width() - img_new_Wsize)*0.5;
			}
			current_img.css({"top":img_offset_y, "left":img_offset_x, "height":img_new_Hsize, "width":img_new_Wsize, "background-color":body_background, "vertical-align":"inherit", "position":"fixed", "max-width":"none", "min-width":"none"});
		}
		function image_load_complete(){
			current_img = $("img", holder_img).eq(0);
			img_k = current_img.height() / current_img.width();
			resize_window_handler()
		}
		/*function animate(){
			$("#"+top_img).css({
				"top":2000, 
				"transform":"rotate(30deg)",
				"transition": "all 1s cubic-bezier(0.55, 0.055, 0.675, 0.19)"
			})
		}*/
	}
})(jQuery)