/**
 * Created by svenruoff on 02.09.15.
 */
$(window).load(function () {

    console.log('load');


    jQuery('.testSlider').slick({
        dots: true,
        infinite: true,


    });


});
/*DOUMENT READY  FUNCTION - START -----------------------*/

jQuery(document).ready(function () {
    console.log('%c document ready ', 'background: #222; color: #bada55');


    // init Scrollmagic
    var ctrl = new ScrollMagic.Controller({
        globalSceneOptions: {
            triggerHook: 'onCenter'
        }
    });

    var MAINNAVIGATION = jQuery('#MAINNAVIGATION'),
        BODY = jQuery('body');


    /* Animation Navigationsleiste  -----------------------*/

    var naviTl = new TimelineMax();
    naviTl
        .to(MAINNAVIGATION, 1, {backgroundColor: "rgba(255,255,266,0.95)", ease: Power4.easeIn}, '0')

    new ScrollMagic.Scene({
        triggerElement: BODY[0],
        duration: '80%'
    })
        .setTween(naviTl)
        .addIndicators({name: "Nav"})

        .addTo(ctrl);

    /* Animation Navigationsleiste ende  -----------------------*/


});
/*DOUMENT READY  FUNCTION - END -----------------------*/


