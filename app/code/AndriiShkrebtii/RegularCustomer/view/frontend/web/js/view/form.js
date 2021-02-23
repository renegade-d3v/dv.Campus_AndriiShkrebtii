define([
    'jquery',
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'andriiShkrebtiiRegularCustomerSubmitForm',
    'Magento_Ui/js/modal/modal',
    'mage/cookies'
], function ($, ko, Component, customerData, submitFormAction) {
    'use strict';

    return Component.extend({
        defaults: {
            action: '',
            productId: 0,
            hideIt: '',
            customerName: '',
            customerEmail: '',
            template: 'AndriiShkrebtii_RegularCustomer/form'
        },

        customerName: ko.observable(),
        customerEmail: ko.observable(),

        /**
         * @returns {*}
         */
        initObservable: function () {
            this._super();
            this.observe(['customerName', 'customerEmail', 'hideIt'])
            this.updatePersonalDiscountData(customerData.get('personal-discount')());
            customerData.get('personal-discount').subscribe(this.updatePersonalDiscountData.bind(this));

            return this;
        },

        /**
         * Update observable values with the ones from the localStorage
         * @param {Object} personalDiscountData
         */
        updatePersonalDiscountData: function (personalDiscountData) {
            if (personalDiscountData.hasOwnProperty('name')) {
                this.customerName(personalDiscountData.name);
            }

            if (personalDiscountData.hasOwnProperty('email')) {
                this.customerEmail(personalDiscountData.email);
            }
        },

        /**
         * Initialize modal popup and form validators
         */
        initModal: function (element) {
            this.$form = $(element);
            this.$modal = this.$form.modal({
                buttons: []
            });

            $(document).on('andrii_shkrebrii_regular_customer_open_loyal_form', this.openModal.bind(this));
        },

        /**
         * Open modal dialog
         */
        openModal: function () {
            this.$modal.modal('openModal');
        },

        /**
         * Validate request form
         */
        validateForm: function () {
            return this.$form.validation().valid();
        },

        /**
         * Validate form and send form data to the server
         */
        sendLoaylRequest: function () {
            if (!this.validateForm()) {
                return;
            }

            this.ajaxSubmit();
        },

        /**
         * Submit request via AJAX. Add form key to the post data.
         */
        ajaxSubmit: function () {
            let formData = {
                name: this.customerName(),
                email: this.customerEmail(),
                'hide_it': this.hideIt(),
                'product_id': this.productId,
                'form_key': $.mage.cookies.get('form_key'),
                isAjax: 1
            }

            submitFormAction(formData, this.action)
                .done(function () {
                    this.$modal.modal('closeModal');
                }.bind(this));
        }
    });
});
