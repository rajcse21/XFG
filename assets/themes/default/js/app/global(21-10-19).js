var SMALL_SCREEN = false;
var MEDIUM_SCREEN = false;
function setScreenSize() {
    if ($(window).width() <= 767) {
        SMALL_SCREEN = true;
    } else {
        SMALL_SCREEN = false;
    }
}


equalheight = function (container) {
    if (SMALL_SCREEN) {
        return;
    }
    var currentTallest = 0, currentRowStart = 0, rowDivs = new Array(), $el, topPosition = 0;
    $(container).each(function () {
        $el = $(this);
        $($el).height('auto');
        topPostion = $el.position().top;
        if (currentRowStart != topPostion) {
            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
            rowDivs.length = 0;
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);
        } else {
            rowDivs.push($el);
            currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }
        for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
        }
    });
};
function equalheights() {
    equalheight('.calc_wrapper .calc_text');

}

jQuery(document).ready(function ($) {
    equalheights();
	 
   AOS.init({
        //offset: -800
    });
    $('.slick_fade').slick({
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        slide: 'div',
        autoplay: true,
        autoplaySpeed: 5000,
        cssEase: 'linear'
    });
	

    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 50,
        nav: true,
        dots: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 5
            }
        }
    });

    jQuery('ul.sf-menu').superfish();

// create a menu
			var menu = new MmenuLight( document.querySelector( '#menu' ), {
				// title: 'Menu',
				// theme: 'light',// 'dark'
				// slidingSubmenus: true,// false
				// selected: 'Selected'
			});
			menu.enable( 'all' ); // '(max-width: 900px)'
			menu.offcanvas({
				// position: 'left',// 'right'
				// move: true,// false
				// blockPage: true,// false / 'modal'
			});

			//	Open the menu.
			document.querySelector( 'a[href="#menu"]' )
				.addEventListener( 'click', ( evnt ) => {
					menu.open();

					//	Don't forget to "preventDefault" and to "stopPropagation".
					evnt.preventDefault();
					evnt.stopPropagation();
				});
   /* $('#menu').slinky({
        title: 'false'
    });*/
    $('.nav-toggle').click(function (e) {
        $('.top-bar-abs').addClass('show');
        $('body').addClass('show-popup');
    });

    $('.nav-toggle-close').click(function () {
        $(this).parent('.top-bar-abs').removeClass('show');
        $('body').removeClass('show-popup');
    });
	
	
    if ($('.frm_submit_btn').length) {
        $('.frm_submit_btn').click(function (e) {
            e.preventDefault();
            var $frm_type = $(this).data('type');
            var $frm = $(this).parents('form');
            var $post_url = $frm.attr('action');
            $.post($post_url, $frm.serialize(), function (data) {
                $('.form-control', $frm).next('.invalid-feedback').remove();
                $('.form-control', $frm).removeClass('is-invalid');
                $('.form-control', $frm).removeClass('is-valid');
                //Form error
                if (data.status == 'ERROR') {
                    for (key in data.errors) {
                        if (data.errors[key]) {
                            console.log(data.errors[key] + ' adds here ' + '#' + $frm_type + '_' + key);
                            $(data.errors[key]).insertAfter($('#' + $frm_type + '_' + key, $frm));
                            $('#' + $frm_type + '_' + key, $frm).addClass('is-invalid');
                        }
                    }
                    return false;
                } else {
                    window.location.href = XF_BASE_URL + data.message;
                }
            }, "json");
        });
    }

});