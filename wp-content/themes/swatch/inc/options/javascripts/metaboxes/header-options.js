/**
 * Oxygenna.com
 *
 * $Template:: *(TEMPLATE_NAME)*
 * $Copyright:: *(COPYRIGHT)*
 * $Licence:: *(LICENCE)*
 */
(function( $ ){
    $(document).ready(function($){
        // get the select box we need to toggle options with
        var $selectContainer = $( '#' + theme + '_show_header' );

        // hide all controls after the select
        $selectContainer.nextAll().hide();
        $selectContainer.change(function(){

            // hide all controls after the select
            $selectContainer.nextAll().hide();
            // show selected options
            switch( $selectContainer.find('[name="'+theme+'-options['+theme+'_show_header]"]').val() ) {
                case 'show':
                    $selectContainer.nextAll().show();
                break;
                case 'hide':
                    $selectContainer.nextAll().hide();
                break;
             }
        }).trigger('change');
    });
})( jQuery );