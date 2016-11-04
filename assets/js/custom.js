/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {
	
	/*
	*
	*	Current Page Active
	*
	------------------------------------*/
	$("[href]").each(function() {
    if (this.href == window.location.href) {
        $(this).addClass("active");
        }
	});
	
	/*
	*
	*	Flexslider
	*
	------------------------------------*/
	$('.flexslider').flexslider({
		animation: "slide",
	}); // end register flexslider
	
	/*
	*
	*	Colorbox
	*
	------------------------------------*/
	$('a.gallery').colorbox({
		rel:'gal',
		width: '80%', 
		height: '80%'
	});
	
	/*
	*
	*	Isotope with Images Loaded
	*
	------------------------------------*/
	var $container = $('#container').imagesLoaded( function() {
  	$container.isotope({
    // options
	 itemSelector: '.item',
		  masonry: {
			gutter: 15
			}
 		 });
	});

	/*
	*
	*	Smooth Scroll to Anchor
	*
	------------------------------------*/
	 $('a').click(function(){
	    $('html, body').animate({
	        scrollTop: $('[name="' + $.attr(this, 'href').substr(1) + '"]').offset().top
	    }, 500);
	    return false;
	});


    function anchor_scroll_capsule(){
        $(window).imagesLoaded(function() {
            var hash = window.location.hash;
            if (hash.length >0) {
                if($('[name="' + hash.substr(1) + '"]').length>0) {
                    $('html, body').animate({
                        scrollTop: $('[name="' + hash.substr(1) + '"]').offset().top
                    }, 500);
                }
            }
        });
    }
	anchor_scroll_capsule();
	
	/*
	*
	*	Equal Heights Divs
	*
	------------------------------------*/
	$('.js-blocks').matchHeight();

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();


    //image hover for icons on category/archive pages
    (function(){
        $('.image-wrapper').hover(function(){
            $(this).find('.overlay').css("display","block");
        },function(){
            $(this).find('.overlay').css("display","none");
        });
    })();
    //hover for cart icon
    (function(){
        $('#socialheader ul li.cart').hover(function() {
            if($('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout")!==undefined){
                clearTimeout(Number($('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout")));
            }
            $('#masthead > .row-1 > .column-3 .popup-cart').css("display","block");
        }, function(){
            var timeout = setTimeout(function(){
                $('#masthead > .row-1 > .column-3 .popup-cart').css("display","none");
            },300);
            $('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout",timeout);
        });
        $('#masthead > .row-1 > .column-3 .popup-cart').hover(function() {
            if($('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout")!==undefined){
                clearTimeout(Number($('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout")));
            }
            $('#masthead > .row-1 > .column-3 .popup-cart').css("display","block");
        }, function(){
            var timeout = setTimeout(function(){
                $('#masthead > .row-1 > .column-3 .popup-cart').css("display","none");
            },300);
            $('#masthead > .row-1 > .column-3 .popup-cart').attr("data-timeout",timeout);
        });

        $('.quickview').colorbox({
            rel:'gal',
            inline: true,
            width: '90%',
            maxWidth: '960px',
        });
    })();
    //function to add items to cart
    (function(){
        $('form.cart').find('button[type=submit]').on('click',function(e){
            e.preventDefault();
            var $form = $(this).parents('form.cart').eq(0);
            var id = $form.find('input[name="add-to-cart"]').attr('value');
            var qty = $form.find('input[name="quantity"]').attr('value');
            //add to cart
            jQuery.post(
                bellaajaxurl.url,
                {
                    'action': 'bella_add_cart',
                    'id': id,
                    'qty':qty,
                },
                function(response){
                    if(Number($(response).find("cart").attr("id"))===1){
                        //update cart popup
                        jQuery.post(
                            bellaajaxurl.url,
                            {
                                'action': 'bella_get_cart',
                                'data':'',
                            },
                            function(response){
                                if($(response).find("response_data").length>0){
                                    $text = $(response).find("response_data").eq(0).text();
                                    $('.popup-cart').html($text);

                                }
                            }
                        );
                        //update cart popup
                        jQuery.post(
                            bellaajaxurl.url,
                            {
                                'action': 'bella_get_cart_count',
                                'data':'',
                            },
                            function(response){
                                if($(response).find("response_data").length>0){
                                    $text = $(response).find("response_data").eq(0).text();
                                    $('#socialheader ul li.cart a').html($text);

                                }
                            }
                        );
                        //invoke checkout popup
                        jQuery.post(
                            bellaajaxurl.url,
                            {
                                'action': 'bella_get_checkout_popup',
                                'id':id,
                            },
                            function(response){
                                if($(response).find("response_data").length>0){
                                    $text = $(response).find("response_data").eq(0).text();
                                    $.colorbox({
                                        width: '90%',
                                        maxWidth: '600px',
                                        height: '120%',
                                        html:$text,
                                    });
                                    $('.popup-checkout .continue.button').on('click',function(e){
                                        e.preventDefault();
                                        $.colorbox.close();
                                    });
                                }
                            }
                        );
                    }
                }
            );
        });
    })();

    (function(){
        $('.product-tabs .top-bar .title').eq(0).addClass("active");
        $('.product-tabs .top-bar .title').on('click',function(){
            var $this = $(this);
            var type = $this.attr("data-type");
            $('.product-tabs .top-bar .title').filter(".active").removeClass("active");
            $this.addClass("active");
            $('.product-tabs .viewport .copy').each(function(){
                var $this = $(this);
                if($this.attr('data-type')===type){
                    $this.css("display","block");
                } else {
                    $this.css("display","none");
                }
            });
        });
    })();

    //remove Tooltips
    (function(){
        var saved_title;
        $('img').hover(function(){
            var $this = $(this);
            saved_title=$this.attr("title")===undefined?"":$this.attr("title");
            $this.attr("title","");
        },function(){
            var $this = $(this);
            $this.attr("title",saved_title);
        });
    })();

// 		Search Toggle
//__________________________________________

    $( '.search-icon' ).click(function() {
        $( 'input.search-field' ).toggle( 100);
    });
    /**
     * navigation.js
     *
     * Handles toggling the navigation menu for small screens.
     */
    ( function() {
        var nav = document.getElementById( 'site-navigation' ), button, menu;
        if ( ! nav )
            return;
        button = nav.getElementsByTagName( 'h3' )[0];
        menu   = nav.getElementsByTagName( 'ul' )[0];
        if ( ! button )
            return;

        // Hide button if menu is missing or empty.
        if ( ! menu || ! menu.childNodes.length ) {
            button.style.display = 'none';
            return;
        }

        button.onclick = function() {
            if ( -1 == menu.className.indexOf( 'nav-menu' ) )
                menu.className = 'nav-menu';

            if ( -1 != button.className.indexOf( 'toggled-on' ) ) {
                button.className = button.className.replace( ' toggled-on', '' );
                menu.className = menu.className.replace( ' toggled-on', '' );
            } else {
                button.className += ' toggled-on';
                menu.className += ' toggled-on';
            }
        };
    } )();
});// END #####################################    END