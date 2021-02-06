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
                this.ajaxRequest();
                $(this.element).click(this.openRequestForm.bind(this));
                $(document).trigger('andrii_shkrebrii_regular_customer_show_message');
            },

            /**
             * Generate event to displayed message
             */
            showAlreadyRegisteredMessage: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_show_message');
                $(this.element).hide();
            },

            /**
             * Generate event to open the form
             */
            openRequestForm: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_open_loyal_form');
            },


            /**
             * Submit request via AJAX. Add product id to the post data.
             */
            ajaxRequest: function () {
                $.ajax({
                    url: this.options.url,
                    data: {
                        'isAjax': 1,
                        'productId': this.options.productId
                    },
                    type: 'get',
                    dataType: 'json',
                    context: this,

                    /** @inheritdoc */
                    success: function (response) {
                        if (response.result) {
                            this.showAlreadyRegisteredMessage();
                        }
                    }
                });
            }
        });

        return $.andriiShkrebtii.regularCustomerButton;
    }
);

