'use strict';

/* global PIE: false */

(function($) {
    $(document).ready(function() {
        // fix placeholders
        $('.ie8, .ie9').find('input, textarea').placeholder();
    });
    $(window).load(function() {
        // selector for ie rounded images fallback
        if (window.PIE) {

             $('.box-round .box-inner').each(function() {
                var $image = $(this).find('img');
                if($image.length){
                    // has an image , modify parents
                    $image.parent().prev().css('position','relative');
                    $image.parent().prev().css('z-index','-1');
                    $image.parent().css('z-index','-10');
                    // attach PIE in both image and link
                    PIE.attach($image[0]);
                    PIE.attach(this);
                }
                else{
                    // no image , just attach PIE to the link
                    PIE.attach(this);
                }

            });


            // Portfolio hovers
            var portfolioItems = $('.ie8').find('.portfolio-item');

            portfolioItems.each(function(){
                var figure = $(this),
                    caption = figure.find('figcaption');

                caption.css('top', '-100%');
                figure.hover(
                    function(event) {
                        caption.animate({
                            top: 0
                            }, 200);
                    },
                    function(event) {
                        caption.animate({
                            top: '-100%'
                            }, 200);
                    }
                );
            });


            // Box captions
            var boxes = $('.ie8').find('.box-round');

            boxes.each(function(){
                var box = $(this),
                    cap = box.find('.box-caption'),
                    img = box.find('figure img');

                cap.css('opacity', 0);

                box.hover(
                    function(event) {
                        cap.animate({
                            opacity: 1
                            }, 200);
                        img.hide();
                    },
                    function(event) {
                        cap.animate({
                            opacity: 0
                            }, 200);
                        img.show();
                    }
                );
            });

        }
    });
})(jQuery);