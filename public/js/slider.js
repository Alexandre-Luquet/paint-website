'use strict';

$(function() {

    //settings for slider
    var width = 720;
    var animationSpeed = 2000;
    var pause = 3000;
    var currentSlide = 1;

    //cache DOM elements
    var $slider = $('#slider');
    var $slideContainer = $('.slides', $slider);
    var $slides = $('.slide', $slider);

    var interval;

    function startSlider() {
        interval = setInterval(function() {
            $slideContainer.animate({'margin-left': '-='+width}, animationSpeed, function() {
                if (++currentSlide === $slides.length) {
                    currentSlide = 1;
                    $slideContainer.css('margin-left', 0);
                }
            });
        }, pause);
    }
    function pauseSlider() {
        clearInterval(interval);
    }

    $slideContainer
        .on('mouseenter', pauseSlider)
        .on('mouseleave', startSlider);

    startSlider();

});



/*-----------------------------------------------------------------------
                        Gallerie modal
------------------------------------------------------------------------ */
/*----------------------------------------------
            GALLERIE MODAL
------------------------------------------------ */
$(function() {

    var $modal = $('#modal-article-content');

    $('.btn-article-content').click(function (e) {

        e.preventDefault();

        // au click faire apparaitre la modal avec show
        $modal.show();


    });


});