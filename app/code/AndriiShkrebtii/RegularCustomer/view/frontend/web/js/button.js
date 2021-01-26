define(
    [
        'jquery',
        'jquery/ui'
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
                $(this.element).show();
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
                        if (response.result === false) {
                            this.openRegistrationForm();
                        } else {
                            this.showAlreadyRegisteredMessage();
                        }
                    },

                    /** @inheritdoc */
                    error: function () {
                        alert({
                            title: $.mage.__('Error'),
                            content: $.mage.__('Your request can\'t be sent. Please, contact us if you see this message.')
                        });
                    }
                });
            }
        });

        return $.andriiShkrebtii.regularCustomerButton;
    }
);

