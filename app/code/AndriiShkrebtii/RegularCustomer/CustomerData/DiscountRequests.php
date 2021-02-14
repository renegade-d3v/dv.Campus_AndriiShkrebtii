<?php

declare(strict_types=1);

namespace AndriiShkrebtii\RegularCustomer\CustomerData;

use AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\Collection as DiscountRequestCollection;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession
     */
    private $customerSession;

    /**
     * @var \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
     * $discountRequestCollectionFactory
     */
    private $discountRequestCollectionFactory;

    /**
     * DiscountRequests constructor.
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
     * $discountRequestCollectionFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \AndriiShkrebtii\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory
        $discountRequestCollectionFactory
    ) {
        $this->customerSession = $customerSession;
        $this->discountRequestCollectionFactory = $discountRequestCollectionFactory;
    }

    /**
     * @return array|void
     */
    public function getSectionData(): ? array
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerEmail = $this->customerSession->getCustomer()->getEmail();
        /** @var DiscountRequestCollection $discountRequestCollection */
            $discountRequestCollection = $this->discountRequestCollectionFactory->create();
            $discountRequestCollection->addFieldToFilter('customer_id', $this->customerSession->getCustomerId());
            $productIds = $discountRequestCollection->getColumnValues('product_id');
        } else {
            $customerEmail = $this->customerSession->getDiscountRequestCustomerEmail();
            $productIds = $this->customerSession->getDiscountRequestProductIds();
        }
        return [
            'email' => $customerEmail,
            'productIds' => $productIds
        ];
    }
}
