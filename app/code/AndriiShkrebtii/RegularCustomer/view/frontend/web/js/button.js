define(
    [
        'jquery',
        'jquery/ui'
    ],
    function ($) {
        'use strict';

        $.widget('andriiShkrebtii.regularCustomerButton', {
            /**
             * Constructor
             * @private
             */
            _create: function () {
                $(this.element).click(this.openRequestForm.bind(this));
            },

            /**
             * Generate event to open the form
             */
            openRequestForm: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_open_loyal_form');
            }
        });

        return $.andriiShkrebtii.regularCustomerButton;
    }
);

