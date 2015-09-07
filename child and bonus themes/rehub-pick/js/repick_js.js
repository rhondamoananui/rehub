jQuery(document).ready(function() {


	jQuery('.repick_item.centered_im_grid figure').each(function(){
		var height_image_container = jQuery(this).height();
		var width_image_container = jQuery(this).width();
		var image_inside = jQuery(this).find('.img_centered');
		var height_image = image_inside.height();
		var width_image = image_inside.width();
		if (height_image > height_image_container) {
			jQuery(this).addClass('h_reduce pad_wrap');
		}
		if (height_image < height_image_container) {
			jQuery(this).addClass('h_center pad_wrap');
		}
		image_inside.addClass('loaded');
				
	})

	jQuery('.right_aff .price_count').each(function(){
		var width_ofcontainer = jQuery(this).innerWidth() / 2;
		jQuery(this).append('<span class="triangle_aff_price" style="border-width: 14px ' + width_ofcontainer + 'px 0 ' + width_ofcontainer + 'px"></span>');

	})

	jQuery(".hotmeter .hotplus:not(.alreadyhot)").live("click", function(e){
		e.preventDefault();
		var post_id = jQuery(this).data("post_id");	
		var informer = jQuery(this).data("informer");
		jQuery(this).addClass('alreadyhot').parent().find('.hotminus').removeClass('alreadyhot');
		jQuery('#textinfo' + post_id + '').html("<i class='fa fa-spinner fa-spin'></i>");				
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=hot-count&nonce="+ajax_var.nonce+"&hot_count=hot&post_id="+post_id,
			success: function(count){
				jQuery('#textinfo' + post_id + '').html('');			
				if(informer>ajax_var.max_temp){ informer=ajax_var.max_temp; }
				informer=informer+1;
				jQuery('#temperatur' + post_id + '').text(informer+"°"); 
			    if(informer>=0){ 
			       	jQuery('#scaleperc' + post_id + '').css("width", informer / ajax_var.max_temp * 100+'%').removeClass('cold_bar');
			       	jQuery('#temperatur' + post_id + '').removeClass('cold_temp'); 
			    }
			    else {
			    	jQuery('#scaleperc' + post_id + '').css("width", informer / ajax_var.min_temp * 100+'%');
			    }       	
			}
		});
		
		return false;
	})

	jQuery(".hotmeter .hotminus:not(.alreadyhot)").live("click", function(e){
		e.preventDefault();
		var post_id = jQuery(this).data("post_id");	
		var informer = jQuery(this).data("informer");
		jQuery(this).addClass('alreadyhot').parent().find('.hotplus').removeClass('alreadyhot');
		jQuery('#textinfo' + post_id + '').html("<i class='fa fa-spinner fa-spin'></i>");
		jQuery.ajax({
			type: "post",
			url: ajax_var.url,
			data: "action=hot-count&nonce="+ajax_var.nonce+"&hot_count=cold&post_id="+post_id,
			success: function(count){
				jQuery('#textinfo' + post_id + '').html('');				
				informer=informer-1;
				if(informer<ajax_var.min_temp){ informer=ajax_var.min_temp; }
				jQuery('#temperatur' + post_id + '').text(informer+"°"); 
			    if(informer<0){ 
			       	jQuery('#scaleperc' + post_id + '').css("width", informer / ajax_var.min_temp * 100+'%').addClass('cold_bar');
			       	jQuery('#temperatur' + post_id + '').addClass('cold_temp'); 
			    }
			    else {
			    	jQuery('#scaleperc' + post_id + '').css("width", informer / ajax_var.max_temp * 100+'%');
			    }       	
			}
		});
		
		return false;
	});

    //Repick filters
   jQuery('.filter_home_pick span').on('click', function(e){
   		e.preventDefault();
      var pick_filter_wrap = jQuery('#filter_container');
      var sorttype = jQuery(this).data('sorttype');
      var data = {
         'action': 'picker_home',
         'sorttype': sorttype,
         'nonce' : ajax_var.nonce,
      };
      jQuery('.filter_home_pick span').removeClass('active');
      jQuery(this).addClass('active');
      pick_filter_wrap.addClass('loading');

      jQuery.post(ajax_var.url, data, function(response) {
         if (response !== 'fail') {
            pick_filter_wrap.html(response);
         }
         pick_filter_wrap.removeClass('loading');
      });
   });

    //Repick filters
   	jQuery('.home_picker_next span').live('inview', function(e){
   		e.preventDefault();
		var pick_filter_wrap = jQuery('#filter_container');
		var sorttype = jQuery(this).data('sorttype');
		var offset = jQuery(this).data('offset');
		jQuery('.home_picker_next').html('<i class="fa fa-refresh fa-spin"></i>');
		var data = {
			'action': 'picker_home',
			'sorttype': sorttype,
			'offset' : offset,
			'nonce' : ajax_var.nonce,
		};
		jQuery.post(ajax_var.url, data, function(response) {
			jQuery('.home_picker_next').remove();
			if (response !== 'fail') {
		    	pick_filter_wrap.append(jQuery(response).hide().fadeIn(1000));
			} 
		});
   	});   


})

var re_sizebg = function(){
   'use strict';
   jQuery('.vc_custom_row_width').each(function() {
   var ride = jQuery(this).data('bg-width');
   var ancenstor,parent;
   parent = jQuery(this).parent();
   if(ride=='container_width'){
      ancenstor = jQuery('.main-side');
   }
   else if(ride == 'window_width'){
      ancenstor = jQuery('html');
   }
   var al= parseInt( ancenstor.css('paddingLeft') );
   var ar= parseInt( ancenstor.css('paddingRight') )
   var w = al+ar + ancenstor.width();
   var bl = - al;
   if ( bl > 0 ) { bl = 0; }
   jQuery(this).css({'width': w,'margin-left': bl })
});
};