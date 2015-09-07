jQuery(document).ready(function($) {
   'use strict';	

   function GetURLParameter(sParam){
      var sPageURL = window.location.search.substring(1);
      var sURLVariables = sPageURL.split('&');
      for (var i = 0; i < sURLVariables.length; i++) 
      {
         var sParameterName = sURLVariables[i].split('=');
         if (sParameterName[0] == sParam) 
         {
            return sParameterName[1];
         }
      }
   }    

   var affcoupontrigger = GetURLParameter("codetext");
   if(affcoupontrigger){
      var $change_code = $(".rehub_offer_coupon.masked_coupon:not(.expired_coupon)[data-codetext='" + affcoupontrigger +"']");
      var couponcode = $change_code.data('clipboard-text'); 
      var coupondestination = $change_code.data('dest');
      $change_code.removeClass('masked_coupon').removeClass('btn_offer_block').addClass('not_masked_coupon').html( '<i class="fa fa-scissors fa-rotate-180"></i><span class="coupon_text">'+ couponcode +'</span>' );                
      $.pgwModal({
         titleBar: false,
         content: '<div class="coupon_code_in_modal"><div class="title_modal_coupon">' + translation.coupontextready + '</div><div class="text_copied_coupon">' + translation.coupontextcopied + '</div><div class="coupon_modal_coupon">' + couponcode + '</div><div class="add_modal_coupon">' + translation.coupongoto + '<a href="' + coupondestination + '" target="_blank" rel="nofollow">' + translation.couponwebsite + '</a>' + translation.couponuseoffer + '<br>' + translation.couponorcheck + '</div></div>',
      });
   };

});