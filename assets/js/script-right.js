$( window ).load(function() {
     $(".mobile-menu").removeClass('hideMobileMenu');
	 console.log('Remove : hideMobileMenu');
});

(function ($) {
  
  $.jvmobilemenu({
    mainContent: $('.page'),
    theMenu: $('.mobile-nav'),
    slideSpeed: 0,
    menuWidth: 265,
    position: 'right',
    menuPadding: '0px 0px 0px'
  });
   $(".mobile-menu").addClass('hideMobileMenu');
   console.log('Add : hideMobileMenu');
})(jQuery);

/* Min height for body content */
 $(document).ready(function() {
  function setHeight() {
    windowHeight = $(window).innerHeight();
    $('.note_outer').css('min-height', windowHeight);
  };
  setHeight();
  
  $(window).resize(function() {
    setHeight();
  });
});

/* */
 jQuery(function(){
    jQuery('.bd-min-hgt, .regist-wrp') .css({'min-height': ((jQuery(window).height() - 189))+'px'});
    jQuery(window).resize(function(){
        jQuery('.bd-min-hgt, .regist-wrp') .css({'min-height': ((jQuery(window).height() - 189))+'px'});
    });
});
