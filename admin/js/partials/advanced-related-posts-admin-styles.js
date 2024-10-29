(function($){
    'use strict';
    $(document).ready(function(){

        // ===============================================================
        // ========================= Prefixes ============================
        // ===============================================================

        var $ays_prefix   = 'ays_';
        var $name_prefix  = 'ays_arp_';
        var $id_prefix    = '#ays-arp-';
        var $class_prefix = '.ays-arp-';

        // ===============================================================
        // ========================= Prefixes ============================
        // ===============================================================

        var defaultColors = {
            elegant: {
                textColor: "#333"
            },
            classy: {
                textColor: "#333"
            },
            grid: {
                textColor: "#333"
            }
        };
        
        var RelatedPostsLayout = $(document).find( $class_prefix + 'layouts' ).val();
        RelatedPostsLayoutSetup( RelatedPostsLayout );

        function RelatedPostsLayoutSetup( layout ){
            var defaultTextColor;

            switch ( layout ) {
                case 'elegant':
                    defaultTextColor = defaultColors.elegant.textColor;
                    break;
                case 'classy':
                    defaultTextColor = defaultColors.classy.textColor;
                    break;
                case 'grid':
                    defaultTextColor = defaultColors.classy.textColor;
                    break;
                default:
                    defaultTextColor = defaultColors.elegant.textColor;
                    break;
            }

            var ays_arp_text_color_picker = {
                defaultColor: defaultTextColor,
                change: function (e) {
                }
            };

            // Initialize color pickers
            $(document).find( $class_prefix + 'text-color').wpColorPicker(ays_arp_text_color_picker);
        }
        
        $(document).find( $class_prefix + 'layouts' ).on('change', function() {

            var RelatedPostsLayout = $(document).find( $class_prefix + 'layouts' ).val();

            RelatedPostsLayoutChange( RelatedPostsLayout );
        } );

        function RelatedPostsLayoutChange( layout ){
            var defaultTextColor;

            switch ( layout ) {
                case 'elegant':
                    defaultTextColor = defaultColors.elegant.textColor;
                    break;
                case 'classy':
                    defaultTextColor = defaultColors.classy.textColor;
                    break;
                case 'grid':
                    defaultTextColor = defaultColors.classy.textColor;
                    break;
                default:
                    defaultTextColor = defaultColors.elegant.textColor;
                    break;
            }

            // Initialize color pickers
            $(document).find( $class_prefix + 'text-color').wpColorPicker('color', defaultTextColor);

            var thumbnailRatio = $(document).find( $class_prefix + 'thumbnail-ratio' );
            var readonlyAttr = thumbnailRatio.attr('readonly');

            if ( layout == 'grid' ) {
                thumbnailRatio.val(1);
                thumbnailRatio.prop( "readonly", true );
            } else {
                if (typeof readonlyAttr !== 'undefined' && readonlyAttr !== false) {
                    thumbnailRatio.removeAttr("readonly");
                }
            }
        }
    });
})(jQuery);
