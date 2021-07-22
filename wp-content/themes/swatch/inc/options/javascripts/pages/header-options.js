/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    $(document).ready(function($){

        var $headerType = $('[name="'+theme+'-options[header_type]"]').closest('tr');
        var $topBarContainer = $('[name="'+theme+'-options[top_bar_swatch]"]').closest('tr');
        var $bottomBarContainer = $('[name="'+theme+'-options[bottom_bar_swatch]"]').closest('tr');
        var $fixedStaticOption = $('[name="'+theme+'-options[header_position]"]').closest('tr');

        $headerType.change(function(){
            $topBarContainer.hide();
            $bottomBarContainer.hide();
            $fixedStaticOption.hide();
            // show selected options
            switch( $(this).find('input:checked').val() ) {
                case 'standard':
                    $fixedStaticOption.show();
                break;
                case 'top_bar':
                    $topBarContainer.show();
                break;
                case 'combo':
                    $topBarContainer.show();
                    $bottomBarContainer.show();
                break;
            }
        }).trigger('change');
    });
})( jQuery );