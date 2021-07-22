/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    $(document).ready(function($){
        var $headerContainer   = $('[name="'+theme+'-options['+theme+'_category_header_type]"]').closest('table');
        var $headerOption      = $('[name="'+theme+'-options['+theme+'_category_header_type]"]');
        var $sliderContainer   = $('[name="'+theme+'-options['+theme+'_category_revolution]"]').closest('table');
        var $subtitleContainer = $('[name="'+theme+'-options['+theme+'_category_header_subtitle]"]').closest('table');

        $headerContainer.change(function(){
            $sliderContainer.hide();
            $subtitleContainer.hide();
            // show selected options
            switch( $headerOption.val() ) {
                case 'slideshow':
                    $sliderContainer.show();
                break;
                case 'text':
                    $subtitleContainer.show();
                default:
                    break;
            }
         }).trigger('change');
    });
})( jQuery );