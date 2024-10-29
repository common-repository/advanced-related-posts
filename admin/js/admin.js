(function ($) {
    'use strict';

    $(document).on('click', '[data-slug="advanced-related-posts"] .deactivate a', function () {
        swal({
            html:"<h2>Do you want to upgrade to Pro version or permanently delete the plugin?</h2><ul><li>Upgrade: Your data will be saved for upgrade.</li><li>Uninstall: Your data will be deleted completely.</li></ul>",
            type: 'question',
            showCloseButton: true,
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Upgrade',
            cancelButtonText: 'Deactivate'
        }).then(function(result) {

            if( result.dismiss && result.dismiss == 'close' ){
                return false;
            }

            var upgrade_plugin = false;
            if (result.value) upgrade_plugin = true;
            var data = {
                action: 'ays_advanced_related_posts_admin_ajax', 
                function: 'deactivate_plugin_option_arp', 
                upgrade_plugin: upgrade_plugin
            };
            $.ajax({
                url: AdvencedRelatedPostsAdmin.ajaxUrl,
                method: 'post',
                dataType: 'json',
                data: data,
                success:function () {
                    window.location = $(document).find('[data-slug="advanced-related-posts"]').find('.deactivate').find('a').attr('href');
                }
            });
        });
        return false;
    });
})(jQuery);