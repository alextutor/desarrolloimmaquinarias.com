/**
 * @package   FFW.Press License Manager
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh. All Rights Reserved.
 */

jQuery(document).ready(function ($) {
    var ffwp_license_manager = {
        init: function () {
            $('.ffwp-deactivate-license').on('click', this.deactivate);
        },

        /**
         * Trigger deactivate method to remove key from db and call deactivate API.
         */
        deactivate: function () {
            var self = this;

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    key: $(self).data('key'),
                    item_id: $(self).data('item-id'),
                    action: 'ffwp_license_manager_deactivate'
                },
                complete: function () {
                    location.reload();
                }
            });
        }
    }
    ffwp_license_manager.init();
});