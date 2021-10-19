/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh
 * @license   BY-NC-ND-4.0
 *            http://creativecommons.org/licenses/by-nc-nd/4.0/
 */

jQuery(document).ready(function ($) {
    var omgf_pro_admin = {
        processing_options: [
            'omgf_pro_safe_mode',
            'omgf_pro_process_stylesheets',
            'omgf_pro_process_stylesheet_imports',
            'omgf_pro_process_stylesheet_font_faces',
            'omgf_pro_process_inline_styles',
            'omgf_pro_process_webfont_loader',
            'omgf_pro_process_early_access',
            'omgf_pro_process_resource_hints'
        ],
        nonce: $('#omgf-pro-run-cron').data('nonce'),

        /**
         * Bind events
         */
        init: function () {
            $('#omgf_pro_advanced_processing').on('change', this.advanced_processing);
            $('input[name="omgf_optimization_mode"]').on('change', this.toggle_batch_size_option);
            $('#omgf-pro-run-cron, #omgf-pro-run-cron-notice').on('click', this.run_cron);
        },

        advanced_processing: function () {
            if (!this.checked) {
                omgf_pro_admin.processing_options.forEach(function (id) {
                    document.getElementById(id).disabled = true;
                });
            } else {
                omgf_pro_admin.processing_options.forEach(function (id) {
                    document.getElementById(id).disabled = false;
                });
            }
        },

        toggle_batch_size_option: function () {
            var batch_size_option_row = $('.omgf-automatic-optimization-mode');

            if (this.value == 'auto') {
                batch_size_option_row.show();
            } else {
                batch_size_option_row.hide();
            }
        },

        run_cron: function () {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'omgf_pro_run_cron',
                    nonce: omgf_pro_admin.nonce
                },
                beforeSend: function () {
                    /**
                     * @since v3.0.0
                     * @requires OMGF v4.5.7
                     */
                    if (typeof omgf_show_loader === 'function') {
                        omgf_show_loader();
                    }
                },
                complete: function () {
                    location.reload();
                }
            });
        }
    };

    omgf_pro_admin.init();
});
