define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'andriiShkrebtiiRegularCustomerForm'
    ],
    function ($, ko, Component, customerData) {
        'use strict';

        return Component.extend({
            defaults: {
                productId: 0,
                requestAlreadySent: false,
                template: 'AndriiShkrebtii_RegularCustomer/button',
                personalDiscount: customerData.get('personal-discount')
            },

            /**
             * @returns {*}
             */
            initObservable: function () {
                this._super();
                this.observe(['requestAlreadySent']);
                return this;
            },

            /**
             * @returns {*}
             */
            initLinks: function () {
                this._super();
                this.checkRequestAlreadySent(this.personalDiscount());

                return this;
            },

            /**
             * Generate event to open the form
             */
            openRequestForm: function () {
                $(document).trigger('andrii_shkrebrii_regular_customer_open_loyal_form');
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
            }
        });
    }
);

