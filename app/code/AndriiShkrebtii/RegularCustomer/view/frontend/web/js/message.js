define([
    'jquery',
    'jquery/ui'
], function ($) {
    'use strict';

    $.widget('andriiShkrebtii.regularCustomerMessage', {
        /**
         * Constructor
         * @private
         */
        _create: function () {
            $(document).on('andrii_shkrebrii_regular_customer_show_message', this.showMessage.bind(this));
        },

        /**
         * Generate event to show message
         */
        showMessage: function () {
            $(this.element).show();
        }
    });

    return $.andriiShkrebtii.regularCustomerMessage;
});
