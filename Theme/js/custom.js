(function ($) {

    $(window).load(function () {

        // Caching
        var win = $(window), doc = $(document);

        /* ---------------------------------------------- /*
         * WOW.JS
         /* ---------------------------------------------- */

        wow = new WOW({
            mobile: false
        });
        wow.init();

        /* ---------------------------------------------- /*
         * Footer Nav Fadein
         /* ---------------------------------------------- */
        $(window).bind("scroll", function() {
            if ($(this).scrollTop() > 1) {
                $(".rollin").fadeIn();
            } else {
                $(".rollin").stop().fadeOut();
            }
        });

        /* ---------------------------------------------- /*
         * Preloader
         /* ---------------------------------------------- */

        if (typeof cng === 'undefined') {
            $('.page-loader').delay(350).fadeOut('slow');
        }
        $('.page-loader').delay(7000).fadeOut('slow');
        $('.page-loader-sub').delay(350).fadeOut('slow');
    });

    /* ---------------------------------------------- /*
     * Vertical Content Centering
     /* ---------------------------------------------- */
    $(window).on('load resize', function () {
        $('.ContentBox').css("padding-top", "");

        ContentPadding();
    });


    function ContentPadding() {


        var $ContentBox = $(".ContentBox").height();

        var $ContentWrapper = $(".ContentWrapper").height();

        $myPaddingTop = (($('.ContentBox').height() - $('.ContentWrapper').height() ) / 2) + 50;
        $('.ContentBox').css("padding-top", $myPaddingTop);

        //console.log($ContentBox + "  " + $ContentWrapper + "  " + $myPaddingTop)
    }


    $(document).ready(function () {

        /* ---------------------------------------------- /*
         * ISOTOPE GRID & FILTER
         /* ---------------------------------------------- */
        // init Isotope

        /*

         var $grid = $('.grid').isotope({
         itemSelector: '.grid-item',
         percentPosition: true,
         masonry: {
         columnWidth: '.grid-sizer',
         }
         });

         // layout Isotope after each image loads
         $grid.imagesLoaded().progress( function() {
         $grid.isotope('layout');
         });

         /*
         // filter functions
         var filterFns = {
         };

         // bind filter button click
         $('.filters-button-group').on( 'click', 'a', function() {
         var filterValue = $( this ).attr('data-filter');
         // use filterFn if matches value
         filterValue = filterFns[ filterValue ] || filterValue;
         $grid.isotope({ filter: filterValue });
         });

         // change is-checked class on buttons
         $('.filters-button-group').each( function( i, buttonGroup ) {
         var $buttonGroup = $( buttonGroup );
         $buttonGroup.on( 'click', 'a', function() {
         $buttonGroup.find('.is-checked').removeClass('is-checked');
         $( this ).addClass('is-checked');
         });
         });
         */


        /* ---------------------------------------------- /*
         * FANCYBOX
         /* ---------------------------------------------- */

        $('.fancybox-thumbs').fancybox({
            prevEffect: 'fade',
            nextEffect: 'fade',
            prevSpeed: 300,
            nextSpeed: 300,
            closeBtn: true,
            arrows: true,
            nextClick: true,
            margin: [0, 0, 0, 0],
            padding: [0, 0, 0, 1],
            helpers: {
                thumbs: {
                    width: 50,
                    height: 50,
                    source: function (item) {
                        return $(item.element).data('thumbimg');
                    }
                },
                overlay: {
                    locked:true},
                media: {}
            }
        });


        /* ---------------------------------------------- /*
         * Mobile Menue fix
         /* ---------------------------------------------- */
        $('.nav a.filter').click(function () {
            $('.navbar-collapse').collapse('hide');
        });


        /* ---------------------------------------------- /*
         * BLOG
         /* ---------------------------------------------- */
        /* Portfolio Collapse */
        $(".expbtn a").click(function () {
            //console.log('button verschwindet');
            //window.scrollBy(0, 1);
            ///window.scrollBy(0, -1);
            $("html, body").animate({
                scrollTop: $(this).offset().top - $('#navbar').height() - 54
            }, 600);
            $(this).css('opacity', '0');


        });

        /* ---------------------------------------------- /*
         * FIX TOUCH HOVER ON MOBILE
         /* ----------------------------------------------*/
        $('body').bind('touchstart', function () {
        });

    });

})(jQuery);


/* ---------------------------------------------- */
jQuery(window).scroll(function () {
    if ( jQuery( window ).width() >= 996) {
        console.log("breiter als 996");


        var fromTopPx = 50; // distance to trigger
        var scrolledFromtop = jQuery(window).scrollTop();
        if (scrolledFromtop > fromTopPx) {
            jQuery('.logo').css("width", "125px");
            jQuery('.logo').css("padding", "15px 0 10px 0");
            jQuery('.navbar-nav').css("padding-top", "40px");
        } else {
            jQuery('.logo').css("width", "200px");
            jQuery('.logo').css("padding", "25px 0 20px 0");
            jQuery('.navbar-nav').css("padding-top", "80px");

        }
    }
});
