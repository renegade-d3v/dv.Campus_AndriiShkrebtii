define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'mage/translate',
        'Magento_Ui/js/modal/alert'
    ],
    function ($, ko, Component, customerData) {
        'use strict';

        return Component.extend({
            defaults: {
                productId: 0,
                requestAlreadySent: false,
                template: 'AndriiShkrebtii_RegularCustomer/button'
            },

            /**
             * @returns {*}
             */
            initObservable: function () {
                this._super();
                this.observe(['requestAlreadySent']);
                this.checkRequestAlreadySent(customerData.get('personal-discount')());
                customerData.get('personal-discount').subscribe(this.checkRequestAlreadySent.bind(this));

                return this;
            },

            /**
             * Check if the product has already been requested by the customer
             */
            checkRequestAlreadySent: function (personalDiscountData) {
                if (personalDiscountData.hasOwnProperty('productIds') &&
                    personalDiscountData.productIds.indexOf(this.productId) !== -1
                ) {
                    this.requestAlreadySent(true);
                }
            },

            /**
             * Generate event to open the form
             */
            openRequestForm: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_open_loyal_form');
            }
        });

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
                        'product_id': this.options.productId
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
    }
);

