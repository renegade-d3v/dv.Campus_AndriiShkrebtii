define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'Magento_Customer/js/customer-data',
        'Magento_Customer/js/model/authentication-popup',
        'Magento_Customer/js/action/login',
        'andriiShkrebtiiRegularCustomerForm'
    ],
    function ($, ko, Component, customerData, authenticationPopup, loginAction) {
        'use strict';

        return Component.extend({
            defaults: {
                allowForGuests: !!customerData.get('personal-discount')().allowForGuests,
                requestAlreadySent: false,
                template: 'AndriiShkrebtii_RegularCustomer/button',
                personalDiscount: customerData.get('personal-discount'),
                listens: {
                    personalDiscount: 'checkRequestAlreadySent'
                }
            },

            /**
             * @returns {*}
             */
            initialize: function () {
                loginAction.registerLoginCallback(function () {
                    customerData.invalidate(['*']);
                });

                this._super();

                this.checkRequestAlreadySent(this.personalDiscount());
                this.openRequestFormAfterSectionReload = false;

                return this;
            },

            /**
             * @returns {*}
             */
            initObservable: function () {
                this._super();
                this.observe(['allowForGuests', 'requestAlreadySent']);
                return this;
            },

            /**
             * Generate event to open the form
             */
            openRequestForm: function () {

                // Customer data may not be initialized yet or is not available on the first page load
                // But we still need configurations, so must load the section before showing the button
                if (Object.keys(this.personalDiscount()).length > 0) {
                    if (this.allowForGuests() || !!this.personalDiscount().isLoggedIn) {
                        $(document).trigger('andrii_shkrebrii_regular_customer_open_loyal_form');
                    } else {
                        authenticationPopup.showModal();
                    }
                } else {
                    this.openRequestFormAfterSectionReload = true;
                    customerData.reload(['personal-discount']);
                }

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

                this.allowForGuests(!!personalDiscountData.allowForGuests);

                if (this.openRequestFormAfterSectionReload) {
                    this.openRequestFormAfterSectionReload = false;
                    this.openRequestForm();
                }

                return personalDiscountData;
            }
        });
    }
);

