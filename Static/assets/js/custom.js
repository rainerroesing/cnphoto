(function ($) {
    
	$(window).load(function() {
        
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
	 * Preloader
	/* ---------------------------------------------- */    
		$('.page-loader').delay(350).fadeOut('slow');
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


            $myPaddingTop = ($('.ContentBox').height() - $('.ContentWrapper').height() ) / 2;
            $('.ContentBox').css("padding-top", $myPaddingTop);

            console.log($ContentBox + "  " + $ContentWrapper + "  " + $myPaddingTop)
        }


	$(document).ready(function() {
        
    /* ---------------------------------------------- /*
	 * ISOTOPE GRID & FILTER
	/* ---------------------------------------------- */       
      // init Isotope
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
  
        
    /* ---------------------------------------------- /*
	 * FANCYBOX
	/* ---------------------------------------------- */
      	
			$('.fancybox-thumbs').fancybox({
				prevEffect : 'fade',
				nextEffect : 'fade',
                prevSpeed   : 300,
                nextSpeed   : 300,
				closeBtn  : true,
				arrows    : true,
				nextClick : true,
                margin      : [0, 0, 0, 0],
                padding   : [0, 0, 0, 1],

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				},
                beforeShow: function () {
                /* Add watermark */
                $('<div class="watermark"></div>')
                    .bind("contextmenu", function (e) {
                        return false; /* Disables right click */
                    })
                    .prependTo( $.fancybox.inner );   
                  }
			});



    /* ---------------------------------------------- /*
	 * BLOG
	/* ---------------------------------------------- */
        /* Portfolio Collapse */
        $("#longpost").click(function(){
         $("#longpost").hide();
            window.scrollBy(0, 1);	
            window.scrollBy(0, -1);	

        });
 
    /* ---------------------------------------------- /*
     * FIX TOUCH HOVER ON MOBILE
    /* ----------------------------------------------*/	
         $('body').bind('touchstart', function() {});
 
	});

})(jQuery);