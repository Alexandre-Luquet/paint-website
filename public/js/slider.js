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


    $('.btn-article-content').click(function (e) {

        e.preventDefault();

        var href = $(this).attr('href');

        $.get(
            href,
            function (response) {

                var $modal = $('#modal-article-content');

                $('.modal-body', $modal).html(response);

                // afficher la modal
                $modal.modal('show');

            }
        )


    });

    $('.fermer').click(function (e) {

        e.preventDefault();

        var $modal = $('#modal-article-content');

        $modal.modal('hide');

    })

    $('.close').click(function (e) {

        e.preventDefault();

        var $modal = $('#modal-article-content');

        $modal.modal('hide');
    })


});


/*---------------------------------------------------------------
                        MODAL TABLEAUX ACCEUIL
--------------------------------------------------------------*/

$(function () {

    let $modal = $('#modal-tableau-content');

    $('.btn-tableau-content').click(function (e) {

        e.preventDefault();

        $modal.show();

    })

    $('.close').click(function (e) {

        e.preventDefault();

        $modal.hide();
    })

    $('.close-modal').click(function (a) {

        a.preventDefault();

        $modal.hide();
    })

});