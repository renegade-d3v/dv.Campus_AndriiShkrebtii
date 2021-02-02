define(
    [
        'jquery',
        'jquery/ui',
        'mage/translate',
        'Magento_Ui/js/modal/alert'
    ],
    function ($) {
        'use strict';

        $.widget('andriiShkrebtii.regularCustomerButton', {
            options: {
                url: '',
                productId: ''
            },

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
            },

            /**
             * Generate event to displayed message
             */
            showAlreadyRegisteredMessage: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_show_message');
                $(this.element).hide();
            }
        });

        return $.andriiShkrebtii.regularCustomerButton;
    }
);

