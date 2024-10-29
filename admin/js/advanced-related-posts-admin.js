(function( $ ) {
	'use strict';
    $.fn.serializeFormJSON = function () {
        var o = {},
            a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };

    $.fn.goToTop = function() {
        this.get(0).scrollIntoView({
            block: "center",
            behavior: "smooth"
        });
    }

    $.fn.goTo = function() {
        $('html, body').animate({
            scrollTop: this.offset().top - 200 + 'px'
        }, 'fast');
        return this; // for chaining...
    }

	$(document).ready(function () {

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
        
        var toggle_ddmenu = $(document).find('.toggle_ddmenu');
        toggle_ddmenu.on('click', function () {
            var ddmenu = $(this).next();
            var state = ddmenu.attr('data-expanded');
            switch (state) {
                case 'true':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(0deg)'
                    });
                    ddmenu.attr('data-expanded', 'false');
                    break;
                case 'false':
                    $(this).find('.ays_fa').css({
                        transform: 'rotate(90deg)'
                    });
                    ddmenu.attr('data-expanded', 'true');
                    break;
            }
        });
        
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();

        $(document).on('change', '.ays_toggle_checkbox', function (e) {
            var state = $(this).prop('checked');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });
        
        $(document).on('change', '.ays_toggle_select', function (e) {
            var state = $(this).val();
            var toggle = $(this).data('hide');
            var parent = $(this).parents('.ays_toggle_parent');
            
            if($(this).hasClass('ays_toggle_slide')){
                if (toggle == state) {
                    parent.find('.ays_toggle_target').slideUp(250);
                    parent.find('.ays_toggle_target_inverse').slideDown(150);
                }else{
                    parent.find('.ays_toggle_target').slideDown(150);
                    parent.find('.ays_toggle_target_inverse').slideUp(250);
                }
            }else{
                if (toggle == state) {
                    parent.find('.ays_toggle_target').hide(150);
                    parent.find('.ays_toggle_target_inverse').show(250);
                }else{
                    parent.find('.ays_toggle_target').show(250);
                    parent.find('.ays_toggle_target_inverse').hide(150);
                }
            }
        });

        $(document).on('click', '.ays_toggle_radio', function (e) {
            var dataFlag = $(this).attr('data-flag');
            var state = false;
            if (dataFlag == 'true') {
                state = true;
            }
            var parent = $(this).parents('.ays_toggle_parent');
            if($(this).hasClass('ays_toggle_slide')){
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').slideDown(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').slideUp(250);
                        break;
                }
            }else{
                switch (state) {
                    case true:
                        parent.find('.ays_toggle_target').show(250);
                        break;
                    case false:
                        parent.find('.ays_toggle_target').hide(250);
                        break;
                }
            }
        });

        // Tabulation
        $(document).find('.nav-tab-wrapper a.nav-tab').on('click', function (e) {
            if(! $(this).hasClass('no-js')){
                var elemenetID = $(this).attr('href');
                var active_tab = $(this).attr('data-tab');
                $(document).find('.nav-tab-wrapper a.nav-tab').each(function () {
                    if ($(this).hasClass('nav-tab-active')) {
                        $(this).removeClass('nav-tab-active');
                    }
                });
                $(this).addClass('nav-tab-active');
                $(document).find( $class_prefix + 'tab-content').each(function () {
                    $(this).css('display', 'none');
                });
                $(document).find("[name='"+ $name_prefix +"tab']").val(active_tab);
                $( $class_prefix + 'tab-content' + elemenetID).css('display', 'block');
                e.preventDefault();
            }
        });

        // Submit buttons disableing with loader
        $(document).find('.ays-arp-loader-banner').on('click', function () {        
            var $this = $(this);
            submitOnce($this);
        });

        function submitOnce(subButton){
            var subLoader = subButton.parents('div').find('.ays_arp_loader_box');
            if ( subLoader.hasClass("display_none") ) {
                subLoader.removeClass("display_none");
            }
            subLoader.css({
                "padding-left": "8px",
                "display": "inline-block"
            });

            setTimeout(function() {
                $(document).find('.ays-arp-loader-banner').attr('disabled', true);
            }, 10);

            setTimeout(function() {
                $(document).find('.ays-arp-loader-banner').attr('disabled', false);
                subButton.parents('div').find('.ays_arp_loader_box').css('display', 'none');
            }, 5000);

        }


        // =======================  //  ======================= // ======================= // ======================= // ======================= //


        // ===============================================================
        // ======================      Ani      ==========================
        // ========================== Start ==============================

        // Enable/Disable Post Type Options
        $(document).find($class_prefix + "enable-disable-options").on('click',function(){
            var _this = $(this);
            var parent = _this.parents('.ays-arp-enable_disable_options_main');

            var enableDisableArpOption = _this.prop('checked');
            var noPostFoundOptionsVal  = _this.val();

            var mainDiv = parent.find("div"+ $class_prefix +"enable-disable-options-div-js");
            var noPostFoundOptionsdiv = parent.find("div"+ $class_prefix +"enable-disable-options-div-js");

            var allPostTypeOptions = mainDiv.attr('data-name');
            var responsiveWHOptions = _this.attr('data-name');

            // Labels and fields
            var arpOptiionsLabel = parent.find("div"+ $class_prefix +"enable-disable-options-div-js").find(""+ $class_prefix +"enable-options-label");
            var arpOptiionsfield = parent.find("div"+ $class_prefix +"enable-disable-options-div-js").find(""+ $class_prefix +"enable-options-field");

            var thumbnailOptions = parent.find($class_prefix +'enable-disable-options-thumbnail-size-option');
            var respRatioOption  = parent.find($class_prefix +'enable-disable-options-ratio-option');

            arpOptiionsLabel.css("opacity" , 1);
            arpOptiionsfield.prop("disabled" , false);
            
            if(enableDisableArpOption){
                if(allPostTypeOptions == 'ays-arp-all-post-type'){
                    mainDiv.css({
                        "pointer-events" : "none",
                        "opacity" : "0.5"
                    });

                    arpOptiionsLabel.css("opacity" , 0.5);
                    arpOptiionsfield.prop("disabled" , true);
                }else{
                    mainDiv.css({
                        "pointer-events" : "all",
                        "opacity" : "1"
                    });

                    arpOptiionsLabel.css("opacity" , 1);
                    arpOptiionsfield.prop("disabled" , false);
                }
                if(noPostFoundOptionsVal == 'display_custom_text'){
                    noPostFoundOptionsdiv.css({
                        "pointer-events" : "all",
                        "opacity" : "1"
                    });
                }else if(noPostFoundOptionsVal == 'blank_output'){
                    noPostFoundOptionsdiv.css({
                        "pointer-events" : "none",
                        "opacity" : "0.5"
                    });
                }
            }else{
                if(allPostTypeOptions == 'ays-arp-all-post-type'){
                    mainDiv.css({
                        "pointer-events" : "all",
                        "opacity" : "1"
                    });

                    arpOptiionsLabel.css("opacity" , 1);
                    arpOptiionsfield.prop("disabled" , false);
                }else{
                    mainDiv.css({
                        "pointer-events" : "none",
                        "opacity" : "0.5"
                    });
                    arpOptiionsLabel.css("opacity" , 0.5);
                    arpOptiionsfield.prop("disabled" , true);
                }
            }

            if(responsiveWHOptions == 'responsive_hw_checked' && enableDisableArpOption){
                thumbnailOptions.css({
                    "pointer-events" : "none",
                    "opacity" : "0.5"
                });
                respRatioOption.css({
                    "pointer-events" : "all",
                    "opacity" : "1"
                });
            }else{
                thumbnailOptions.css({
                    "pointer-events" : "all",
                    "opacity" : "1"
                });
                respRatioOption.css({
                    "pointer-events" : "none",
                    "opacity" : "0.5"
                });
            }
        });

        $(document).find( $class_prefix + "thumbnail_responsive_width_height").on('change', function() {
            var _this = $(this);
            var parent = _this.parents( $class_prefix + 'tab-content');

            var is_checked = _this.prop('checked');

            var widthHeightBox = parent.find('.thumbnail-width-height-box');
            var nextHr = widthHeightBox.next('hr');

            if ( is_checked ) {
                if ( ! widthHeightBox.hasClass( 'display_none_not_important' ) ) {
                    widthHeightBox.slideUp(250).removeClass( 'display_none_not_important' );
                    widthHeightBox.addClass( 'display_none_not_important' );
                    nextHr.addClass( 'display_none_not_important' );
                }
            } else {
                if ( widthHeightBox.hasClass( 'display_none_not_important' ) ) {
                    widthHeightBox.slideDown({
                      start: function () {
                        $(this).css({
                          "display": "flex"
                        })
                      },
                      duration: 250
                    });
                    widthHeightBox.removeClass( 'display_none_not_important' );
                    nextHr.removeClass( 'display_none_not_important' );
                }
            }
        });

        $(document).on('click', 'a'+ $class_prefix +'add-bg-image', function (e) {
            openMediaUploaderBg(e, $(this));
        });

        $(document).on('click', $class_prefix + 'remove-bg-img', function () {
            var _this = $(this);
            var parent = _this.parents('.ays_toggle_parent');
            
            var defaultThumbnail = AdvencedRelatedPostsAdmin.defaultThumbnailUrl;

            parent.find($class_prefix +'default_thumbnail_img').attr('src', defaultThumbnail);
            parent.find($class_prefix +'default_image').val( defaultThumbnail );
        });

        // ===============================================================
        // ======================      Ani      ==========================
        // =========================== End ===============================
   
    });

})( jQuery );
