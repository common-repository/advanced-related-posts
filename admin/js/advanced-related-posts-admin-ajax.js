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

    $(document).ready(function() {

    // ===============================================================
    // ======================      Aro      ==========================
    // ========================== Start ==============================




    // ===============================================================
    // ======================      Aro      ==========================
    // =========================== End ===============================


    // =======================  //  ======================= // ======================= // ======================= // ======================= //


    // ===============================================================
    // ======================      Ani      ==========================
    // ========================== Start ==============================

    $(document).find('.ays-arp-exclude-by-categories').select2({
        placeholder: AdvencedRelatedPostsAdmin.excludeCategories,
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: AdvencedRelatedPostsAdmin.ajaxUrl,
            dataType: 'json',
            data: function (results) 
            {
                var arpExcludeCategories = $(document).find('.ays-arp-exclude-by-categories').val();
                return{
                    action: 'ays_advanced_related_posts_admin_ajax',
                    function: 'ays_advanced_related_posts_exlude_categories',
                    search: results.term,
                    val: arpExcludeCategories,
                };
            }
        }
    });
    
    // ===============================================================
    // ======================      Ani      ==========================
    // =========================== End ===============================
    
    });
})( jQuery );