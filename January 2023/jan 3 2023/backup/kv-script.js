jQuery(function($) {
    //Home Swiper Slider
    const swiper = new Swiper(".home-slider", {
        slidesPerView: 1,
        loop: true,
        freeMode: true,
        allowTouchMove: false,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    //Customize Your Piece Carousel

    let activeCypContent = (index) => {
        $('.cyp-content .cyp-row').hide()
        $('.cyp-content .cyp-row').eq(index).fadeIn(200)
    }

    const swiper_2 = new Swiper(".cyp-slider", {
        speed: 1000,
        autoplay: false,
        allowTouchMove: false,
        effect: 'coverflow',
        grabCursor: true,
        initialSlide: 3,
        centeredSlides: true,
        slidesPerView: '3',
        loop: true,
        coverflowEffect: {
            rotate: 0,
            stretch: 0,
            depth: 200,
            modifier: 1,
            slideShadows: true,
       },
        breakpoints: {
          1024: {
            coverflowEffect: {
            rotate: 0,
            stretch: 100,
            depth: 200,
            modifier: 1,
        },
          },
        },
        navigation: {
            nextEl: '.swiper-right-carousel',
            prevEl: '.swiper-left-carousel',
        },
        on: {
            afterInit: (swiper) => {
                activeCypContent(swiper.realIndex)
            },
            activeIndexChange: (swiper) => {
                activeCypContent(swiper.realIndex)
            }
        }
    });
//Product Carousel
    $(".product-slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        // loop: true,
        infinite: true,
        swipeToSlide: true,
        centerMode: true,
        arrows: true,
		lazyLoad: 'ondemand',
        prevArrow: '<div class="hc-arrow-left"><i class="fa fa-arrow-left"></i></div>',
        nextArrow: '<div class="hc-arrow-right"><i class="fa fa-arrow-right"></i></div>',
        responsive: [
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1700,
              settings: {
                slidesToShow: 3,
              }
            }
        ]
    });
	

    $('.product-slider').on('beforeChange', function(event, { slideCount: count }, currentSlide, nextSlide){
      let selectors = [nextSlide, nextSlide - count, nextSlide + count].map(n => `[data-slick-index="${n}"]`).join(', ');
      $('.slick-now').removeClass('slick-now');
      $(selectors).addClass('slick-now');
    });

    $('[data-slick-index="0"]').addClass('slick-now');


//Logo Carousel
    $(".logo-slider").slick({
        speed: 8000,
        autoplay: true,
        autoplaySpeed: 0,
        cssEase: 'linear',
        slidesToShow: 4,
        slidesToScroll: 1,
        infinite: true,
        loop: true,
        swipeToSlide: true,
        centerMode: true,
        focusOnSelect: true,
        pauseOnHover:false,
        arrows: false,
        pauseOnHover: true, 
        responsive: [
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 4,
              }
            },
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 4,
              }
            },
            {
              breakpoint: 1700,
              settings: {
                slidesToShow: 4,
              }
            }
        ]
    });

//Insta Images Carousel
    $(".insta-image-carousel").slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        speed: 300,
        infinite: true,
        loop: true,
        swipeToSlide: true,
        centerMode: true,
        focusOnSelect: true,
        pauseOnHover:false,
        arrows: false,
        pauseOnHover: true, 
        responsive: [
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 3,
              }
            },
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 4,
              }
            },
            {
              breakpoint: 1700,
              settings: {
                slidesToShow: 4,
              }
            }
        ]
    });

//Content Slider
    $(".content-slider").slick({
        autoplay: false,
        autoplaySpeed: 0,
        slidesToShow: 2,
        slidesToScroll: 1,
        loop: true,
        swipeToSlide: true,
        centerMode: true,
        arrows: false,
        responsive: [
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
              }
            },
            {
              breakpoint: 800,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 2,
              }
            },
            {
              breakpoint: 1700,
              settings: {
                slidesToShow: 2,
              }
            }
        ]
});

// //Product Owl Slider
// $(".product-slider").owlCarousel({ 
//         loop: true,
//         margin: 0,
//         mouseDrag: false,
//         autoplay: false,
//         dots: false,
//         center: true,
//         items:3,
//         nav: true,
//         stagePadding: 0,
//         navText:["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
//         responsive:{
//             0:{
//                 items:1,
//                 stagePadding: 100,
//             },
//         }
//     });


//Single Product Page Slider
$('.main-slide').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
    slidesToShow: 4,
    slidesToScroll: 1,
    variableWidth: true,
    asNavFor: '.main-slide',
    dots: false,
    arrows: true,
    prevArrow: '<div class="hc-arrow-left"><i class="fa fa-arrow-left"></i></div>',
    nextArrow: '<div class="hc-arrow-right"><i class="fa fa-arrow-right"></i></div>',
    focusOnSelect: true,
});


    //On Click Active Class Header
    $('.header-search a').click(function() {
        $('.header-search').toggleClass('active');
    });

    // Add Wishlist
    let setStorage, getStorage, addWishlist, getWishlist, isWishlist;

    setStorage = (obj) => {
        localStorage.setItem('JewelryStorage', JSON.stringify(obj))
    }

    getStorage = () => {
        let x = JSON.parse( localStorage.getItem('JewelryStorage') )
        if( x == null ) {
            x = {}
        }
        return x
    }

    addWishlist = (id) => {
        let x = getStorage()
        x[id] = true;
        
        setStorage(x)
    }

    getWishlist = (id) => {
        let x = getStorage()
        return x[id];
    }

    updateWishlist = (id) => {
        if( isWishlist(id) ) {
            let x = getStorage();
            x[id] = false;
            setStorage(x)
        }
    }

    isWishlist = (id) => {
        return getWishlist(id) === true;
    }

    $('a.product-fav').on('click', function() {
        let _this = $(this),
            pid = _this.data('prodid'),
            type = 'inc';
        
        if( _this.hasClass('active') ) {
            updateWishlist(pid)
            _this.removeClass('active');
            type = 'dec'
        } else {
            addWishlist(pid)
            _this.addClass('active')
        }

        if( pid ) {
            $.ajax({
                url: kv_script.ajaxurl,
                method: 'POST',
                data: {action: 'wishlist_counter', pid, type},
                success: function(res) {
                    console.log(res)
                }
            })
        }
    })

    $('a.product-fav').each(function() {
        let pid = $(this).data('prodid')
        if( isWishlist(pid) ) {
            // console.log( isWishlist(pid) )
            $(this).addClass('active')
        }
    })

    $(document).on('gform_page_loaded', function(event, form_id, current_page) {
        // console.log( current_page )
        if( form_id != 2 && current_page != 4 )
            return;
        /* apply only to a input with a class of gf_readonly */
        $('.readonly input, .readonly textarea').prop('readonly', true);
        $('.readonly select').attr('style', 'pointer-events: none;');
    });

//Mobile Menu
$.isMobile = (/android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(navigator.userAgent.toLowerCase()));

$('.menu-button').on('click' , function() {
    $('body').toggleClass('active-menu');
    $(this).toggleClass('open');
    $('.mobile-menu').toggleClass('active');
});


$('.menu-item-has-children').click(function () {
    $(this).toggleClass('active');
});

//Mobile Footer Accordian
if($(window).width()<767){
    $('.footer-col').find('.widget_nav_menu > div').hide();
    $('.footer-col.col-5').find('.widget_nav_menu > div').show();
    $('h2.widgettitle').on('click', function() { $(this).toggleClass('active'); $(this).next().slideToggle() });

}

});
