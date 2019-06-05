/*--------------------- Copyright (c) 2018 -----------------------
[Master Javascript]
Project: Miraculous - Online Music Store Html Template
Version: 1.0.0
Assigned to: Theme Forest
-------------------------------------------------------------------*/
(function($) {
    "use strict";
    var music = {
        initialised: false,
        version: 1.0,
        mobile: false,
        init: function() {
            if (!this.initialised) {
                this.initialised = true;
            } else {
                return;
            }
            /*-------------- Music Functions Calling ---------------------------------------------------
            ------------------------------------------------------------------------------------------------*/
            this.RTL();
            this.Menu();
            this.Player_close();
            this.Popup();
            this.Slider();
            this.More();
            this.Nice_select();
            this.showPlayList();
            this.volume();
        },
        /*-------------- Music Functions definition ---------------------------------------------------
        ---------------------------------------------------------------------------------------------------*/
        RTL: function() {
            var rtl_attr = $("html").attr('dir');
            if (rtl_attr) {
                $('html').find('body').addClass("rtl");
            }
        },
        /* Toggle Menu */
        Menu: function() {
            
            $('.sub-menu').parent().hover(function() {
                var menu = $(this).find("ul");
                var menupos = $(menu).offset();
                if (menupos.left + menu.width() > $(window).width()) {
                    var newpos = -$(menu).width();
                    menu.css({
                        left: newpos
                    });
                }
            });
            $(".ms_nav_close").on('click', function() {
                $(".ms_sidemenu_wrapper").toggleClass('open_menu');
                $('body').toggleClass('slide_menu');
            });
            
            $(".play-left-arrow").on('click', function() {
                $(".player_left").toggleClass('open_list');
            });
            
            $(".ms_admin_name").on('click', function() {
                $(".pro_dropdown_menu").toggleClass("open_dropdown");
            });
            
            $(document).on('click', function() {
                $('.pro_dropdown_menu').removeClass("open_dropdown");
            });
            $('.ms_admin_name').on('click', function(event) {
                event.stopPropagation();
            });
            
            $('.ms_nav_wrapper ul li.menu-item-has-children').children('a').append(function() {
                return '<div class="dropdown-expander"><i class="fa fa-plus" aria-hidden="true"></i></div>';
            });
            $(".ms_nav_wrapper ul > li:has(ul) > a").on('click', function(e) {
                var w = window.innerWidth;
                if (w <= 991) {
                    e.preventDefault();
                    $(this).parent('.ms_nav_wrapper ul li').children('ul.sub-menu').slideToggle();
                }
            });
            
            $('.ms_menu_bar').on('click', function() {
                $('.ms_basic_header').toggleClass('menu_open');
            })
            $('.ms_basic_menu ul li.menu-item-has-children').children('a').append(function() {
                return '<div class="dropdown-expander"><i class="fa fa-plus" aria-hidden="true"></i></div>';
            });
            $(".ms_basic_menu ul > li:has(ul) > a").on('click', function(e) {
                var w = window.innerWidth;
                if (w <= 991) {
                    e.preventDefault();
                    $(this).parent('.ms_basic_menu ul li').children('ul.sub-menu').slideToggle();
                }
            });
        },
        
        Player_close: function() {
            $(".ms_player_close").on('click', function() {
                $(".ms_player_wrapper").toggleClass("close_player");
                $("body").toggleClass("main_class")
            })
        },
        
        Popup: function() {
            $('.clr_modal_btn a').on('click', function() {
                $('#clear_modal').hide();
                $('.modal-backdrop').hide();
                $('body').removeClass("modal-open").css("padding-right", "0px");
            })
            $('.hideCurrentModel').on('click', function() {
                $(this).closest('.modal-content').find('.form_close').trigger('click');
            });
            
            $('.lang_list').find("input[type=checkbox]").on('change', function() {
                if ($('.lang_list').find("input[type=checkbox]:checked").length) {
                    $('.ms_lang_popup .modal-content').addClass('add_lang');
                } else {
                    $('.ms_lang_popup .modal-content').removeClass('add_lang');
                }
            });
        },
        
        Slider: function() {
			
			$('.swiper-container').each(function(i, n) {
					var tt = $(this).attr('data-type');
					var swiper = new Swiper('.ms_slider'+tt+'.swiper-container', {
					slidesPerView: 6,
					spaceBetween: 30,
					speed: 1500,
					navigation: {
						nextEl: '.swiper-button-next'+tt,
						prevEl: '.swiper-button-prev'+tt,
					},
					breakpoints: {
						1800: {
							slidesPerView: 4,
						},
						1400: {
							slidesPerView: 4,
						},
						992: {
							slidesPerView: 2,
							spaceBetween: 10,
						},
						768: {
							slidesPerView: 2,
							spaceBetween: 5,
						},
						640: {
							slidesPerView: 2,
							spaceBetween: 30,
						},
						480: {
							slidesPerView: 1,
							spaceBetween: 0,
						},
						375: {
							slidesPerView: 1,
							spaceBetween: 0,
						}
					},
				});
			});
			
            var swiper = new Swiper('.swiper-container', {
                slidesPerView: 6,
                spaceBetween: 30,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 5,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 30,
                    },
                    480: {
                        slidesPerView: 1,
						spaceBetween: 0,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            
            var swiper = new Swiper('.ms_rcnt_slider .swiper-container', {
                slidesPerView: 6,
                spaceBetween: 30,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next5',
                    prevEl: '.swiper-button-prev5',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView:1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            
            var swiper = new Swiper('.ms_feature_slider.swiper-container', {
                slidesPerView: 6,
                spaceBetween: 30,
                speed: 1500,
				loop:false,
                navigation: {
                    nextEl: '.swiper-button-next1',
                    prevEl: '.swiper-button-prev1',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            
            var swiper = new Swiper('.ms_release_slider.swiper-container', {
                slidesPerView: 4,
                spaceBetween: 30,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next2',
                    prevEl: '.swiper-button-prev2',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            
            var swiper = new Swiper('.ms_album_slider.swiper-container', {
                slidesPerView: 6,
                spaceBetween: 30,
                loop: false,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next3',
                    prevEl: '.swiper-button-prev3',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            
            var swiper = new Swiper('.ms_radio_slider.swiper-container', {
                slidesPerView: 6,
                spaceBetween: 30,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next4',
                    prevEl: '.swiper-button-prev4',
                },
                breakpoints: {
                    1800: {
                        slidesPerView: 4,
                    },
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 15,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                    375: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    }
                },
            });
            /* Testimonial Slider */
            var swiper = new Swiper('.ms_test_slider.swiper-container', {
                slidesPerView: 4,
                spaceBetween: 30,
                slidesPerColumn: 1,
                loop: false,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next1',
                    prevEl: '.swiper-button-prev1',
                },
                breakpoints: {
                    1400: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 1,
                    },
                },
            });
            
            var swiper = new Swiper('.ms_woocommerce_slider.swiper-container', {
                slidesPerView: 3,
                spaceBetween: 30,
                slidesPerColumn: 1,
                loop: false,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next1',
                    prevEl: '.swiper-button-prev1',
                },
                breakpoints: {
                    1400: {
                        slidesPerView: 3,
                    },
                    992: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 1,
                    },
                },
            });
            
            var swiper = new Swiper('.ms_product_slides_slider.swiper-container', {
                slidesPerView: 4,
                spaceBetween: 30,
                slidesPerColumn: 1,
                loop: false,
                speed: 1500,
                navigation: {
                    nextEl: '.swiper-button-next1',
                    prevEl: '.swiper-button-prev1',
                },
                breakpoints: {
                    1400: {
                        slidesPerView: 4,
                    },
                    992: {
                        slidesPerView: 3,
                    },
                    767: {
                        slidesPerView: 2,
                    },
                    480: {
                        slidesPerView: 1,
                    },
                },
            }); 
        },
        
        More: function() {
            $(".ms_more_icon").on('click', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                if (typeof $(this).attr('data-other') != 'undefined') {
                    var target = $(this).parent().parent();
                } else {
                    var target = $(this).parent();
                }
                if (target.find("ul.more_option").hasClass('open_option')) {
                    target.find("ul.more_option").removeClass('open_option');
                } else {
                    $("ul.more_option.open_option").removeClass('open_option');
                    target.find("ul.more_option").addClass('open_option');
                }
            });
            $(document).on("click", function(e) {
                $("ul.more_option.open_option").removeClass("open_option");
            });
            $(document).on('click', '#playlist-wrap ul li .action .que_more', function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                $('#playlist-wrap ul li .action .que_more').not($(this)).closest('li').find('.more_option').removeClass('open_option');
                $(this).closest('li').find('.more_option').toggleClass('open_option');
            });
            
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.more_option').length && !$(e.target).closest('.action').length) {
                    $('#playlist-wrap .more_option').removeClass('open_option');
                }
                if (!$(e.target).closest('#playlist-wrap').length && !$(e.target).closest('.jp_queue_wrapper').length && !$(e.target).closest('.player_left').length) {
                    $('#playlist-wrap').hide();
                }
            });
            
            $('.jp_queue_cls').on('click', function(e) {
                $('#playlist-wrap').hide();
            });
        },
        /* Nice Select */
        Nice_select: function() {
            if ($('.custom_select').length > 0) {
                $('.custom_select select').niceSelect();
            }
        },
        showPlayList: function() {
            $(document).on('click', '#myPlaylistQueue', function() {
                $('#playlist-wrap').fadeToggle();
            });
            $('#playlist-wrap').on('click', '#myPlaylistQueue', function(event) {
                event.stopPropagation();
            });
        },
        /* Volume */
        volume: function() {
            $(".knob-mask .knob").css("transform", "rotateZ(270deg)");
            $(".knob-mask .handle").css("transform", "rotateZ(270deg)");
        }
    };
    $(document).ready(function() {
        music.init();
        /* Scrollbar */
        $(".ms_nav_wrapper").mCustomScrollbar({
            theme: "minimal",
            scrollEasing: "easeInOut",
            scrollInertia: 400
        });
        /* Queue Scrollbar */
        $(".jp_queue_list_inner").mCustomScrollbar({
            theme: "minimal",
            setHeight: 200
        });
		/* Last ul find */
		$( ".album_list_wrapper > ul:last-child" ).addClass( "last_albm_list" );
    });
    /* Preloader Js */
    jQuery(window).on('load', function() {
        setTimeout(function() {
            $('body').addClass('loaded');
        }, 500);
        /* Li Length */
        if ($('.jp-playlist ul li').length > 3) {
            $('.jp-playlist').addClass('find_li');
        }
    });
    /* Window Scroll */
    $(window).on('scroll',function() {
        var wh = window.innerWidth;
        /* Go to top */
        if ($(this).scrollTop() > 100) {
            $('.gotop').addClass('goto');
            $('body').addClass('ms_admin_bar');
        } else {
            $('.gotop').removeClass('goto');
			$('body').removeClass('ms_admin_bar');   
        }
        /* Add Fixed Class */
        if (wh > 767) {
            var h = window.innerHeight;
            var window_top = $(window).scrollTop() + 1;
            if (window_top > 100) {
                $('.ms_basic_header').addClass('ms_fixed');
            } else {
                $('.ms_basic_header').removeClass('ms_fixed');
            }
        }
    });
    $(".gotop").on("click", function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false
    });
    
    /**
     * woocommerce tabs
     */ 
    $('.woocommerce-tabs .panel.entry-content' ).hide();
    $('.woocommerce-tabs ul.tabs li a' ).on('click',function() {
    var $tab = $( this ),
    $tabs_wrapper = $tab.closest( '.woocommerce-tabs' );
        $( 'ul.tabs li', $tabs_wrapper ).removeClass( 'active' );
        $( 'div.panel.entry-content', $tabs_wrapper ).hide();
        $( 'div' + $tab.attr( 'href' ), $tabs_wrapper).show();
        $tab.parent().addClass( 'active' );
        return false;
    });
    
    $('.showcoupon').on('click',function() {
        $('.checkout_coupon').toggle();
    });
    
})(jQuery);