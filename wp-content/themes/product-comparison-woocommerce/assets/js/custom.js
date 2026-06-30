function product_comparison_woocommerce_menu_open_nav() {
	window.product_comparison_woocommerce_responsiveMenu=true;
	jQuery(".sidenav").addClass('show');
}
function product_comparison_woocommerce_menu_close_nav() {
	window.product_comparison_woocommerce_responsiveMenu=false;
 	jQuery(".sidenav").removeClass('show');
}

jQuery(function($){
 	"use strict";
 	jQuery('.main-menu > ul').superfish({
		delay: 500,
		animation: {opacity:'show',height:'show'},
		speed: 'fast'
 	});
});

jQuery(document).ready(function () {
	window.product_comparison_woocommerce_currentfocus=null;
  	product_comparison_woocommerce_checkfocusdElement();
	var product_comparison_woocommerce_body = document.querySelector('body');
	product_comparison_woocommerce_body.addEventListener('keyup', product_comparison_woocommerce_check_tab_press);
	var product_comparison_woocommerce_gotoHome = false;
	var product_comparison_woocommerce_gotoClose = false;
	window.product_comparison_woocommerce_responsiveMenu=false;
 	function product_comparison_woocommerce_checkfocusdElement(){
	 	if(window.product_comparison_woocommerce_currentfocus=document.activeElement.className){
		 	window.product_comparison_woocommerce_currentfocus=document.activeElement.className;
	 	}
 	}
 	function product_comparison_woocommerce_check_tab_press(e) {
		"use strict";
		// pick passed event or global event object if passed one is empty
		e = e || event;
		var activeElement;

		if(window.innerWidth < 999){
		if (e.keyCode == 9) {
			if(window.product_comparison_woocommerce_responsiveMenu){
			if (!e.shiftKey) {
				if(product_comparison_woocommerce_gotoHome) {
					jQuery( ".main-menu ul:first li:first a:first-child" ).focus();
				}
			}
			if (jQuery("a.closebtn.mobile-menu").is(":focus")) {
				product_comparison_woocommerce_gotoHome = true;
			} else {
				product_comparison_woocommerce_gotoHome = false;
			}

		}else{

			if(window.product_comparison_woocommerce_currentfocus=="responsivetoggle"){
				jQuery( "" ).focus();
			}}}
		}
		if (e.shiftKey && e.keyCode == 9) {
		if(window.innerWidth < 999){
			if(window.product_comparison_woocommerce_currentfocus=="header-search"){
				jQuery(".responsivetoggle").focus();
			}else{
				if(window.product_comparison_woocommerce_responsiveMenu){
				if(product_comparison_woocommerce_gotoClose){
					jQuery("a.closebtn.mobile-menu").focus();
				}
				if (jQuery( ".main-menu ul:first li:first a:first-child" ).is(":focus")) {
					product_comparison_woocommerce_gotoClose = true;
				} else {
					product_comparison_woocommerce_gotoClose = false;
				}

			}else{

			if(window.product_comparison_woocommerce_responsiveMenu){
			}}}}
		}
	 	product_comparison_woocommerce_checkfocusdElement();
	}
});

jQuery('document').ready(function($){
  setTimeout(function () {
		jQuery("#preloader").fadeOut("slow");
  },1000);

  /*sticky sidebar*/
window.addEventListener('scroll', function() {
  var sticky = document.querySelector('.sidebar-sticky');
  if (!sticky) return;

  var scrollTop = window.scrollY || document.documentElement.scrollTop;
  var windowHeight = window.innerHeight;
  var documentHeight = document.documentElement.scrollHeight;

  var isBottom = scrollTop + windowHeight >= documentHeight-100;

  if (scrollTop >= 100 && !isBottom) {
    sticky.classList.add('sidebar-fixed');
  } else {
    sticky.classList.remove('sidebar-fixed');
  }
});

  // Sticky Copyright
  $(window).scroll(function(){
    var sticky = $('.copyright-sticky'),
      scroll = $(window).scrollTop();

    if (scroll >= 100) sticky.addClass('copyright-fixed');
    else sticky.removeClass('copyright-fixed');
  });
});

jQuery(document).ready(function () {
	jQuery(window).scroll(function () {
    if (jQuery(this).scrollTop() > 100) {
      jQuery('.scrollup i').fadeIn();
    } else {
      jQuery('.scrollup i').fadeOut();
    }
	});
	jQuery('.scrollup i').click(function () {
    jQuery("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
	});
});

jQuery(document).ready(function () {
	  function product_comparison_woocommerce_search_loop_focus(element) {
	  var product_comparison_woocommerce_focus = element.find('select, input, textarea, button, a[href]');
	  var product_comparison_woocommerce_firstFocus = product_comparison_woocommerce_focus[0];
	  var product_comparison_woocommerce_lastFocus = product_comparison_woocommerce_focus[product_comparison_woocommerce_focus.length - 1];
	  var KEYCODE_TAB = 9;

	  element.on('keydown', function product_comparison_woocommerce_search_loop_focus(e) {
	    var isTabPressed = (e.key === 'Tab' || e.keyCode === KEYCODE_TAB);

	    if (!isTabPressed) {
	      return;
	    }

	    if ( e.shiftKey ) /* shift + tab */ {
	      if (document.activeElement === product_comparison_woocommerce_firstFocus) {
	        product_comparison_woocommerce_lastFocus.focus();
	          e.preventDefault();
	        }
	      } else /* tab */ {
	      if (document.activeElement === product_comparison_woocommerce_lastFocus) {
	        product_comparison_woocommerce_firstFocus.focus();
	          e.preventDefault();
	        }
	      }
	  });
	}
	jQuery('.search-box span a').click(function(){
    jQuery(".serach_outer").slideDown(1000);
  	product_comparison_woocommerce_search_loop_focus(jQuery('.serach_outer'));
  });
  jQuery('.closepop a').click(function(){
    jQuery(".serach_outer").slideUp(1000);
  });
});

jQuery('#banner .slider-for').slick({
  slidesToShow: 1,
  infinite: true,
  arrows: true,
  fade: true,
  asNavFor: '.slider-nav',

});
jQuery('#banner .slider-nav').slick({
  slidesToShow: 3,
  infinite: true,
  centerPadding: '0px',
  arrows: true,
  slidesToScroll: 1,
  asNavFor: '#banner .slider-for',
  prevArrow: '<i class="fa fa-chevron-left"></i>',
  nextArrow: '<i class="fa fa-chevron-right"></i>',
  dots: false,
  focusOnSelect: true,
  responsive: [
  {
    breakpoint: 1024,
    settings: {
    slidesToShow: 1,
  }
},
  {
    breakpoint: 1200,
    settings: {
    slidesToShow: 2,
  }
  }
]
})

// product

jQuery('#best-product-section .slick').slick({
	dots: false,
	infinite: false,
	speed: 300,
	slidesToShow: 4,
	slidesToScroll: 4,
	arrows: true,
	slidesToScroll: 1,
	prevArrow: '<i class="fa fa-chevron-left"></i>',
	nextArrow: '<i class="fa fa-chevron-right"></i>',
	dots: false,
	responsive: [
	  {
	    breakpoint: 1024,
	    settings: {
	      slidesToShow: 3,
	      slidesToScroll: 3,
	      infinite: true,
	      dots: false
	    }
	  },
	  {
	    breakpoint: 600,
	    settings: {
	      slidesToShow: 2,
	      slidesToScroll: 2
	    }
	  },
	  {
	    breakpoint: 480,
	    settings: {
	      slidesToShow: 1,
	      slidesToScroll: 1
	    }
	  }
	]
});

/* Progress Bar */
document.addEventListener("DOMContentLoaded", function () {
    const product_comparison_woocommerce_progressBar =
        document.getElementById("product_comparison_woocommerce_elemento_progress_bar");
    if (!product_comparison_woocommerce_progressBar) return;
    window.addEventListener("scroll", function () {
        const product_comparison_woocommerce_scrollTop =
            document.documentElement.scrollTop || document.body.scrollTop;
        const product_comparison_woocommerce_height =
            document.documentElement.scrollHeight -
            document.documentElement.clientHeight;
        const product_comparison_woocommerce_scrolled =
            (product_comparison_woocommerce_scrollTop / product_comparison_woocommerce_height) * 100;
        product_comparison_woocommerce_progressBar.style.width =
            product_comparison_woocommerce_scrolled + "%";
    });
});